<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

$usuario = $_SESSION['usuario'];

// Obtener las membresías desde la base de datos
include_once '../configuracion/conexion.php';
$sql = "SELECT id, nombre, precio, duracion, descripcion FROM membresias ORDER BY precio ASC";
$result = $conexion->query($sql);
$membresias = [];
while ($row = $result->fetch_assoc()) {
    $membresias[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaloriFit</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../publico/css/estilo.css">
</head>
<body>
    <?php include '../vistas/navbar.php'; ?>
    <?php include '../vistas/modal_perfil.php'; ?>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <!-- Sección de bienvenida -->
    <section class="welcome-section text-center">
        <h1>Bienvenido a <span>CALORIFIT</span></h1>
        <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
        <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#planes'">Suscríbete ahora</button>
    </section>
  
    <section id="planes" class="container section-container">
        <h2 class="text-center professional-title text-warning">ELIGE EL MEJOR PLAN PARA TI</h2>
        <p class="text-center subtitle">AHORRA HASTA 30%</p>
        <div class="text-center mb-4">
            <div class="toggle-container">
                <button id="monthlyButton" class="toggle-btn active">MENSUAL</button>
                <button id="annualButton" class="toggle-btn">ANUAL</button>
            </div>
        </div>
        <div class="contenedor-tarjetas">
            <?php foreach ($membresias as $membresia): 
                $precioMensual = $membresia['precio'];
                $precioAnual = $precioMensual * 12 * 0.8; // 20% de descuento anual
                $precioRegular = $precioMensual * 1.4; // Precio regular (40% más alto)
            ?>
            <div class="card">
                <div class="card-img-container">
                    <img src="<?php echo obtenerImagenPlan($membresia['nombre']); ?>" alt="<?php echo htmlspecialchars($membresia['nombre']); ?>">
                </div>
                <div class="contenido">
                    <h2><?php echo htmlspecialchars($membresia['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($membresia['descripcion']); ?></p>
                    <h3 class="price plan-price" data-monthly="<?php echo $precioMensual; ?>" data-annual="<?php echo $precioAnual; ?>">
                        $<?php echo number_format($precioMensual, 0, ',', '.'); ?><span>/mes</span>
                    </h3>
                    <p class="price-discount" data-monthly="<?php echo $precioRegular; ?>" data-annual="<?php echo $precioAnual * 1.4; ?>">
                        $<?php echo number_format($precioRegular, 0, ',', '.'); ?>
                    </p>
                    <button class="boton" onclick="location.href='detalles_plan.php?plan=<?php echo strtolower(str_replace(' ', '_', $membresia['nombre'])); ?>&tipo=' + (annualButton.classList.contains('active') ? 'anual' : 'mensual') + '&precioMensual=<?php echo $precioMensual; ?>&precioAnual=<?php echo $precioAnual; ?>'">
                        Descubre más
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Tabla de comparación de planes -->
    <section class="container my-5">
        <h2 class="text-center mb-4 sub-title">Comparación de Planes</h2>
        <div class="table-responsive plan-comparison-wrapper">
            <table class="table plan-comparison-table text-center align-middle">
                <thead>
                    <tr>
                        <th>Beneficios</th>
                        <?php foreach ($membresias as $membresia): ?>
                            <th><?php echo htmlspecialchars($membresia['nombre']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $beneficios = [
                        'Acceso ilimitado a más de 1,700 sedes',
                        'Invitado 5 veces al mes',
                        'Spa y masajes',
                        'Descuentos en marcas aliadas',
                        'App personalizada',
                        'Seguimiento a tu progreso',
                        'Entrenamientos en línea',
                        'Clases grupales',
                        'Acceso a todas las áreas'
                    ];
                    
                    foreach ($beneficios as $beneficio): ?>
                        <tr>
                            <td><?php echo $beneficio; ?></td>
                            <?php foreach ($membresias as $membresia): 
                                $tiene_beneficio = tieneBeneficio($membresia['nombre'], $beneficio);
                            ?>
                                <td>
                                    <i class="fas fa-<?php echo $tiene_beneficio ? 'check' : 'times'; ?>-circle"></i>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="fw-bold">Desde</td>
                        <?php foreach ($membresias as $membresia): ?>
                            <td class="fw-bold">$<?php echo number_format($membresia['precio'], 0, ',', '.'); ?>/mes</td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
            <p class="table-note text-muted">*Valores promocionales. Aplican términos y condiciones.</p>
        </div>
    </section>

    <?php include '../vistas/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthlyButton = document.getElementById('monthlyButton');
        const annualButton = document.getElementById('annualButton');
        const prices = document.querySelectorAll('.plan-price');
        const discounts = document.querySelectorAll('.price-discount');

        function togglePlan(type) {
            prices.forEach(price => {
                const priceValue = parseFloat(price.getAttribute(`data-${type}`));
                price.innerHTML = `$${formatNumber(priceValue)}<span>/${type === 'monthly' ? 'mes' : 'año'}</span>`;
            });
            
            discounts.forEach(discount => {
                const discountValue = parseFloat(discount.getAttribute(`data-${type}`));
                discount.innerHTML = `$${formatNumber(discountValue)}`;
            });
        }

        function formatNumber(number) {
            return new Intl.NumberFormat('es-CO').format(Math.round(number));
        }

        monthlyButton.addEventListener('click', () => {
            togglePlan('monthly');
            monthlyButton.classList.add('active');
            annualButton.classList.remove('active');
        });

        annualButton.addEventListener('click', () => {
            togglePlan('annual');
            annualButton.classList.add('active');
            monthlyButton.classList.remove('active');
        });
    });
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../publico/js/script.js"></script>
</body>
</html>

<?php
function obtenerImagenPlan($nombre) {
    $nombre = strtolower($nombre);
    if (strpos($nombre, 'black') !== false) {
        return '../publico/imagenes/arnold.jpg';
    } elseif (strpos($nombre, 'fit') !== false) {
        return 'https://e00-mx-marca.uecdn.es/mx/assets/multimedia/imagenes/2023/05/20/16846178754107.jpg';
    } else {
        return 'https://th.bing.com/th/id/R.75c2ef94bc631ceb46e613eed9ab5471?rik=ylWJYGFtp4ZBwQ&riu=http%3a%2f%2f5b0988e595225.cdn.sohucs.com%2fimages%2f20190403%2f7f7a1ae827d64742b6e3c71131b11fc8.jpg&ehk=pgvHntSg5eORVPol8OfQnbRlsbz%2fenpbL7mVEChnag4%3d&risl=&pid=ImgRaw&r=0';
    }
}

function tieneBeneficio($nombrePlan, $beneficio) {
    $plan = strtolower($nombrePlan);
    
    // Beneficios básicos que todos los planes tienen
    $beneficios_basicos = [
        'App personalizada',
        'Seguimiento a tu progreso',
        'Entrenamientos en línea',
        'Clases grupales',
        'Acceso a todas las áreas'
    ];

    // Si es un beneficio básico, todos los planes lo tienen
    if (in_array($beneficio, $beneficios_basicos)) {
        return true;
    }

    // Beneficios exclusivos del plan BLACK
    if (strpos($plan, 'black') !== false) {
        return true; // El plan BLACK tiene todos los beneficios
    }

    // Para otros planes, solo tienen los beneficios básicos
    return false;
}
?>
