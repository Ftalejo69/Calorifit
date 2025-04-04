<?php
// Asegúrate de iniciar sesión para acceder a los datos del usuario
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

$usuario = $_SESSION['usuario']; // Datos del usuario que están en la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_rutina'])) {
    $indice = $_POST['indice'];
    if (isset($_SESSION['rutinas_completadas'][$indice])) {
        unset($_SESSION['rutinas_completadas'][$indice]);
        $_SESSION['rutinas_completadas'] = array_values($_SESSION['rutinas_completadas']); // Reindex array
        echo "<script>alert('La rutina se eliminó correctamente.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes de Entrenamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Font Awesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            <label for="tipo">Filtrar por tipo:</label>
            <select name="tipo" id="tipo">
                <option value="">Seleccionar tipo</option>
                <option value="Fuerza">Fuerza</option>
                <option value="Cardio">Cardio</option>
            </select>

            <label for="start_date">Desde:</label>
            <input type="date" name="start_date" id="start_date">

            <label for="end_date">Hasta:</label>
            <input type="date" name="end_date" id="end_date">

            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div id="historial" class="history-container">
        <div class="row">
            <?php if (isset($_SESSION['rutinas_completadas']) && !empty($_SESSION['rutinas_completadas'])): ?>
                <?php foreach ($_SESSION['rutinas_completadas'] as $indice => $rutina): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($rutina['nombre']); ?></h5>
                                <p class="card-text">Nivel: <span><?php echo htmlspecialchars($rutina['nivel']); ?></span></p>
                                <p class="card-text">Fecha: <span><?php echo htmlspecialchars($rutina['fecha']); ?></span></p>
                                <ul>
                                    <?php foreach ($rutina['ejercicios'] as $ejercicio): ?>
                                        <li>
                                            <span class="exercise-name"><?php echo htmlspecialchars($ejercicio['nombre']); ?></span>
                                            <span class="exercise-details">Series: <?php echo htmlspecialchars($ejercicio['series']); ?>, Repeticiones: <?php echo htmlspecialchars($ejercicio['repeticiones']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <form method="post" style="margin-top: 10px;">
                                    <input type="hidden" name="indice" value="<?php echo $indice; ?>">
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
                <p>No hay rutinas completadas en el historial.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include '../vistas/footer.php'; ?>


<script src="ejercicio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

