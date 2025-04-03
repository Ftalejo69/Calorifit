<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

function obtenerPlanes($conn) {
    $result = $conn->query("SELECT p.id, p.tipo, p.fecha_creacion, 
        GROUP_CONCAT(e.nombre, ' (', e.series, 'x', e.repeticiones, ', ', e.descanso, 's)') AS ejercicios
        FROM planes_entrenamiento p 
        LEFT JOIN ejercicios e ON p.id = e.plan_id
        GROUP BY p.id");

    $planes = [];
    while ($row = $result->fetch_assoc()) {
        $planes[] = $row;
    }

    return $planes;
}
?>
