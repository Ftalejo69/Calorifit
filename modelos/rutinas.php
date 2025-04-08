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

function guardarRutina($conexion, $usuario_id, $ejercicios_completados, $objetivo, $nivel) {
    $fecha = date('Y-m-d');
    
    // Insertar en historial
    $sql_historial = "INSERT INTO historial (usuario_id, nombre_rutina, nivel, fecha) VALUES (?, ?, ?, ?)";
    $stmt_historial = $conexion->prepare($sql_historial);
    $stmt_historial->bind_param("isss", $usuario_id, $objetivo, $nivel, $fecha);
    
    if ($stmt_historial->execute()) {
        $historial_id = $stmt_historial->insert_id;
        
        // Insertar solo los ejercicios marcados en progreso_usuario
        foreach ($ejercicios_completados as $ejercicio_id) {
            $sql_ejercicio = "INSERT INTO progreso_usuario (usuario_id, ejercicio_id, fecha, series, repeticiones, peso, historial_id)
                             SELECT ?, ?, ?, series, repeticiones, peso, ? 
                             FROM rutina_ejercicios 
                             WHERE ejercicio_id = ? AND rutina_id = (
                                 SELECT id FROM rutinas WHERE nombre = ? AND nivel = ?
                             )";
            
            $stmt_ejercicio = $conexion->prepare($sql_ejercicio);
            $stmt_ejercicio->bind_param("iisiiis", $usuario_id, $ejercicio_id, $fecha, $historial_id, $ejercicio_id, $objetivo, $nivel);
            $stmt_ejercicio->execute();
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
