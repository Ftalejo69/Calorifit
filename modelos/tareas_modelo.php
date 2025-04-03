<?php
include '../configuaricion/conexion.php'; // Asegúrate de tener un archivo para la conexión a la base de datos.

function agregarTarea($nombre, $dia) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tareas (nombre, dia) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $dia);
    $stmt->execute();
    return $conn->insert_id;
}

function eliminarTarea($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function obtenerTareas() {
    global $conn;
    $result = $conn->query("SELECT * FROM tareas");
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    return $tasks;
}
?>
