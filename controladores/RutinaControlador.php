<?php
header('Content-Type: application/json');
include '../modelos/RutinaModelo.php';

$categoria = $_GET['categoria'] ?? '';
$nivel = $_GET['nivel'] ?? 'Principiante';

$rutinas = obtenerRutinas($categoria, $nivel);

echo json_encode($rutinas);
?>
