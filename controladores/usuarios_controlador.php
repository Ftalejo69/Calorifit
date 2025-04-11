<?php
header('Content-Type: application/json');
include_once '../configuracion/conexion.php';

try {
    $action = $_GET['action'] ?? '';

    switch($action) {
        case 'get':
            // Seleccionar usuarios y convertir el campo verificado a un estado legible
            $sql = "SELECT u.id, 
                           u.nombre, 
                           u.correo, 
                           u.fecha_registro,
                           u.verificado,
                           COALESCE(r.nombre, 'usuario') AS rol,
                           CASE 
                               WHEN u.verificado = 1 THEN 'Verificado'
                               ELSE 'Pendiente'
                           END as estado 
                    FROM usuarios u
                    LEFT JOIN usuarios_roles ur ON u.id = ur.usuario_id
                    LEFT JOIN roles r ON ur.rol_id = r.id";
            
            $result = $conexion->query($sql);
            
            if (!$result) {
                throw new Exception("Error al obtener usuarios: " . $conexion->error);
            }

            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                // Formatear la fecha para mejor visualización
                $row['fecha_registro'] = date('d/m/Y', strtotime($row['fecha_registro']));
                $usuarios[] = $row;
            }
            
            echo json_encode($usuarios);
            break;

        case 'getById':
            if (!isset($_GET['id'])) {
                throw new Exception('ID de usuario no proporcionado');
            }
            
            $id = $conexion->real_escape_string($_GET['id']);
            $sql = "SELECT u.id, u.nombre, u.correo, u.verificado,
                           CASE 
                               WHEN u.verificado = 1 THEN 'activo'
                               ELSE 'inactivo'
                           END as estado 
                    FROM usuarios u 
                    WHERE u.id = '$id'";
            
            $result = $conexion->query($sql);
            
            if (!$result) {
                throw new Exception("Error al obtener usuario: " . $conexion->error);
            }

            $usuario = $result->fetch_assoc();
            if (!$usuario) {
                throw new Exception('Usuario no encontrado');
            }
            
            echo json_encode(['success' => true, 'usuario' => $usuario]);
            break;

        case 'update':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id'])) {
                throw new Exception('ID de usuario no proporcionado');
            }
            
            $id = $conexion->real_escape_string($data['id']);
            $nombre = $conexion->real_escape_string($data['nombre']);
            $correo = $conexion->real_escape_string($data['correo']);
            $verificado = $data['estado'] === 'activo' ? 1 : 0;
            
            $sql = "UPDATE usuarios SET 
                    nombre = '$nombre',
                    correo = '$correo',
                    verificado = $verificado
                    WHERE id = '$id'";
            
            if (!$conexion->query($sql)) {
                throw new Exception("Error al actualizar usuario: " . $conexion->error);
            }
            
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
            break;

        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
