<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

if (empty($_SESSION['usuario']['plan'])) {
    $_SESSION['mensaje'] = "Debe adquirir un plan para acceder a las rutinas.";
    header("Location: inicio.php");
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

// Obtener niveles únicos desde la tabla rutinas con el campo imagen
$query_niveles = "
    SELECT nivel, imagen 
    FROM rutinas 
    WHERE id IN (
        SELECT MIN(id) 
        FROM rutinas 
        GROUP BY nivel
    )
";
$result_niveles = $conexion->query($query_niveles);
$niveles = $result_niveles->fetch_all(MYSQLI_ASSOC);
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
    <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#seleccion-nivel'">Ver Rutinas</button>
    
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

<div id="seleccion-nivel">
    <div class="header">
        <h1 class="titulo">NIVELES</h1>
        <p class="subtitulo">Selecciona un nivel para ver los objetivos disponibles</p>
    </div>
    <div class="contenedor-tarjetas">
        <?php if (!empty($niveles)): ?>
            <?php foreach ($niveles as $nivel): ?>
            <div class="tarjeta">
                <img src="<?php echo htmlspecialchars($nivel['imagen']); ?>" alt="<?php echo htmlspecialchars($nivel['nivel']); ?>" class="nivel-imagen">
                <h2 class="text-center"><?php echo htmlspecialchars($nivel['nivel']); ?></h2>
                <button class="boton" onclick="redirigirNivel('<?php echo htmlspecialchars($nivel['nivel']); ?>')">Ver Objetivos</button>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay niveles disponibles.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function redirigirNivel(nivel) {
        location.href = `objetivo.php?nivel=${encodeURIComponent(nivel)}`;
    }
</script>

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