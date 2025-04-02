<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("localhost", "root", "", "calorifit");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["tipo"]) && isset($data["ejercicios"])) {
    $tipo = $data["tipo"];

    $stmt = $conn->prepare("INSERT INTO planes_entrenamiento (tipo) VALUES (?)");
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $plan_id = $stmt->insert_id;
    $stmt->close();

    foreach ($data["ejercicios"] as $ej) {
        $stmt = $conn->prepare("INSERT INTO ejercicios (plan_id, nombre, series, repeticiones, descanso) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiii", $plan_id, $ej["nombre"], $ej["series"], $ej["repeticiones"], $ej["descanso"]);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(["message" => "Plan guardado con éxito"]);
} else {
    echo json_encode(["error" => "Datos incompletos"]);
}

$conn->close();
?>
