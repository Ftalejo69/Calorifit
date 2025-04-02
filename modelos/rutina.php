<?php
header('Content-Type: application/json');
include '../configuracion/conexion.php'; // Asegúrate de tener la conexión a la base de datos

$categoria = $_GET['categoria'] ?? '';
$nivel = $_GET['nivel'] ?? 'Principiante'; // Asegúrate de que el nivel se obtenga correctamente
$query = "SELECT * FROM rutinas WHERE categoria = ? AND nivel = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $categoria, $nivel); // Confirmar que los parámetros coincidan con los datos en la base de datos
$stmt->execute();
$result = $stmt->get_result();

// Verificar si la consulta devuelve resultados
if ($result->num_rows === 0) {
    error_log("No se encontraron rutinas para la categoría '$categoria' y nivel '$nivel'.");
}

$rutinas = [];

while ($row = $result->fetch_assoc()) {
    $rutinas[] = $row;
}

echo json_encode($rutinas);
?>
