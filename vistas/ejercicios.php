<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

include '../modelos/rutinas.php';

$usuario_id = obtenerUsuarioId();

// Guardar rutina en la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_rutina'])) {
    $nombre_rutina = $_POST['nombre_rutina'];
    $nivel = $_POST['nivel'];
    $fecha = date('Y-m-d');
    $ejercicios = $_POST['ejercicios'];

    if (guardarRutina($conexion, $usuario_id, $nombre_rutina, $nivel, $fecha, $ejercicios)) {
        echo "<script>alert('Rutina guardada correctamente.');</script>";
    } else {
        echo "<script>alert('Error al guardar la rutina.');</script>";
    }
}

// Eliminar rutina de la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_rutina'])) {
    $historial_id = $_POST['historial_id'];

    if (eliminarRutina($conexion, $historial_id)) {
        // Redirigir para evitar que el formulario se vuelva a enviar al recargar la página
        header("Location: ejercicios.php");
        exit;
    } else {
        echo "<script>alert('Error al eliminar la rutina.');</script>";
    }
}

// Filtrar rutinas según la fecha seleccionada
$selected_date = $_GET['selected_date'] ?? '';
$rutinas_completadas = filtrarRutinas($conexion, $usuario_id, $selected_date);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes de Entrenamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href="../publico/css/ejercicios.css">
</head>
<body>

<?php include '../vistas/navbar.php'; ?>

<?php include '../vistas/modal_perfil.php'; ?>
  
<!-- Sección de bienvenida -->
<section class="welcome-section text-center">
  <h1>HISTORIAL <span>CALORIFIT</span></h1>
  <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
  <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#historial'">HISTORIAL</button>
</section>

<section class="history-section">
    <div class="history-header">
        <h2>Historial de Entrenamientos</h2>
        <form method="get" class="filter-form">
            <label for="selected_date" class="filter-label">Seleccionar fecha de entrenamiento:</label>
            <div class="date-container">
                <input type="date" name="selected_date" id="selected_date" value="<?php echo htmlspecialchars($selected_date); ?>" class="filter-date">
            </div>
            <button type="submit" class="btn btn-primary filter-button">Filtrar</button>
        </form>
    </div>

    <div id="historial" class="history-container">
        <div class="row">
            <?php if (!empty($rutinas_completadas)): ?>
                <?php foreach ($rutinas_completadas as $rutina): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($rutina['nombre_rutina']); ?></h5>
                                <p class="card-text">Nivel: <span><?php echo htmlspecialchars($rutina['nivel']); ?></span></p>
                                <p class="card-text">Fecha: <span><?php echo htmlspecialchars($rutina['fecha']); ?></span></p>
                                <ul>
                                    <?php
                                    $sql_ejercicios = "SELECT * FROM ejercicios_historial WHERE historial_id = ?";
                                    $stmt_ejercicios = $conexion->prepare($sql_ejercicios);
                                    $stmt_ejercicios->bind_param("i", $rutina['id']);
                                    $stmt_ejercicios->execute();
                                    $result_ejercicios = $stmt_ejercicios->get_result();
                                    while ($ejercicio = $result_ejercicios->fetch_assoc()):
                                    ?>
                                        <li>
                                            <span class="exercise-name"><?php echo htmlspecialchars($ejercicio['nombre_ejercicio']); ?></span>
                                            <span class="exercise-details">Series: <?php echo htmlspecialchars($ejercicio['series']); ?>, Repeticiones: <?php echo htmlspecialchars($ejercicio['repeticiones']); ?></span>
                                        </li>
                                    <?php endwhile; ?>
                                    <?php $stmt_ejercicios->close(); ?>
                                </ul>
                                <form method="post" style="margin-top: 10px;">
                                    <input type="hidden" name="historial_id" value="<?php echo $rutina['id']; ?>">
                                    <button type="submit" name="eliminar_rutina" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                            <div class="card-footer">
                                ¡Sigue trabajando para alcanzar tus metas!
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay rutinas completadas en el historial para la fecha seleccionada.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../vistas/footer.php'; ?>
<script src="ejercicio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

