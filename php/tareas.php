<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_GET['action'];

if ($action == 'get') {
    $sql = "SELECT * FROM tareas";
    $result = $conn->query($sql);
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    echo json_encode($tasks);
} elseif ($action == 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $dia = $data['dia'];
    $sql = "INSERT INTO tareas (nombre, dia) VALUES ('$nombre', '$dia')";
    $conn->query($sql);
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM tareas WHERE id = $id";
    $conn->query($sql);
}

$conn->close();
?>
