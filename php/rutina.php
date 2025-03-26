<?php
header('Content-Type: application/json');
include 'conexion.php'; // Asegúrate de tener la conexión a la base de datos

$categoria = $_GET['categoria'] ?? '';
$query = "SELECT * FROM rutinas WHERE categoria = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $categoria);
$stmt->execute();
$result = $stmt->get_result();
$rutinas = [];

while ($row = $result->fetch_assoc()) {
    $rutinas[] = $row;
}

echo json_encode($rutinas);
?>
