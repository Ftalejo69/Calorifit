<?php
include '../php/db_connection.php'; // Asegúrate de tener un archivo para la conexión a la base de datos.

$action = $_GET['action'] ?? '';

if ($action === 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $dia = $data['dia']; // Asegúrate de que este valor se reciba correctamente

    $stmt = $conn->prepare("INSERT INTO tareas (nombre, dia) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $dia);
    $stmt->execute();
    echo json_encode(['id' => $conn->insert_id]);
} elseif ($action === 'delete') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
} elseif ($action === 'get') {
    $result = $conn->query("SELECT * FROM tareas");
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    echo json_encode($tasks);
}
?>
