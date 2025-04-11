<?php
require_once '../modelos/PagoModel.php';

class PagoController {
    private $model;
    
    public function __construct($conexion) {
        $this->model = new PagoModel($conexion);
    }

    public function procesarPago($usuario_id, $membresia_id, $precio, $metodo_pago, $tipo = 'mensual') {
        error_log("Iniciando procesamiento de pago: usuario_id=$usuario_id, membresia_id=$membresia_id, precio=$precio, metodo_pago=$metodo_pago, tipo=$tipo");
        
        // Verificar si el usuario existe
        if (!$this->model->verificarUsuario($usuario_id)) {
            error_log("Usuario no encontrado: $usuario_id");
            return ["error" => "Usuario no encontrado"];
        }

        // Verificar si la membresía existe usando el método correcto
        $membresia = $this->model->obtenerMembresiaPorId($membresia_id);
        if (!$membresia) {
            error_log("Membresía no encontrada: $membresia_id");
            return ["error" => "Membresía no encontrada"];
        }

        // Verificar si ya tiene una inscripción activa
        if ($this->model->verificarInscripcionActiva($usuario_id, $membresia_id)) {
            error_log("Usuario $usuario_id ya tiene una inscripción activa para la membresía $membresia_id");
            return ["error" => "Ya tienes un plan activo. No puedes contratar otro plan hasta que finalice tu plan actual."];
        }

        $pago_id = $this->model->registrarPago($usuario_id, $precio, $metodo_pago);
        if (!$pago_id) {
            error_log("Error al registrar el pago para usuario $usuario_id");
            return ["error" => "Error al registrar el pago"];
        }

        $fecha_inicio = date('Y-m-d');
        $duracion = $tipo === 'anual' ? 365 : 30; // Duración predeterminada de 30 días para planes mensuales
        $fecha_fin = date('Y-m-d', strtotime("+{$duracion} days"));
        
        error_log("Registrando inscripción: inicio=$fecha_inicio, fin=$fecha_fin");
        $inscripcion_id = $this->model->registrarInscripcion($usuario_id, $membresia_id, $fecha_inicio, $fecha_fin);
        if (!$inscripcion_id) {
            error_log("Error al registrar la inscripción para usuario $usuario_id");
            return ["error" => "Error al registrar la inscripción"];
        }

        $this->model->actualizarPagoInscripcion($pago_id, $inscripcion_id);
        error_log("Pago procesado exitosamente: pago_id=$pago_id, inscripcion_id=$inscripcion_id");
        return [
            "success" => true,
            "message" => "Pago exitoso para el plan {$membresia['nombre']}",
            "inscripcion_id" => $inscripcion_id
        ];
    }
}

// Manejo de la petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['mensaje'] = "Por favor, inicia sesión para continuar.";
        header('Location: ../vistas/login.php');
        exit;
    }

    require_once '../configuracion/conexion.php';
    
    $controller = new PagoController($conexion);
    $resultado = $controller->procesarPago(
        $_SESSION['usuario']['id'],
        $_POST['membresia_id'] ?? null,
        $_POST['precio'] ?? 0,
        $_POST['metodo_pago'] ?? 'No especificado',
        $_POST['tipo'] ?? 'mensual'
    );

    if (isset($resultado['success']) && $resultado['success']) {
        $_SESSION['mensaje'] = $resultado['message'];
        $_SESSION['tipo_mensaje'] = 'success';
    } else {
        $_SESSION['mensaje'] = $resultado['error'] ?? "Error al procesar el pago";
        $_SESSION['tipo_mensaje'] = 'error';
    }
    
    header('Location: ../vistas/confirmacion.php');
    exit;
}
?>
