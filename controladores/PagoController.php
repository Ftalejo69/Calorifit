<?php
require_once '../modelos/PagoModel.php';

class PagoController {
    private $model;
    
    public function __construct($conexion) {
        $this->model = new PagoModel($conexion);
    }

    public function procesarPago($usuario_id, $plan, $metodo_pago) {
        if (!$this->model->verificarUsuario($usuario_id)) {
            return ["error" => "Usuario no encontrado"];
        }

        $membresia = $this->model->obtenerMembresia($plan);
        if (!$membresia) {
            return ["error" => "Plan no encontrado"];
        }

        if ($this->model->verificarInscripcionActiva($usuario_id, $membresia['id'])) {
            return ["error" => "Ya tienes una inscripción activa para este plan"];
        }

        $pago_id = $this->model->registrarPago($usuario_id, $membresia['precio'], $metodo_pago);
        if (!$pago_id) {
            return ["error" => "Error al registrar el pago"];
        }

        $fecha_inicio = date('Y-m-d');
        $fecha_fin = date('Y-m-d', strtotime("+{$membresia['duracion']} days"));
        $inscripcion_id = $this->model->registrarInscripcion($usuario_id, $membresia['id'], $fecha_inicio, $fecha_fin);
        
        if (!$inscripcion_id) {
            return ["error" => "Error al registrar la inscripción"];
        }

        $this->model->actualizarPagoInscripcion($pago_id, $inscripcion_id);
        return ["exito" => "Pago exitoso para el plan {$membresia['nombre']}", "inscripcion_id" => $inscripcion_id];
    }
}

// Manejo directo de la petición POST
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
        $_SESSION['usuario']['id'] ?? null,
        $_POST['plan'] ?? 'fit',
        $_POST['metodo_pago'] ?? 'No especificado'
    );

    $_SESSION['mensaje'] = isset($resultado['error']) ? $resultado['error'] : $resultado['exito'];
    header('Location: ../vistas/confirmacion.php');
    exit;
}
?>
