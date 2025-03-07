<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "gym");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$result = $conn->query("SELECT p.id, p.tipo, p.fecha_creacion, 
    GROUP_CONCAT(e.nombre, ' (', e.series, 'x', e.repeticiones, ', ', e.descanso, 's)') AS ejercicios
    FROM planes_entrenamiento p 
    LEFT JOIN ejercicios e ON p.id = e.plan_id
    GROUP BY p.id");

$planes = [];
while ($row = $result->fetch_assoc()) {
    $planes[] = $row;
}

echo json_encode($planes);

$conn->close();
?>
