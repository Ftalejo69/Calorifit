<?php
include_once 'usuario.php';
include_once '../configuracion/conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $model = new UsuarioModel($conexion);
    if ($model->verifyEmail($token)) {
        echo "<script>alert('✅ Correo verificado correctamente.'); window.location.href='../vistas/index.php';</script>";
    } else {
        echo "<script>alert('❌ Enlace inválido o ya utilizado.'); window.location.href='../vistas/index.php';</script>";
    }
} else {
    echo "<script>alert('❌ Token no proporcionado.'); window.location.href='../vistas/index.php';</script>";
}
?>
