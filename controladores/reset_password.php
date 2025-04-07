<?php
include_once '../modelos/usuario.php';
include_once '../configuracion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['nueva_password'];
    $confirmar = $_POST['confirmar_password'];

    if ($password !== $confirmar) {
        echo "Las contraseñas no coinciden";
        exit;
    }

    $model = new UsuarioModel($conexion);
    $result = $model->resetPassword($token, $password);

    if ($result['success']) {
        header('Location: ../vistas/index.php?msg=password_updated');
    } else {
        echo $result['message'];
    }
}
?>
