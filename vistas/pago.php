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

// Validar que el plan solicitado exista en el array $planes
if (!array_key_exists($plan, $planes)) {
    $plan = 'fit'; // Establecer un plan por defecto si no existe
}

$detalles = $planes[$plan];

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'mensual';
$precio = isset($_GET['precio']) ? floatval($_GET['precio']) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar <?= htmlspecialchars($detalles['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/estilo.css">
    <style>
        .pago-container {
            background: linear-gradient(135deg, #ffffff, #f9f9f9);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 2rem auto;
            text-align: center;
        }
        .pago-container h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #FFC107;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .pago-container p {
            font-size: 1.3rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .pago-container h4 {
            font-size: 2.2rem; /* Tamaño más grande */
            font-weight: bold;
            color: #FFC107; /* Amarillo brillante */
            text-transform: uppercase; /* Texto en mayúsculas */
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 1.5px; /* Espaciado entre letras */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            position: relative;
        }

        .pago-container h4::after {
            content: "";
            display: block;
            width: 100px; /* Ancho de la línea decorativa */
            height: 4px; /* Grosor de la línea */
            background: linear-gradient(90deg, #FFC107, #FFD54F); /* Degradado amarillo */
            margin: 10px auto 0; /* Centrado debajo del texto */
            border-radius: 2px; /* Bordes redondeados */
        }
        .list-group-item {
            background: #FFC107;
            color: #333333;
            border: none;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            border-radius: 15px;
            padding: 15px 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .list-group-item:hover {
            background: #FFD54F;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .payment-option {
            display: inline-block;
            text-align: center;
            cursor: pointer;
            border: 2px solid #ccc;
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
            width: 200px; /* Ancho ajustado */
            background: #ffffff; /* Fondo blanco */
        }
        .payment-option:hover {
            border-color: #FFC107;
            background-color: #fff8e1;
            transform: scale(1.05); /* Efecto de zoom */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Sombra ligera */
        }
        .payment-option input {
            display: none;
        }
        .payment-option .option-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem; /* Tamaño de texto más grande */
            color: #333333; /* Texto oscuro */
        }
        .payment-option .option-content i {
            font-size: 2.5rem; /* Tamaño más grande para los íconos */
            color: #FFC107; /* Amarillo brillante */
        }
        .payment-option .option-content img {
            width: 50px; /* Tamaño de la imagen */
            height: auto;
            margin-bottom: 10px;
        }
        .btn-success {
            background: linear-gradient(135deg, #FFC107, #FFD54F);
            border: none; /* Eliminar cualquier borde */
            font-size: 1.5rem; /* Tamaño más grande */
            font-weight: bold;
            padding: 15px 40px; /* Más espacio interno */
            border-radius: 50px;
            color: #333333; /* Texto oscuro */
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease; /* Animación fluida */
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px; /* Espaciado entre texto e ícono */
            position: relative;
            overflow: hidden;
        }
        .btn-success::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3); /* Efecto de brillo */
            transform: skewX(-45deg);
            transition: left 0.5s ease;
        }
        .btn-success:hover::before {
            left: 100%; /* Mover el brillo al pasar el cursor */
        }
        .btn-success:hover {
            transform: scale(1.1); /* Efecto de zoom */
            box-shadow: 0 12px 25px rgba(255, 193, 7, 0.5); /* Sombra más pronunciada */
            background: linear-gradient(135deg, #FFD54F, #FFC107); /* Cambio de degradado */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="pago-container">
        <h1>Pagar <?= htmlspecialchars($detalles['nombre']) ?></h1>
        <p>Precio: <?= $tipo === 'anual' ? '$' . number_format($precio, 0, ',', '.') . '/año' : '$' . number_format($precio, 0, ',', '.') . '/mes' ?></p>
        <h4>Resumen del Plan</h4>
        <ul class="list-group">
            <?php foreach ($detalles['beneficios'] as $beneficio): ?>
                <li class="list-group-item"><?= htmlspecialchars($beneficio) ?></li>
            <?php endforeach; ?>
        </ul>
        <form action="../controladores/PagoController.php" method="POST" class="mt-4">
            <input type="hidden" name="plan" value="<?= htmlspecialchars($detalles['nombre']) ?>">
            <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
            <input type="hidden" name="precio" value="<?= htmlspecialchars($precio) ?>">
            <h4>Selecciona tu método de pago</h4>
            <div class="d-flex justify-content-center gap-4 my-4">
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="Tarjeta" required>
                    <div class="option-content">
                        <img src="https://cdn-icons-png.flaticon.com/512/11135/11135810.png" alt="Tarjeta"> <!-- Imagen de tarjeta -->
                        <span>Tarjeta</span>
                    </div>
                </label>
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="PayPal">
                    <div class="option-content">
                        <img src="https://www.muyinteresante.com/wp-content/uploads/sites/5/2023/12/PayPal_Logo2014.svg_.png" alt="PayPal"> <!-- Imagen de PayPal -->
                        <span>PayPal</span>
                    </div>
                </label>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i> <!-- Ícono de confirmación -->
                Confirmar Pago
            </button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
