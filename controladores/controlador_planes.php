<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../modelos/modelo_planes.php";

$conn = new mysqli("localhost", "root", "", "calorifit");

if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $resultado = guardarPlan($conn, $data);
    echo json_encode($resultado);
    $conn->close();
    exit;
}

$planes = obtenerPlanes($conn);

if ($planes === false) {
    echo json_encode(["error" => "Error al obtener los planes."]);
} else {
    echo json_encode($planes);
}

$conn->close();
?>
