<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

include '../configuracion/conexion.php'; // Añadir esta línea

$usuario = $_SESSION['usuario'];
$usuario_id = $usuario['id'];

// Obtener rutina actual del usuario
$sql = "SELECT DISTINCT r.nivel, r.nombre as objetivo 
        FROM rutinas r 
        INNER JOIN historial h ON h.nombre_rutina = r.nombre AND h.nivel = r.nivel
        WHERE h.usuario_id = ? 
        ORDER BY h.fecha DESC LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$rutina_actual = $result->fetch_assoc();

$sql_rutinas = "SELECT * FROM rutinas";
$result_rutinas = $conexion->query($sql_rutinas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../publico/css/rutinas.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include '../vistas/navbar.php'; ?>
<?php include '../vistas/modal_perfil.php'; ?>

<section class="welcome-section text-center">
    <h1>RUTINAS <span>CALORIFIT</span></h1>
    <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
    
    <?php if ($rutina_actual): ?>
        <div class="rutina-actual">
            <div class="rutina-header">
                <i class="fas fa-dumbbell"></i>
                <h2>Tu Rutina Actual</h2>
            </div>
            <div class="rutina-info">
                <div class="info-item">
                    <span class="label">Nivel:</span>
                    <span class="value"><?php echo htmlspecialchars($rutina_actual['nivel']); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Objetivo:</span>
                    <span class="value"><?php echo htmlspecialchars($rutina_actual['objetivo']); ?></span>
                </div>
            </div>
            <div class="rutina-actions">
                <button class="boton-principal" onclick="location.href='rutina_personalizada.php?nivel=<?php echo urlencode($rutina_actual['nivel']); ?>&objetivo=<?php echo urlencode($rutina_actual['objetivo']); ?>'">
                    <i class="fas fa-play"></i> Continuar mi Rutina
                </button>
                <button class="boton-secundario" onclick="mostrarSeleccionNivel()">
                    <i class="fas fa-exchange-alt"></i> Cambiar Rutina
                </button>
            </div>
        </div>
    <?php endif; ?>
</section>

<div id="seleccion-nivel" class="<?php echo $rutina_actual ? 'oculto' : ''; ?>">
    <div class="header">
        <h1 class="titulo">IMPULSA <span class="resaltar">TU COMPROMISO Y MOTIVACIÓN</span></h1>
        <p class="subtitulo">Elige tu programa de acompañamiento y seguimiento según tu objetivo</p>
    </div>
    
    <div id="rutinas" class="contenedor-tarjetas">
        <?php while ($row = $result_rutinas->fetch_assoc()): ?>
        <div class="tarjeta">
            <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
            <div class="contenido">
                <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                <button class="boton" onclick="redirigirNivel('<?php echo htmlspecialchars($row['nivel']); ?>')">Seleccionar Nivel</button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<section class="int">
    <div class="routine-section">
        <div>
            <div class="image-container">
                <img src="https://www.ific.es/blog/wp-content/uploads/2015/10/novato.jpg" alt="Principiante" class="section-image">
            </div>
            <h2>Principiante</h2>
            <p>Empieza con ejercicios básicos y sencillos. Ideal para aquellos que están comenzando o retomando su entrenamiento físico. Rutinas adaptadas para fortalecer tus bases.</p>
        </div>
    </div>

    <div class="routine-section">
        <div>
            <div class="image-container">
                <img src="../publico/imagenes/arnold.jpg" alt="Intermedio" class="section-image">
            </div>
            <h2>Intermedio</h2>
            <p>Aumenta la intensidad de tus entrenamientos. Diseñado para aquellos que ya tienen algo de experiencia y quieren llevar su condición física al siguiente nivel.</p>
        </div>
    </div>

    <div class="routine-section">
        <div>
            <div class="image-container">
                <img src="../publico/imagenes/David-Laid.jpg" alt="Avanzado" class="section-image">
            </div>
            <h2>Avanzado</h2>
            <p>Desafíos intensos para maximizar tu rendimiento. Pensado para quienes buscan perfeccionar sus habilidades y superar sus límites con entrenamientos exigentes.</p>
        </div>
    </div>
</section>

<?php include '../vistas/footer.php'; ?>
<script src="https://i.pinimg.com/originals/f2/ff/e4/f2ffe4ca8602818a4fd4abf1e3563964.jpg" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    function redirigirNivel(nivel) {
        location.href = `objetivo.php?nivel=${encodeURIComponent(nivel)}`;
    }

    function mostrarSeleccionNivel() {
        document.getElementById('seleccion-nivel').classList.remove('oculto');
    }
</script>
</body>
</html>