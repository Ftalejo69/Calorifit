<?php
$host = 'localhost';
$usuario = 'root';
$password = '';
$base_datos = 'gymdb';

try {
    $conexion = new mysqli($host, $usuario, $password, $base_datos);
    
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    $conexion->set_charset("utf8");
} catch (Exception $e) {
    die(json_encode(['error' => $e->getMessage()]));
}
?>
