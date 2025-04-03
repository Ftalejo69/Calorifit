<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'gymdb');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el objetivo y nivel seleccionados (por ejemplo, desde un parámetro GET)
$objetivo = isset($_GET['objetivo']) ? $_GET['objetivo'] : 'Rutina Personalizada';
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : 'Principiante'; // Asegúrate de que el nivel se obtenga correctamente

// Consultar los ejercicios desde la base de datos según el objetivo y nivel
$stmt = $conexion->prepare("
    SELECT e.nombre, re.series, re.repeticiones, re.descanso_seg 
    FROM rutina_ejercicios re
    INNER JOIN ejercicios e ON re.ejercicio_id = e.id
    INNER JOIN rutinas r ON re.rutina_id = r.id
    WHERE r.nombre = ? AND r.nivel = ?
");
$stmt->bind_param('ss', $objetivo, $nivel); // Asegúrate de que los parámetros coincidan con los datos en la base de datos
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si la consulta devuelve resultados
if ($resultado->num_rows === 0) {
    error_log("No se encontraron ejercicios para el objetivo '$objetivo' y nivel '$nivel'.");
}

// Almacenar los ejercicios en un array
$lista_ejercicios = [];
while ($fila = $resultado->fetch_assoc()) {
    $lista_ejercicios[] = [
        'nombre' => $fila['nombre'],
        'series' => $fila['series'],
        'repeticiones' => $fila['repeticiones'],
        'descanso' => $fila['descanso_seg'] . ' seg'
    ];
}

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($objetivo); ?></title>
    <link rel="stylesheet" href="../publico/css/rutina_personalizada.css">
</head>
<body>
    <?php include '../vistas/navbar.php'; ?>
    <div class="header text-center">
        <h1 class="titulo"><?php echo htmlspecialchars($objetivo); ?></h1>
        <p class="subtitulo">Sigue esta rutina para alcanzar tus metas.</p>
    </div>
    <div class="contenedor-ejercicios">
        <?php if (!empty($lista_ejercicios)): ?>
            <ul class="lista-ejercicios">
                <?php foreach ($lista_ejercicios as $ejercicio): ?>
                    <li class="ejercicio">
                        <h3><?php echo htmlspecialchars($ejercicio['nombre']); ?></h3>
                        <p>Series: <?php echo htmlspecialchars($ejercicio['series']); ?></p>
                        <p>Repeticiones: <?php echo htmlspecialchars($ejercicio['repeticiones']); ?></p>
                        <p>Descanso: <?php echo htmlspecialchars($ejercicio['descanso']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay ejercicios disponibles para este objetivo.</p>
        <?php endif; ?>
    </div>
    <div class="acciones text-center">
        <button class="boton" onclick="alert('¡Rutina completada!')">Marcar como Completada</button>
    </div>
</body>
</html>
