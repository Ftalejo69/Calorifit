<?php
header('Content-Type: application/json');
include_once '../configuracion/conexion.php';

try {
    $action = $_GET['action'] ?? '';

    switch($action) {
        case 'get':
            $sql = "SELECT id, nombre, precio, duracion, descripcion FROM membresias";
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

        case 'getById':
            $id = $_GET['id'] ?? null;
            if (!$id) throw new Exception("ID no proporcionado");
            $sql = "SELECT id, nombre, precio, duracion FROM membresias WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $plan = $result->fetch_assoc();
                if ($plan) {
                    echo json_encode(['success' => true, 'plan' => $plan]);
                } else {
                    throw new Exception("Membresía no encontrada");
                }
            } else {
                throw new Exception("Error al obtener membresía: " . $stmt->error);
            }
            break;

        case 'create':
            $data = json_decode(file_get_contents('php://input'), true);
            $sql = "INSERT INTO membresias (nombre, precio, duracion, descripcion) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sdis", $data['nombre'], $data['precio'], $data['duracion'], $data['descripcion']);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Membresía creada correctamente']);
            } else {
                throw new Exception("Error al crear membresía: " . $stmt->error);
            }
            break;

        case 'update':
            $id = $_GET['id'] ?? null;
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$id) throw new Exception("ID no proporcionado");
            $sql = "UPDATE membresias SET nombre = ?, precio = ?, duracion = ?, descripcion = ? WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sdisi", $data['nombre'], $data['precio'], $data['duracion'], $data['descripcion'], $id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Membresía actualizada correctamente']);
            } else {
                throw new Exception("Error al actualizar membresía: " . $stmt->error);
            }
            break;

        case 'delete':
            $id = $_GET['id'] ?? null;
            if (!$id) throw new Exception("ID no proporcionado");
            $sql = "DELETE FROM membresias WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Membresía eliminada correctamente']);
            } else {
                throw new Exception("Error al eliminar membresía: " . $stmt->error);
            }
            break;

        default:
            throw new Exception('Acción no válida');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
