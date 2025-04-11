<?php
require_once '../configuracion/conexion.php';

/**
 * Obtener todas las rutinas.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @return array Lista de rutinas con sus datos.
 */
function obtenerRutinas($conexion) {
    $query = "SELECT id, nombre, nivel, descripcion, imagen FROM rutinas";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtener todos los ejercicios.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @return array Lista de ejercicios con sus datos.
 */
function obtenerEjercicios($conexion) {
    $query = "SELECT id, nombre FROM ejercicios";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtener los objetivos agrupados por nivel.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @return array Lista de objetivos con sus datos.
 */
function obtenerObjetivos($conexion) {
    $query = "SELECT id, nombre, nivel, descripcion, imagen FROM rutinas ORDER BY nivel";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtener rutinas agrupadas por nivel.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @return array Lista de rutinas agrupadas por nivel.
 */
function obtenerRutinasPorNivel($conexion) {
    $query = "SELECT id, nombre, nivel, descripcion, imagen FROM rutinas ORDER BY nivel";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtener los niveles únicos de las rutinas junto con sus imágenes representativas.
 *
 * Esta función consulta la base de datos para obtener una lista de niveles únicos
 * de las rutinas disponibles. Cada nivel incluye una imagen representativa.
 * 
 * La consulta utiliza una subconsulta para seleccionar el primer registro (por ID mínimo)
 * de cada nivel, asegurando que no se repitan niveles en el resultado.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @return array Lista de niveles con sus imágenes (nivel, imagen).
 */
function obtenerNiveles($conexion) {
    // Consulta SQL para obtener niveles únicos con imágenes
    $query = "
        SELECT nivel, imagen 
        FROM rutinas 
        WHERE id IN (
            SELECT MIN(id) 
            FROM rutinas 
            GROUP BY nivel
        )
    ";
    // Ejecuta la consulta en la base de datos
    $result = $conexion->query($query);

    // Devuelve los resultados como un array asociativo
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtener los objetivos por nivel.
 *
 * @param mysqli $conexion Conexión activa a la base de datos.
 * @param string $nivel Nivel para filtrar los objetivos.
 * @return array Lista de objetivos asociados al nivel.
 */
function obtenerObjetivosPorNivel($conexion, $nivel) {
    $query = "SELECT id, nombre FROM rutinas WHERE nivel = ? AND nombre IS NOT NULL AND nombre != ''";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $nivel);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>