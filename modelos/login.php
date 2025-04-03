<?php
include_once 'usuario.php';
include_once '../configuracion/conexion.php';

$model = new UsuarioModel($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["correo"]);
    $contraseña = trim($_POST["contraseña"]);

    if (!empty($correo) && !empty($contraseña)) {
        $result = $model->loginUser($correo, $contraseña);
        if ($result['success']) {
            session_start();
            $_SESSION['usuario'] = $result['user'];
            echo "Inicio de sesión exitoso.";
        } else {
            echo $result['message'];
        }
    } else {
        echo "⚠️ Por favor, completa todos los campos.";
    }
}
?>
