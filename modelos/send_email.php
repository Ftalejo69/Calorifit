<?php
include_once 'usuario.php';
include_once '../configuracion/conexion.php';

if ($argc !== 4) {
    error_log("Error: Uso incorrecto de send_email.php. Se esperaban 3 argumentos.");
    exit("Uso: php send_email.php <nombre> <correo> <token>\n");
}

$nombre = $argv[1];
$correo = $argv[2];
$token = $argv[3];

$model = new UsuarioModel($conexion);

try {
    $model->sendVerificationEmail($nombre, $correo, $token);
    error_log("Correo enviado exitosamente a $correo.");
} catch (Exception $e) {
    error_log("Error al enviar el correo: " . $e->getMessage());
}
?>
