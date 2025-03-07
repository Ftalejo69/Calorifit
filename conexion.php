<?php
// conexion.php
$host = "localhost";
$user = "root";
$password = "";
$db = "gym";

$conexion = new mysqli($host, $user, $password, $db);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
mysqli_set_charset($conexion, "utf8");
?>
