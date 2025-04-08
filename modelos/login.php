<?php
include_once 'usuario.php';
include_once '../configuracion/conexion.php';

session_start();
$model = new UsuarioModel($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
    $contraseña = trim($_POST["contraseña"]);

    if (filter_var($correo, FILTER_VALIDATE_EMAIL) && !empty($contraseña)) {
        $result = $model->loginUser($correo, $contraseña);
        if ($result['success']) {
            $_SESSION['usuario'] = $result['user'];
            $_SESSION['ultimo_acceso'] = time();
            echo "Inicio de sesión exitoso.";
        } else {
            echo "❌ " . $result['message'];
        }
    } else {
        echo "⚠️ Correo inválido o contraseña vacía.";
    }
}
?>
