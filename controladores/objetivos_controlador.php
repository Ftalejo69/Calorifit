<?php
require_once '../modelos/objetivos_modelo.php';
require_once '../configuracion/conexion.php';

$objetivosModelo = new ObjetivosModelo($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;

    if ($accion === 'eliminar_objetivo') {
        $id = $_POST['id'];
        $resultado = $objetivosModelo->eliminarObjetivo($id);
        echo json_encode(['success' => $resultado]);
        exit;
    }

    if ($accion === 'editar_objetivo') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $resultado = $objetivosModelo->editarObjetivo($id, $nombre);
        echo json_encode(['success' => $resultado]);
        exit;
    }
}
?>
