<?php
header('Content-Type: application/json');
include_once '../configuracion/conexion.php';

try {
    $action = $_GET['action'] ?? '';

    switch($action) {
        case 'get':
            $sql = "SELECT id, nombre, precio, duracion FROM membresias";
            $result = $conexion->query($sql);
            
            if (!$result) {
                throw new Exception("Error al obtener membresias: " . $conexion->error);
            }

            $membresias = [];
            while ($row = $result->fetch_assoc()) {
                $membresias[] = $row;
            }
            
            echo json_encode($membresias);
            break;

        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
