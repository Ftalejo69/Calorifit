<?php
include_once 'usuario.php';
include_once '../configuracion/conexion.php';

$model = new UsuarioModel($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $contraseña = trim($_POST["contraseña"]);

    if (!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($contraseña)) {
        $result = $model->registerUser($nombre, $correo, $telefono, $contraseña);

        // Asegúrate de que no haya espacios en blanco antes o después del mensaje
        echo trim($result['message']);

        // Enviar el correo directamente
        if ($result['success']) {
            $model->sendVerificationEmail($nombre, $correo, $result['token']); // Envía el correo directamente
        }
    } else {
        echo "⚠️ Por favor, completa todos los campos.";
    }
}
?>
