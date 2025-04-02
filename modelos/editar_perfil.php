<?php
session_start();
include_once 'conexion.php';

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
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);
    $genero = trim($_POST["genero"]);
    $peso = trim($_POST["peso"]);
    $altura = trim($_POST["altura"]);

    // Preparar la consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE usuarios 
            SET correo = ?, telefono = ?, fecha_nacimiento = ?, genero = ?, peso = ?, altura = ?
            WHERE id = ?";
    
    // Preparar la declaración
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        exit;
    }

    // Bind de los parámetros
    $stmt->bind_param("ssssddi", $correo, $telefono, $fecha_nacimiento, $genero, $peso, $altura, $usuario['id']);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Actualizar los datos en la sesión
        $_SESSION['usuario']['correo'] = $correo;
        $_SESSION['usuario']['telefono'] = $telefono;
        $_SESSION['usuario']['fecha_nacimiento'] = $fecha_nacimiento;
        $_SESSION['usuario']['genero'] = $genero;
        $_SESSION['usuario']['peso'] = $peso;
        $_SESSION['usuario']['altura'] = $altura;

        // Redirigir con mensaje de éxito
        echo '<script>alert("Perfil actualizado correctamente."); window.location.href="../html/inicio.php";</script>';
    } else {
        echo "Hubo un error al actualizar su perfil: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}


?>
