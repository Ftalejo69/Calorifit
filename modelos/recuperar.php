<?php
include_once 'usuario.php';
include_once '../configuracion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["correo"]);
    
    if (!empty($correo)) {
        $model = new UsuarioModel($conexion);
        $result = $model->sendRecoveryEmail($correo);
        echo $result['message'];
    } else {
        echo "Por favor, ingresa tu correo electrónico.";
    }
}
?>
