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

            // Retrieve the user's plan
            $stmt = $conexion->prepare("SELECT m.nombre AS plan FROM inscripciones i 
                                        INNER JOIN membresias m ON i.membresia_id = m.id 
                                        WHERE i.usuario_id = ? AND i.fecha_fin >= CURDATE() LIMIT 1");
            $stmt->bind_param("i", $_SESSION['usuario']['id']);
            $stmt->execute();
            $planResult = $stmt->get_result()->fetch_assoc();
            $_SESSION['usuario']['plan'] = $planResult['plan'] ?? null;

            // Verificar roles del usuario
            $stmt = $conexion->prepare("SELECT r.id, r.nombre FROM usuarios_roles ur INNER JOIN roles r ON ur.rol_id = r.id WHERE ur.usuario_id = ?");
            $stmt->bind_param("i", $_SESSION['usuario']['id']);
            $stmt->execute();
            $roles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $_SESSION['usuario']['roles'] = $roles;

            // Redirección basada en el rol
            if (in_array('admin', array_column($roles, 'nombre'))) {
                $redirect = '../vistas/adminvista.php';
            } elseif (in_array('entrenador', array_column($roles, 'nombre'))) {
                $redirect = '../panel/entrenador.php';
            } else {
                $redirect = '../vistas/inicio.php';
            }

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
