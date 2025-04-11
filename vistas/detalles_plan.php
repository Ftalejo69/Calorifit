<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

include_once '../configuracion/conexion.php';

$plan_id = isset($_GET['plan']) ? $_GET['plan'] : 'fit';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'mensual';

// Obtener los detalles del plan desde la base de datos
$sql = "SELECT * FROM membresias WHERE LOWER(REPLACE(nombre, ' ', '_')) = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $plan_id);
$stmt->execute();
$result = $stmt->get_result();
$plan = $result->fetch_assoc();

if (!$plan) {
    // Si no se encuentra el plan, redirigir a la página de planes
    header('Location: inicio.php');
    exit;
}

// Verificar si el usuario ya tiene una inscripción activa
include_once '../modelos/PagoModel.php';
$pagoModel = new PagoModel($conexion);
$tieneInscripcionActiva = $pagoModel->verificarInscripcionActiva($_SESSION['usuario']['id'], $plan['id']);

if ($tieneInscripcionActiva) {
    $_SESSION['mensaje'] = "Ya tienes un plan activo. No puedes contratar otro plan hasta que finalice tu plan actual.";
    header('Location: inicio.php');
    exit;
}

// Calcular precios
$precioMensual = $plan['precio'];
$precioAnual = $precioMensual * 12 * 0.8; // 20% de descuento anual
$precio = $tipo === 'anual' ? $precioAnual : $precioMensual;

// Definir testimonios según el plan
$testimonios = [
    'Plan FIT' => [
        '¡Me encanta este plan! Es perfecto para entrenar desde casa. - Juan Pérez',
        'Gracias a este plan, logré mantenerme en forma. - María López'
    ],
    'Plan BLACK' => [
        'El spa es increíble, lo recomiendo totalmente. - Ana Gómez',
        'El acceso ilimitado a sedes es lo mejor. - Carlos Ruiz'
    ],
    'Plan CALO' => [
        'El seguimiento a mi progreso me ha ayudado mucho. - Laura Martínez',
        'La app personalizada es súper útil. - Pedro Sánchez'
    ]
];

// Obtener testimonios para el plan actual
$testimonios_plan = $testimonios[$plan['nombre']] ?? [];

// Obtener los beneficios del plan desde la base de datos
$beneficios = [];
if ($plan['beneficios']) {
    $beneficios = json_decode($plan['beneficios'], true);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del <?= htmlspecialchars($plan['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/estilo.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <div class="container my-5">
        <div class="detalles-container">
            <h1 class="text-center"><?= htmlspecialchars($plan['nombre']) ?></h1>
            <p class="text-center text-muted"><?= htmlspecialchars($plan['descripcion']) ?></p>
            <h3 class="text-center text-warning">
                <?= $tipo === 'anual' ? '$' . number_format($precio, 0, ',', '.') . '/año' : '$' . number_format($precio, 0, ',', '.') . '/mes' ?>
            </h3>
            <ul class="list-group my-4">
                <?php foreach ($beneficios as $beneficio): ?>
                    <li class="list-group-item"><?= htmlspecialchars($beneficio) ?></li>
                <?php endforeach; ?>
            </ul>
            <h4 class="text-center mt-5">Preguntas Frecuentes</h4>
            <div class="accordion my-4" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            ¿Puedo cancelar mi plan en cualquier momento?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí, puedes cancelar tu plan en cualquier momento desde tu perfil.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            ¿Qué métodos de pago aceptan?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Aceptamos tarjetas de crédito, débito y PayPal.
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="pago.php?plan=<?= urlencode($plan_id) ?>&tipo=<?= urlencode($tipo) ?>&precio=<?= urlencode($precio) ?>&id=<?= urlencode($plan['id']) ?>" class="btn btn-warning">Ir al Pago</a>
            </div>
        </div>
        <div class="testimonios-container">
            <?php foreach ($testimonios_plan as $testimonio): ?>
                <div class="testimonio-card">
                    <div class="estrellas">★★★★★</div>
                    <p>"<?= htmlspecialchars($testimonio) ?>"</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
