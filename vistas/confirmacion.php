<?php
session_start();

$mensaje = $_SESSION['mensaje'] ?? 'No se realizó ninguna acción.';
unset($_SESSION['mensaje']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/estilo.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container my-5 text-center">
        <h1><?= htmlspecialchars($mensaje) ?></h1>
        <a href="inicio.php" class="btn btn-primary mt-3">Volver al Inicio</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
