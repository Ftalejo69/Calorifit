<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $query = "UPDATE rutinas SET favorita = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Rutina marcada como favorita";
    } else {
        echo "Error al marcar la rutina";
    }
}
?>
