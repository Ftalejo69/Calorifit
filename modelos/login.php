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
        
        header('Content-Type: application/json');
        
        if ($result['success']) {
            $_SESSION['usuario'] = $result['user'];
            $_SESSION['ultimo_acceso'] = time();
            
            // Redirección basada en el rol
            $redirect = ($_SESSION['usuario']['rol'] === 'admin') ? 'adminvista.php' : 'inicio.php';
            echo json_encode(['success' => true, 'redirect' => $redirect]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '⚠️ Correo inválido o contraseña vacía.']);
    }
    exit();
}
?>
