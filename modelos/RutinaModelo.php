<?php
header('Content-Type: application/json');
include '../configuracion/conexion.php'; // Asegúrate de tener la conexión a la base de datos

function obtenerRutinas($categoria, $nivel) {
    global $conn;
    $query = "SELECT * FROM rutinas WHERE categoria = ? AND nivel = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $categoria, $nivel);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        error_log("No se encontraron rutinas para la categoría '$categoria' y nivel '$nivel'.");
    }

    $rutinas = [];
    while ($row = $result->fetch_assoc()) {
        $rutinas[] = $row;
    }

    return $rutinas;
}
?>
