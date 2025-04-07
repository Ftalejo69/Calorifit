<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

// Incluir la conexión a la base de datos
include '../configuracion/conexion.php';

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

// Manejar la marcación de rutina como completada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_completada'])) {
    $nombre_rutina = $objetivo;
    $nivel = $nivel;
    $fecha = date('Y-m-d');
    $usuario_id = $_SESSION['usuario']['id'];

    // Validar que el usuario existe en la tabla usuarios
    $sql_usuario = "SELECT id FROM usuarios WHERE id = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $usuario_id);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows === 0) {
        echo "<script>alert('El usuario no existe en la base de datos.');</script>";
        exit;
    }

    // Insertar en la tabla historial
    $sql_historial = "INSERT INTO historial (usuario_id, nombre_rutina, nivel, fecha) VALUES (?, ?, ?, ?)";
    $stmt_historial = $conexion->prepare($sql_historial);
    $stmt_historial->bind_param("isss", $usuario_id, $nombre_rutina, $nivel, $fecha);

    if ($stmt_historial->execute()) {
        $historial_id = $stmt_historial->insert_id;

        // Insertar ejercicios asociados en la tabla ejercicios_historial
        foreach ($lista_ejercicios as $ejercicio) {
            $nombre_ejercicio = $ejercicio['nombre'];
            $series = $ejercicio['series'];
            $repeticiones = $ejercicio['repeticiones'];

            $sql_ejercicios = "INSERT INTO ejercicios_historial (historial_id, nombre_ejercicio, series, repeticiones) VALUES (?, ?, ?, ?)";
            $stmt_ejercicios = $conexion->prepare($sql_ejercicios);
            $stmt_ejercicios->bind_param("isii", $historial_id, $nombre_ejercicio, $series, $repeticiones);
            $stmt_ejercicios->execute();
        }

        echo "<script>alert('Rutina marcada como completada.');</script>";
        header('Location: rutina_personalizada.php');
        exit;
    } else {
        echo "<script>alert('Error al marcar la rutina como completada.');</script>";
    }
}
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
        <form method="post">
            <button class="boton" name="marcar_completada">Marcar como Completada</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión al final del archivo
$conexion->close();
?>
