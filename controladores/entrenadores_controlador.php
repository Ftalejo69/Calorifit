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
        $sql = "SELECT u.id, u.nombre, u.correo, u.telefono, u.imagen 
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
            $stmt = $conn->prepare("SELECT id, nombre, correo, telefono, imagen FROM usuarios WHERE id = :id");
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
        // Verificar si se envió una imagen
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Debe proporcionar una imagen']);
            exit;
        }

        // Validar el tipo de archivo
        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['imagen']['type'], $allowed)) {
            echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido. Use JPG, PNG o GIF']);
            exit;
        }

        // Validar el tamaño (máximo 2MB)
        if ($_FILES['imagen']['size'] > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'error' => 'La imagen no debe superar los 2MB']);
            exit;
        }

        // Generar nombre único para la imagen
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagen_nombre = uniqid('entrenador_') . '.' . $extension;
        $ruta_destino = '../publico/imagenes/' . $imagen_nombre;

        // Mover la imagen al directorio
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            echo json_encode(['success' => false, 'error' => 'Error al guardar la imagen']);
            exit;
        }

        try {
            $conn->beginTransaction();
            
            // Generar token único para recuperación de contraseña
            $token = bin2hex(random_bytes(16));
            
            // 1. Insertar usuario con la imagen
            $sql = "INSERT INTO usuarios (nombre, correo, telefono, verificado, token_recuperacion, fecha_token, imagen) 
                    VALUES (:nombre, :correo, :telefono, 1, :token, NOW(), :imagen)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nombre' => $_POST['nombre'],
                ':correo' => $_POST['correo'],
                ':telefono' => $_POST['telefono'],
                ':token' => $token,
                ':imagen' => $imagen_nombre
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
            
            // 4. Enviar correo
            $model = new UsuarioModel($conn);
            $model->sendPasswordSetupEmail($_POST['nombre'], $_POST['correo'], $token);
            
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Entrenador creado correctamente. Se ha enviado un correo para configurar la contraseña.']);
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            // Si hay error, eliminar la imagen subida
            if (file_exists($ruta_destino)) {
                unlink($ruta_destino);
            }
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    if ($action === 'update') {
        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
            exit;
        }

        try {
            $imagen_nombre = null;
            
            // Si se envió una nueva imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Validar el tipo de archivo
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['imagen']['type'], $allowed)) {
                    echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido. Use JPG, PNG o GIF']);
                    exit;
                }

                // Validar el tamaño
                if ($_FILES['imagen']['size'] > 2 * 1024 * 1024) {
                    echo json_encode(['success' => false, 'error' => 'La imagen no debe superar los 2MB']);
                    exit;
                }

                // Generar nombre único
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $imagen_nombre = uniqid('entrenador_') . '.' . $extension;
                $ruta_destino = '../publico/imagenes/' . $imagen_nombre;

                // Obtener imagen anterior para eliminarla
                $stmt = $conn->prepare("SELECT imagen FROM usuarios WHERE id = :id");
                $stmt->execute([':id' => $id]);
                $imagen_anterior = $stmt->fetchColumn();

                // Mover nueva imagen
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
                    echo json_encode(['success' => false, 'error' => 'Error al guardar la imagen']);
                    exit;
                }

                // Eliminar imagen anterior si existe y no es la default
                if ($imagen_anterior && $imagen_anterior !== 'entrenador-default.jpg' && file_exists('../publico/imagenes/' . $imagen_anterior)) {
                    unlink('../publico/imagenes/' . $imagen_anterior);
                }
            }

            // Actualizar usuario
            $sql = "UPDATE usuarios 
                    SET nombre = :nombre, correo = :correo, telefono = :telefono" .
                    ($imagen_nombre ? ", imagen = :imagen" : "") .
                    " WHERE id = :id AND id IN (
                        SELECT usuario_id FROM usuarios_roles ur 
                        INNER JOIN roles r ON ur.rol_id = r.id 
                        WHERE r.nombre = 'entrenador'
                    )";
            
            $params = [
                ':id' => $id,
                ':nombre' => $_POST['nombre'],
                ':correo' => $_POST['correo'],
                ':telefono' => $_POST['telefono']
            ];

            if ($imagen_nombre) {
                $params[':imagen'] = $imagen_nombre;
            }

            $stmt = $conn->prepare($sql);
            $result = $stmt->execute($params);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Entrenador actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se encontró el entrenador o no se realizaron cambios']);
            }
            exit;
        } catch (Exception $e) {
            // Si hay error y se subió una nueva imagen, eliminarla
            if (isset($ruta_destino) && file_exists($ruta_destino)) {
                unlink($ruta_destino);
            }
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