<?php
session_start();
require_once '../controladores/PagoController.php';
require_once '../configuracion/conexion.php';

$controller = new PagoController($conexion);
$resultado = $controller->procesarPago(
    $_SESSION['usuario']['id'] ?? null,
    $_POST['plan'] ?? 'fit',
    $_POST['metodo_pago'] ?? 'No especificado'
);

$_SESSION['mensaje'] = isset($resultado['error']) ? $resultado['error'] : $resultado['exito'];
header('Location: ' . (isset($resultado['error']) ? 'confirmacion.php' : 'confirmacion.php'));
exit;
?>
