<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "DELETE FROM usuarios WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);

if ($stmt->execute()) {
    session_destroy(); 
    echo json_encode(["success" => "Perfil eliminado"]);
} else {
    echo json_encode(["error" => "Error al eliminar"]);
}
?>
