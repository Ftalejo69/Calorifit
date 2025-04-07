<?php
include '../configuracion/conexion.php';

function obtenerUsuarioId() {
    if (isset($_SESSION['usuario']['id'])) {
        return $_SESSION['usuario']['id'];
    } else {
        echo "Error: No se pudo obtener el ID del usuario. Por favor, inicie sesión nuevamente.";
        exit;
    }
}

function guardarRutina($conexion, $usuario_id, $nombre_rutina, $nivel, $fecha, $ejercicios) {
    $sql_historial = "INSERT INTO historial (usuario_id, nombre_rutina, nivel, fecha) VALUES (?, ?, ?, ?)";
    $stmt_historial = $conexion->prepare($sql_historial);
    $stmt_historial->bind_param("isss", $usuario_id, $nombre_rutina, $nivel, $fecha);

    if ($stmt_historial->execute()) {
        $historial_id = $stmt_historial->insert_id;

        foreach ($ejercicios as $ejercicio) {
            $nombre_ejercicio = $ejercicio['nombre'];
            $series = $ejercicio['series'];
            $repeticiones = $ejercicio['repeticiones'];

            $sql_ejercicios = "INSERT INTO ejercicios_historial (historial_id, nombre_ejercicio, series, repeticiones) VALUES (?, ?, ?, ?)";
            $stmt_ejercicios = $conexion->prepare($sql_ejercicios);
            $stmt_ejercicios->bind_param("isii", $historial_id, $nombre_ejercicio, $series, $repeticiones);
            $stmt_ejercicios->execute();
        }

        return true;
    }
    return false;
}

function eliminarRutina($conexion, $historial_id) {
    $sql = "DELETE FROM historial WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $historial_id);
    return $stmt->execute();
}

function filtrarRutinas($conexion, $usuario_id, $selected_date) {
    $sql = "SELECT * FROM historial WHERE usuario_id = ?";
    $params = [$usuario_id];
    $types = "i";

    if (!empty($selected_date)) {
        $sql .= " AND fecha = ?";
        $params[] = $selected_date;
        $types .= "s";
    }

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
