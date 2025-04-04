<?php
session_start();
include_once '../configuracion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'] ?? 'fit';
    $metodo_pago = $_POST['metodo_pago'] ?? 'No especificado';
    $usuario_id = $_SESSION['usuario']['id'] ?? null;

    if ($usuario_id) {
        // Verificar si el usuario existe
        $stmt_usuario = $conexion->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt_usuario->bind_param("i", $usuario_id);
        $stmt_usuario->execute();
        $resultado_usuario = $stmt_usuario->get_result();
        if ($resultado_usuario->num_rows === 0) {
            $_SESSION['mensaje'] = "Usuario no encontrado. Inténtalo nuevamente.";
            header('Location: confirmacion.php');
            exit;
        }
        $stmt_usuario->close();

        // Obtener detalles del plan desde la tabla `membresias`
        $stmt_membresia = $conexion->prepare("SELECT id, nombre, precio, duracion FROM membresias WHERE nombre = ?");
        $stmt_membresia->bind_param("s", $plan);
        $stmt_membresia->execute();
        $resultado = $stmt_membresia->get_result();
        $membresia = $resultado->fetch_assoc();
        $stmt_membresia->close();

        if (!$membresia) {
            $_SESSION['mensaje'] = "El plan seleccionado no existe. Inténtalo nuevamente.";
            header('Location: confirmacion.php');
            exit;
        }

        $membresia_id = $membresia['id'];
        $precio = $membresia['precio'];
        $duracion = $membresia['duracion'];

        // Insertar en la tabla `pagos`
        $stmt_pago = $conexion->prepare("INSERT INTO pagos (usuario_id, monto, metodo_pago) VALUES (?, ?, ?)");
        $stmt_pago->bind_param("ids", $usuario_id, $precio, $metodo_pago);
        if ($stmt_pago->execute()) {
            $pago_id = $stmt_pago->insert_id;

            // Registrar en la tabla `inscripciones`
            $fecha_inicio = date('Y-m-d');
            $fecha_fin = date('Y-m-d', strtotime("+$duracion days"));
            $stmt_inscripcion = $conexion->prepare("INSERT INTO inscripciones (usuario_id, membresia_id, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)");
            $stmt_inscripcion->bind_param("iiss", $usuario_id, $membresia_id, $fecha_inicio, $fecha_fin);
            if ($stmt_inscripcion->execute()) {
                $inscripcion_id = $stmt_inscripcion->insert_id;

                // Actualizar el pago con la inscripción vinculada
                $stmt_actualizar_pago = $conexion->prepare("UPDATE pagos SET inscripcion_id = ? WHERE id = ?");
                $stmt_actualizar_pago->bind_param("ii", $inscripcion_id, $pago_id);
                $stmt_actualizar_pago->execute();
                $stmt_actualizar_pago->close();

                $_SESSION['mensaje'] = "¡Pago exitoso para el plan {$membresia['nombre']}! Inscripción registrada.";
            } else {
                $_SESSION['mensaje'] = "Error al registrar la inscripción. Inténtalo nuevamente.";
            }
            $stmt_inscripcion->close();
        } else {
            $_SESSION['mensaje'] = "Error al registrar el pago. Inténtalo nuevamente.";
        }
        $stmt_pago->close();
    } else {
        $_SESSION['mensaje'] = "Usuario no identificado. Inicia sesión nuevamente.";
    }

    header('Location: confirmacion.php');
    exit;
} else {
    header('Location: inicio.php');
    exit;
}
?>
