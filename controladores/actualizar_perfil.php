<?php
session_start();
header('Content-Type: application/json');
include_once '../configuracion/conexion.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($_SESSION['usuario']['id'])) {
        throw new Exception('No se ha iniciado sesión');
    }

    $userId = $_SESSION['usuario']['id'];
    $nombre = $data['nombre'];
    $correo = $data['correo'];
    $telefono = $data['telefono'];

    $sql = "UPDATE usuarios SET nombre = ?, correo = ?, telefono = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $telefono, $userId);

    if ($stmt->execute()) {
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['usuario']['correo'] = $correo;
        $_SESSION['usuario']['telefono'] = $telefono;
        
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Error al actualizar el perfil');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
