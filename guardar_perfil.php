<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['nombre']) || empty($data['edad']) || empty($data['peso']) || empty($data['altura'])) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    exit;
}

$sql = "UPDATE usuarios SET nombre=?, edad=?, peso=?, altura=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdddi", $data['nombre'], $data['edad'], $data['peso'], $data['altura'], $usuario_id);

if ($stmt->execute()) {
    echo json_encode(["success" => "Perfil actualizado"]);
} else {
    echo json_encode(["error" => "Error al actualizar"]);
}
?>
