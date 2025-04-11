<?php
require_once '../config/database.php';
require_once '../modelos/usuario.php';

header('Content-Type: application/json');

try {
    if (!isset($conn)) {
        throw new Exception('Error de conexión a la base de datos');
    }

    $action = $_GET['action'] ?? '';

    if ($action === 'get') {
        $sql = "SELECT u.id, u.nombre, u.correo, u.telefono 
                FROM usuarios u 
                INNER JOIN usuarios_roles ur ON u.id = ur.usuario_id 
                INNER JOIN roles r ON ur.rol_id = r.id 
                WHERE r.nombre = 'entrenador'";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $entrenadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Datos obtenidos: " . print_r($entrenadores, true));

        echo json_encode([
            'success' => true,
            'data' => $entrenadores
        ]);
        exit;
    }

    if ($action === 'getById') {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
            exit;
        }

        try {
            $stmt = $conn->prepare("SELECT id, nombre, correo, telefono FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $entrenador = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$entrenador) {
                echo json_encode(['success' => false, 'error' => 'Entrenador no encontrado']);
                exit;
            }

            echo json_encode(['success' => true, 'data' => $entrenador]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    if ($action === 'add') {
        $datos = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($datos['nombre']) || !isset($datos['correo']) || !isset($datos['telefono'])) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        try {
            $conn->beginTransaction();
            
            // Generar token único para recuperación de contraseña
            $token = bin2hex(random_bytes(16));
            
            // 1. Insertar usuario sin contraseña
            $sql = "INSERT INTO usuarios (nombre, correo, telefono, verificado, token_recuperacion, fecha_token) 
                    VALUES (:nombre, :correo, :telefono, 1, :token, NOW())";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':correo' => $datos['correo'],
                ':telefono' => $datos['telefono'],
                ':token' => $token
            ]);
            
            $usuario_id = $conn->lastInsertId();
            
            // 2. Obtener el rol_id de entrenador
            $stmt = $conn->prepare("SELECT id FROM roles WHERE nombre = 'entrenador'");
            $stmt->execute();
            $rol = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // 3. Asignar rol
            $stmt = $conn->prepare("INSERT INTO usuarios_roles (usuario_id, rol_id) VALUES (:usuario_id, :rol_id)");
            $stmt->execute([
                ':usuario_id' => $usuario_id,
                ':rol_id' => $rol['id']
            ]);
            
            // 4. Enviar correo con link de configuración de contraseña
            $model = new UsuarioModel($conn);
            $model->sendPasswordSetupEmail($datos['nombre'], $datos['correo'], $token);
            
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Entrenador creado correctamente. Se ha enviado un correo para configurar la contraseña.']);
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    if ($action === 'update') {
        $datos = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($datos['id']) || !isset($datos['nombre']) || !isset($datos['correo']) || !isset($datos['telefono'])) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        try {
            $sql = "UPDATE usuarios 
                    SET nombre = :nombre, correo = :correo, telefono = :telefono 
                    WHERE id = :id AND id IN (
                        SELECT usuario_id FROM usuarios_roles ur 
                        INNER JOIN roles r ON ur.rol_id = r.id 
                        WHERE r.nombre = 'entrenador'
                    )";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':id' => $datos['id'],
                ':nombre' => $datos['nombre'],
                ':correo' => $datos['correo'],
                ':telefono' => $datos['telefono']
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Entrenador actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se encontró el entrenador o no se realizaron cambios']);
            }
            exit;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    if ($action === 'delete') {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
            exit;
        }

        try {
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);

            echo json_encode(['success' => true, 'message' => 'Entrenador eliminado correctamente']);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    error_log("Error en el controlador de entrenadores: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}