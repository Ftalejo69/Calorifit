<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

$usuario = $_SESSION['usuario']; // Datos del usuario que están en la sesión

// Incluir la conexión a la base de datos
include '../configuracion/conexion.php';

// Obtener el objetivo y nivel seleccionados
$objetivo = isset($_GET['objetivo']) ? $_GET['objetivo'] : 'Rutina Personalizada';
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : 'Principiante';

// Consultar los ejercicios desde la base de datos según el objetivo y nivel
$stmt = $conexion->prepare("
    SELECT e.id AS ejercicio_id, e.nombre, re.series, re.repeticiones, re.peso 
    FROM rutina_ejercicios re
    INNER JOIN ejercicios e ON re.ejercicio_id = e.id
    INNER JOIN rutinas r ON re.rutina_id = r.id
    WHERE r.nombre = ? AND r.nivel = ?
");
$stmt->bind_param("ss", $objetivo, $nivel);
$stmt->execute();
$lista_ejercicios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_completada'])) {
    $usuario_id = $_SESSION['usuario']['id'];
    $fecha = date('Y-m-d');

    // Insertar en la tabla historial
    $sql_historial = "INSERT INTO historial (usuario_id, nombre_rutina, nivel, fecha) VALUES (?, ?, ?, ?)";
    $stmt_historial = $conexion->prepare($sql_historial);
    $stmt_historial->bind_param("isss", $usuario_id, $objetivo, $nivel, $fecha);
    $stmt_historial->execute();
    $historial_id = $stmt_historial->insert_id;

    // Insertar en la tabla progreso_usuario solo los ejercicios marcados
    if (isset($_POST['ejercicios_completados']) && is_array($_POST['ejercicios_completados'])) {
        foreach ($_POST['ejercicios_completados'] as $ejercicio_id) {
            foreach ($lista_ejercicios as $ejercicio) {
                if ($ejercicio['ejercicio_id'] == $ejercicio_id) {
                    $series = $ejercicio['series'];
                    $repeticiones = $ejercicio['repeticiones'];
                    $peso = $ejercicio['peso'];

                    $sql_progreso = "INSERT INTO progreso_usuario (usuario_id, ejercicio_id, fecha, series, repeticiones, peso, historial_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt_progreso = $conexion->prepare($sql_progreso);
                    $stmt_progreso->bind_param("iisiiii", $usuario_id, $ejercicio_id, $fecha, $series, $repeticiones, $peso, $historial_id);
                    $stmt_progreso->execute();
                }
            }
        }
    }

    echo "<script>alert('Rutina marcada como completada y guardada en el historial y progreso.');</script>";
    header('Location: rutina_personalizada.php');
    exit;
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
            <form method="post" id="rutina-form">
                <ul class="lista-ejercicios">
                    <?php foreach ($lista_ejercicios as $ejercicio): ?>
                        <li class="ejercicio">
                            <div class="ejercicio-header">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="ejercicios_completados[]" 
                                           value="<?php echo $ejercicio['ejercicio_id']; ?>" 
                                           class="ejercicio-check"
                                           data-series="<?php echo $ejercicio['series']; ?>"
                                           data-repeticiones="<?php echo $ejercicio['repeticiones']; ?>"
                                           data-peso="<?php echo $ejercicio['peso']; ?>">
                                    <span class="checkmark"></span>
                                </label>
                                <h3><?php echo htmlspecialchars($ejercicio['nombre']); ?></h3>
                            </div>
                            <p>Series: <?php echo htmlspecialchars($ejercicio['series']); ?></p>
                            <p>Repeticiones: <?php echo htmlspecialchars($ejercicio['repeticiones']); ?></p>
                            <p>Peso: <?php echo htmlspecialchars($ejercicio['peso']); ?> kg</p>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="acciones text-center">
                    <button type="submit" name="marcar_completada" class="boton">Marcar como Completada</button>
                </div>
            </form>
        <?php else: ?>
            <p>No hay ejercicios disponibles para este objetivo.</p>
        <?php endif; ?>
    </div>
    <script src="../publico/js/rutina_personalizada.js"></script>
</body>
</html>

<?php
// Cerrar la conexión al final del archivo
$conexion->close();
?>
