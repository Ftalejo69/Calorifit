<?php
include_once 'usuario.php';
include_once 'conexion.php';

$model = new UsuarioModel($conexion);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'register') {
        $nombre = trim($_POST["nombre"]);
        $correo = trim($_POST["correo"]);
        $telefono = trim($_POST["telefono"]);
        $contraseña = trim($_POST["contraseña"]);

        if (!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($contraseña)) {
            $result = $model->registerUser($nombre, $correo, $telefono, $contraseña);
            echo $result['message'];
        } else {
            echo "⚠️ Por favor, completa todos los campos.";
        }
    } elseif ($_POST['action'] == 'login') {
        $correo = trim($_POST["correo"]);
        $contraseña = trim($_POST["contraseña"]);

        if (!empty($correo) && !empty($contraseña)) {
            $result = $model->loginUser($correo, $contraseña);
            if ($result['success']) {
                session_start();
                $_SESSION['usuario'] = $result['user'];

                

                // ✅ Redirección automática a 'menu.html'
                if ($result['success']) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start(); // Solo inicia sesión si no está activa
                    }
                    $_SESSION['usuario'] = $result['user'];
                
                    // Muestra una alerta y redirige
                    echo "
                           Inicio de sesión exitoso.
                            ";
                    exit;

                    
                }
                
                
            } else {
                echo $result['message'];
            }
        } else {
            echo "⚠️ Por favor, completa todos los campos.";
        }
    }
}
?>
