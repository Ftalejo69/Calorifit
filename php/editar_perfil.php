<?php
session_start();
include_once 'conexion.php';

// Activar la visualización de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
    $telefono = trim($_POST["telefono"]);

    // Validar que el teléfono no esté vacío
    if (!empty($telefono)) {
        // Mostrar mensaje de depuración para verificar que el teléfono se obtiene correctamente
        echo "Teléfono recibido: " . $telefono . "<br>";

        // Preparar la consulta SQL para actualizar el teléfono en la base de datos
        $sql = "UPDATE usuarios SET telefono = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt === false) {
            echo "Error en la preparación de la consulta: " . $conexion->error;
            exit;
        }

        // Bind los parámetros para evitar inyecciones SQL
        $stmt->bind_param("si", $telefono, $usuario['id']);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Mostrar una alerta de SweetAlert y redirigir después de 2 segundos
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Perfil actualizado con éxito',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = '../html/inicio.php'; // Redirige a inicio.php después de 2 segundos
                    });
                </script>
            ";
        } else {
            // Si ocurre un error al ejecutar la consulta
            echo "Hubo un error al actualizar su perfil: " . $stmt->error;
        }

        // Cerrar la consulta
        $stmt->close();
    } else {
        // Si el teléfono está vacío
        echo "⚠️ El teléfono no puede estar vacío.";
    }
}

?>
