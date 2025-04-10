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

        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
