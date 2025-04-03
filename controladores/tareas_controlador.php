<?php
include '../modelos/tareas_modelo.php';

$action = $_GET['action'] ?? '';

if ($action === 'add') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $dia = $data['dia']; // Asegúrate de que este valor se reciba correctamente

    $id = agregarTarea($nombre, $dia);
    echo json_encode(['id' => $id]);
} elseif ($action === 'delete') {
    $id = $_GET['id'];
    $success = eliminarTarea($id);
    echo json_encode(['success' => $success]);
} elseif ($action === 'get') {
    $tasks = obtenerTareas();
    echo json_encode($tasks);
}
?>
