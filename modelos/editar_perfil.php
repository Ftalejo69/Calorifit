<?php
session_start();
include_once '../configuracion/conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para acceder a su perfil.";
    exit;
}

// Obtener los datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados desde el formulario
    $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : $usuario['correo'];
    $telefono = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : $usuario['telefono'];
    $peso = isset($_POST["peso"]) ? trim($_POST["peso"]) : $usuario['peso'];

    // Solo permitir editar fecha de nacimiento, altura y género si están vacíos
    $fecha_nacimiento = empty($usuario['fecha_nacimiento']) ? trim($_POST["fecha_nacimiento"]) : $usuario['fecha_nacimiento'];
    $altura = empty($usuario['altura']) ? trim($_POST["altura"]) : $usuario['altura'];
    $genero = empty($usuario['genero']) ? trim($_POST["genero"]) : $usuario['genero'];

    // Preparar la consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE usuarios 
            SET correo = ?, telefono = ?, peso = ?, fecha_nacimiento = ?, altura = ?, genero = ?
            WHERE id = ?";
    
    // Preparar la declaración
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        exit;
    }

    // Bind de los parámetros
    $stmt->bind_param("ssssssi", $correo, $telefono, $peso, $fecha_nacimiento, $altura, $genero, $usuario['id']);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Actualizar los datos en la sesión
        $_SESSION['usuario']['correo'] = $correo;
        $_SESSION['usuario']['telefono'] = $telefono;
        $_SESSION['usuario']['peso'] = $peso;
        $_SESSION['usuario']['fecha_nacimiento'] = $fecha_nacimiento;
        $_SESSION['usuario']['altura'] = $altura;
        $_SESSION['usuario']['genero'] = $genero;

        // Redirigir con mensaje de éxito
        echo '<script>alert("Perfil actualizado correctamente."); window.location.href="../vistas/inicio.php";</script>';
    } else {
        echo "Hubo un error al actualizar su perfil: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}
?>
