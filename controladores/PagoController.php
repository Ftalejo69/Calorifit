<?php
require_once '../modelos/PagoModel.php';

class PagoController {
    private $model;
    
    public function __construct($conexion) {
        $this->model = new PagoModel($conexion);
    }

    public function procesarPago($usuario_id, $membresia_id, $precio, $metodo_pago, $tipo = 'mensual') {
        // Verificar si el usuario existe
        if (!$this->model->verificarUsuario($usuario_id)) {
            return ["error" => "Usuario no encontrado"];
        }

        // Verificar si la membresía existe
        $membresia = $this->model->obtenerMembresia($membresia_id);
        if (!$membresia) {
            return ["error" => "Membresía no encontrada"];
        }

        // Verificar si ya tiene una inscripción activa
        if ($this->model->verificarInscripcionActiva($usuario_id, $membresia_id)) {
            return ["error" => "Ya tienes un plan activo. No puedes contratar otro plan hasta que finalice tu plan actual."];
        }

        $pago_id = $this->model->registrarPago($usuario_id, $precio, $metodo_pago);
        if (!$pago_id) {
            return ["error" => "Error al registrar el pago"];
        }

        $fecha_inicio = date('Y-m-d');
        $duracion = $tipo === 'anual' ? 365 : $membresia['duracion'];
        $fecha_fin = date('Y-m-d', strtotime("+{$duracion} days"));
        
        $inscripcion_id = $this->model->registrarInscripcion($usuario_id, $membresia_id, $fecha_inicio, $fecha_fin);
        if (!$inscripcion_id) {
            return ["error" => "Error al registrar la inscripción"];
        }

        $this->model->actualizarPagoInscripcion($pago_id, $inscripcion_id);
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
