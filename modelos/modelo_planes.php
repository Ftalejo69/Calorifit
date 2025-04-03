<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

function obtenerPlanes($conn) {
    $query = "SELECT p.id, p.tipo, p.fecha_creacion, 
        GROUP_CONCAT(e.nombre, ' (', e.series, 'x', e.repeticiones, ', ', e.descanso, 's)') AS ejercicios
        FROM planes_entrenamiento p 
        LEFT JOIN ejercicios e ON p.id = e.plan_id
        GROUP BY p.id";

    $result = $conn->query($query);

    if (!$result) {
        error_log("Error en la consulta SQL: " . $conn->error);
        return false;
    }

    $planes = [];
    while ($row = $result->fetch_assoc()) {
        $planes[] = $row;
    }

    return $planes;
}

function guardarPlan($conn, $data) {
    if (!isset($data["tipo"]) || !isset($data["ejercicios"])) {
        return ["error" => "Datos incompletos"];
    }

    $tipo = $data["tipo"];
    $stmt = $conn->prepare("INSERT INTO planes_entrenamiento (tipo) VALUES (?)");
    if (!$stmt) {
        error_log("Error en la preparación de la consulta: " . $conn->error);
        return ["error" => "Error al guardar el plan"];
    }
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $plan_id = $stmt->insert_id;
    $stmt->close();

    foreach ($data["ejercicios"] as $ej) {
        $stmt = $conn->prepare("INSERT INTO ejercicios (plan_id, nombre, series, repeticiones, descanso) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . $conn->error);
            return ["error" => "Error al guardar los ejercicios"];
        }
        $stmt->bind_param("isiii", $plan_id, $ej["nombre"], $ej["series"], $ej["repeticiones"], $ej["descanso"]);
        $stmt->execute();
        $stmt->close();
    }

    return ["message" => "Plan guardado con éxito"];
}
?>
