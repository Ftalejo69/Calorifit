<?php
require_once '../configuracion/conexion.php';

class ObjetivosModelo {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerObjetivosPorNivel($nivel) {
        $query = "SELECT id, nombre FROM rutinas WHERE nivel = ? AND nombre IS NOT NULL AND nombre != ''";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $nivel);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminarObjetivo($id) {
        $query = "DELETE FROM rutinas WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function editarObjetivo($id, $nombre) {
        $query = "UPDATE rutinas SET nombre = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("si", $nombre, $id);
        return $stmt->execute();
    }
}
?>
