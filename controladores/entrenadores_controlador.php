<?php
header('Content-Type: application/json');
include_once '../configuracion/conexion.php';

try {
    $action = $_GET['action'] ?? '';

    switch($action) {
        case 'get':
            $query = "SELECT * FROM entrenadores";
            $result = $conexion->query($query);
            if (!$result) {
                throw new Exception($conexion->error);
            }
            $entrenadores = [];
            while($row = $result->fetch_assoc()) {
                $entrenadores[] = $row;
            }
            echo json_encode($entrenadores);
            break;
        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
