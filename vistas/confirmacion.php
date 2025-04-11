<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje = $_SESSION['mensaje'] ?? 'No se realizó ninguna acción.';
unset($_SESSION['mensaje']);

// Simulate adding a plan to the user's session after payment confirmation
if (!isset($_SESSION['usuario']['plan'])) {
    $_SESSION['usuario']['plan'] = 'Plan Confirmado'; // Example plan name
}

// Clear the `isNewUser` flag when the user has a plan
if (isset($_SESSION['usuario']['plan']) && !empty($_SESSION['usuario']['plan'])) {
    $_SESSION['isNewUser'] = false;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/estilo.css">
    <style>
        .confirmacion-container {
            background: #ffffff; /* Fondo blanco */
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 3rem auto;
            text-align: center;
        }
        .confirmacion-container h1 {
            font-size: 2.8rem;
            font-weight: bold;
            color: #FFC107; /* Amarillo brillante */
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .confirmacion-container p {
            font-size: 1.3rem;
            color:rgb(124, 125, 108);
            margin-bottom: 2rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #FFC107, #FFD54F); /* Degradado amarillo */
            border: none; /* Eliminar cualquier borde */
            font-size: 1.3rem;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 50px;
            color: #333333; /* Texto oscuro */
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .btn-primary:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
            background: linear-gradient(135deg, #FFD54F, #FFC107); /* Cambio de degradado */
        }
        .icono-exito {
            font-size: 4rem;
            color: #FFC107; /* Amarillo brillante */
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="confirmacion-container">
            <div class="icono-exito">
                <i class="fas fa-check-circle"></i> <!-- Ícono de éxito -->
            </div>
            <h1><?= htmlspecialchars($mensaje) ?></h1>
            <p>Gracias por tu compra. Tu plan ha sido confirmado exitosamente.</p>
            <a href="inicio.php" class="btn btn-primary">Volver al Inicio</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
