<?php
session_start();
include '../configuracion/conexion.php';

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$usuario_id = $_SESSION['usuario']['id'];
$ejercicio_id = $data['ejercicio_id'];
$completado = $data['completado'];
$fecha = date('Y-m-d');

if ($completado) {
    $stmt = $conexion->prepare("INSERT INTO progreso_usuario (usuario_id, ejercicio_id, fecha, series, repeticiones, peso) SELECT ?, ?, ?, series, repeticiones, peso FROM rutina_ejercicios WHERE ejercicio_id = ?");
    $stmt->bind_param("iisi", $usuario_id, $ejercicio_id, $fecha, $ejercicio_id);
} else {
    $stmt = $conexion->prepare("DELETE FROM progreso_usuario WHERE usuario_id = ? AND ejercicio_id = ? AND fecha = ?");
    $stmt->bind_param("iis", $usuario_id, $ejercicio_id, $fecha);
}

echo json_encode(['success' => $stmt->execute()]);
