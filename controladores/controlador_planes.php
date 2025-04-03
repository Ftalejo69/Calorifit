<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../modelos/modelo_planes.php";

$conn = new mysqli("localhost", "root", "", "calorifit");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$planes = obtenerPlanes($conn);

echo json_encode($planes);

$conn->close();
?>
