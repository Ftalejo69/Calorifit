<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

$plan = isset($_GET['plan']) ? $_GET['plan'] : 'fit'; // Plan por defecto
$planes = [
    'fit' => [
        'nombre' => 'Plan FIT',
        'precio' => '$34.950/mes',
        'descripcion' => 'Acceso a contenido exclusivo.',
        'beneficios' => ['Entrenamientos en línea', 'Clases grupales', 'Acceso a todas las áreas'],
        'imagen' => '../publico/imagenes/fit.jpg',
        'testimonios' => [
            '¡Me encanta este plan! Es perfecto para entrenar desde casa. - Juan Pérez',
            'Gracias a este plan, logré mantenerme en forma. - María López'
        ]
    ],
    'black' => [
        'nombre' => 'Plan BLACK',
        'precio' => '$54.950/mes',
        'descripcion' => 'Acceso premium con beneficios exclusivos.',
        'beneficios' => ['Acceso ilimitado a sedes', 'Spa y masajes', 'Descuentos en marcas aliadas'],
        'imagen' => '../publico/imagenes/black.jpg',
        'testimonios' => [
            'El spa es increíble, lo recomiendo totalmente. - Ana Gómez',
            'El acceso ilimitado a sedes es lo mejor. - Carlos Ruiz'
        ]
    ],
    'calo' => [
        'nombre' => 'Plan CALO',
        'precio' => '$89.950/mes',
        'descripcion' => 'Acceso completo a todas las áreas y servicios.',
        'beneficios' => ['Seguimiento a tu progreso', 'App personalizada', 'Clases grupales'],
        'imagen' => '../publico/imagenes/calo.jpg',
        'testimonios' => [
            'El seguimiento a mi progreso me ha ayudado mucho. - Laura Martínez',
            'La app personalizada es súper útil. - Pedro Sánchez'
        ]
    ]
];

$detalles = $planes[$plan] ?? $planes['fit'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del <?= htmlspecialchars($detalles['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/estilo.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container my-5">
        <div class="detalles-container">
            <h1 class="text-center"><?= htmlspecialchars($detalles['nombre']) ?></h1>
            <p class="text-center text-muted"><?= htmlspecialchars($detalles['descripcion']) ?></p>
            <h3 class="text-center text-warning"><?= htmlspecialchars($detalles['precio']) ?></h3>
            <div class="text-center my-4">
                <img src="<?= htmlspecialchars($detalles['imagen']) ?>" alt="<?= htmlspecialchars($detalles['nombre']) ?>" class="img-fluid rounded">
            </div>
            <ul class="list-group my-4">
                <?php foreach ($detalles['beneficios'] as $beneficio): ?>
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
                <a href="pago.php?plan=<?= urlencode($plan) ?>" class="btn btn-warning">Ir al Pago</a>
            </div>
        </div>
        <div class="testimonios-container">
            <?php foreach ($detalles['testimonios'] as $testimonio): ?>
                <div class="testimonio-card">
                    <div class="estrellas">★★★★★</div>
                    <p>"<?= htmlspecialchars($testimonio) ?>"</p>
                    <?php if (strpos($testimonio, 'Juan Pérez') !== false): ?>
                        <img src="https://plus.unsplash.com/premium_photo-1689539137236-b68e436248de?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cGVyc29uYXxlbnwwfHwwfHx8MA%3D%3D" alt="Juan Pérez" class="autor-img">
                    <?php else: ?>
                        <img src="https://www.webconsultas.com/sites/default/files/styles/wc_adaptive_image__small/public/media/0d/articulos/perfil-resilencia.jpg.webp" alt="Autor" class="autor-img">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
