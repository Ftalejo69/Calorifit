<?php
header("Content-Type: application/json");
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["error" => "No has iniciado sesión."]);
    exit;
}

require "conexion.php"; // Asegúrate de que este archivo existe y está correcto

$user_id = $_SESSION["user_id"];
$query = $conn->prepare("SELECT nombre, edad, peso, altura FROM usuarios WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result()->fetch_assoc();

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(["error" => "Perfil no encontrado."]);
}
?>
