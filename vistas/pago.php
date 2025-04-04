<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

$plan = isset($_GET['plan']) ? $_GET['plan'] : 'fit';
$planes = [
    'fit' => ['nombre' => 'Plan FIT', 'precio' => '$40.000', 'beneficios' => ['Acceso al gimnasio', 'Clases grupales', 'Entrenador personal']],
    'black' => ['nombre' => 'Plan BLACK', 'precio' => '$60.000', 'beneficios' => ['Acceso VIP', 'Clases exclusivas', 'Entrenador personal premium']],
    'calo' => ['nombre' => 'Plan CALO', 'precio' => '$80.000', 'beneficios' => ['Acceso ilimitado', 'Nutricionista', 'Entrenador personal avanzado']]
];

$detalles = $planes[$plan] ?? $planes['fit'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar <?= htmlspecialchars($detalles['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/estilo.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container my-5">
        <h1 class="text-center">Pagar <?= htmlspecialchars($detalles['nombre']) ?></h1>
        <p class="text-center text-muted">Precio: <?= htmlspecialchars($detalles['precio']) ?></p>
        <div class="text-center my-4">
            <h4>Resumen del Plan</h4>
            <ul class="list-group">
                <?php foreach ($planes[$plan]['beneficios'] as $beneficio): ?>
                    <li class="list-group-item"><?= htmlspecialchars($beneficio) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <form action="procesar_pago.php" method="POST" class="text-center">
            <input type="hidden" name="plan" value="<?= htmlspecialchars($detalles['nombre']) ?>">
            <h4 class="my-4">Selecciona tu método de pago</h4>
            <div class="d-flex justify-content-center gap-4">
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="Tarjeta" required>
                    <div class="option-content">
                        <i class="fas fa-credit-card fa-2x"></i>
                        <span>Tarjeta</span>
                    </div>
                </label>
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="PayPal">
                    <div class="option-content">
                        <i class="fab fa-paypal fa-2x"></i>
                        <span>PayPal</span>
                    </div>
                </label>
            </div>
            <button type="submit" class="btn btn-success mt-4">Confirmar Pago</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
