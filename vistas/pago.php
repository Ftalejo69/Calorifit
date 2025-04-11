<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

include_once '../configuracion/conexion.php';

// Obtener datos del plan desde la URL
$membresia_id = isset($_GET['id']) ? $_GET['id'] : null;
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'mensual';
$precio = isset($_GET['precio']) ? floatval($_GET['precio']) : 0;

// Obtener los detalles de la membresía desde la base de datos
$sql = "SELECT * FROM membresias WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $membresia_id);
$stmt->execute();
$result = $stmt->get_result();
$membresia = $result->fetch_assoc();

if (!$membresia) {
    $_SESSION['mensaje'] = "Plan no encontrado";
    header('Location: inicio.php');
    exit;
}

// Verificar si el usuario ya tiene una inscripción activa
$tieneInscripcionActiva = $pagoModel->verificarInscripcionActiva($_SESSION['usuario']['id'], $membresia_id);

if ($tieneInscripcionActiva) {
    $_SESSION['mensaje'] = "Ya tienes un plan activo. No puedes contratar otro plan hasta que finalice tu plan actual.";
    header('Location: inicio.php');
    exit;
}

// Obtener los beneficios del plan
$beneficios = [];
if ($membresia['beneficios']) {
    $beneficios = json_decode($membresia['beneficios'], true);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar <?= htmlspecialchars($membresia['nombre']) ?></title>
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
            font-size: 2.2rem;
            font-weight: bold;
            color: #FFC107;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 1.5px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .pago-container h4::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #FFC107, #FFD54F);
            margin: 10px auto 0;
            border-radius: 2px;
        }
        .list-group-item {
            background: linear-gradient(135deg, #FFC107, #FFD54F);
            color: #333333;
            border: none;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            border-radius: 15px;
            padding: 15px 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .list-group-item:hover {
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
            width: 200px;
            background: #ffffff;
        }
        .payment-option:hover {
            border-color: #FFC107;
            background-color: #fff8e1;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .payment-option input {
            display: none;
        }
        .payment-option .option-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            color: #333333;
        }
        .payment-option .option-content img {
            width: 50px;
            height: auto;
            margin-bottom: 10px;
        }
        .btn-success {
            background: linear-gradient(135deg, #FFC107, #FFD54F);
            border: none;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 15px 40px;
            border-radius: 50px;
            color: #333333;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            margin: 2rem auto;
        }
        .btn-success::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform: skewX(-45deg);
            transition: left 0.5s ease;
        }
        .btn-success:hover::before {
            left: 100%;
        }
        .btn-success:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 25px rgba(255, 193, 7, 0.5);
            background: linear-gradient(135deg, #FFD54F, #FFC107);
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="pago-container">
        <h1>Pagar <?= htmlspecialchars($membresia['nombre']) ?></h1>
        <p>Precio: <?= $tipo === 'anual' ? '$' . number_format($precio, 0, ',', '.') . '/año' : '$' . number_format($precio, 0, ',', '.') . '/mes' ?></p>
        
        <h4>Resumen del Plan</h4>
        <ul class="list-group mb-4">
            <?php foreach ($beneficios as $beneficio): ?>
                <li class="list-group-item"><?= htmlspecialchars($beneficio) ?></li>
            <?php endforeach; ?>
        </ul>

        <form action="../controladores/PagoController.php" method="POST">
            <input type="hidden" name="membresia_id" value="<?= htmlspecialchars($membresia_id) ?>">
            <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
            <input type="hidden" name="precio" value="<?= htmlspecialchars($precio) ?>">
            
            <h4>Selecciona tu método de pago</h4>
            <div class="d-flex justify-content-center gap-4 my-4">
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="Tarjeta" required>
                    <div class="option-content">
                        <img src="https://cdn-icons-png.flaticon.com/512/11135/11135810.png" alt="Tarjeta">
                        <span>Tarjeta</span>
                    </div>
                </label>
                <label class="payment-option">
                    <input type="radio" name="metodo_pago" value="PayPal">
                    <div class="option-content">
                        <img src="https://www.muyinteresante.com/wp-content/uploads/sites/5/2023/12/PayPal_Logo2014.svg_.png" alt="PayPal">
                        <span>PayPal</span>
                    </div>
                </label>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check-circle"></i>
                Confirmar Pago
            </button>
        </form>
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
