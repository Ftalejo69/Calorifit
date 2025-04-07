<?php
class PagoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarUsuario($usuario_id) {
        $stmt = $this->conexion->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $existe = $resultado->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    public function obtenerMembresia($plan) {
        $stmt = $this->conexion->prepare("SELECT id, nombre, precio, duracion FROM membresias WHERE nombre = ?");
        $stmt->bind_param("s", $plan);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $membresia = $resultado->fetch_assoc();
        $stmt->close();
        return $membresia;
    }

    public function verificarInscripcionActiva($usuario_id, $membresia_id) {
        $stmt = $this->conexion->prepare("SELECT id FROM inscripciones WHERE usuario_id = ? AND membresia_id = ? AND fecha_fin >= CURDATE()");
        $stmt->bind_param("ii", $usuario_id, $membresia_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $existe = $resultado->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    public function registrarPago($usuario_id, $precio, $metodo_pago) {
        $stmt = $this->conexion->prepare("INSERT INTO pagos (usuario_id, monto, metodo_pago) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $usuario_id, $precio, $metodo_pago);
        $exito = $stmt->execute();
        $id = $exito ? $stmt->insert_id : null;
        $stmt->close();
        return $id;
    }

    public function registrarInscripcion($usuario_id, $membresia_id, $fecha_inicio, $fecha_fin) {
        $stmt = $this->conexion->prepare("INSERT INTO inscripciones (usuario_id, membresia_id, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $usuario_id, $membresia_id, $fecha_inicio, $fecha_fin);
        $exito = $stmt->execute();
        $id = $exito ? $stmt->insert_id : null;
        $stmt->close();
        return $id;
    }

    public function actualizarPagoInscripcion($pago_id, $inscripcion_id) {
        $stmt = $this->conexion->prepare("UPDATE pagos SET inscripcion_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $inscripcion_id, $pago_id);
        $exito = $stmt->execute();
        $stmt->close();
        return $exito;
    }
}
?>
