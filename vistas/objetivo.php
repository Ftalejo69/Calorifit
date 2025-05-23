<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

$usuario = $_SESSION['usuario']; // Datos del usuario que están en la sesión

$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : 'Principiante'; // Obtener el nivel de la URL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tu Objetivo</title>
    <link rel="stylesheet" href="../publico/css/objetivo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../vistas/navbar.php'; ?>

    <!-- Asegúrate de que el modal tenga la clase modal-dialog-scrollable -->
    <?php include '../vistas/modal_perfil.php'; ?>

    <div class="header text-center">
        <h1 class="titulo">¿CUÁL ES TU <span class="resaltar">OBJETIVO?</span></h1>
        <p class="subtitulo">Selecciona el objetivo que deseas alcanzar para personalizar tu rutina.</p>
    </div>
    <div class="contenedor-tarjetas">
        <div class="tarjeta" id="bajar-peso">
            <img src="../publico/imagenes/perdidaPeso.jpg" alt="Bajar de Peso">
            <div class="contenido">
                <h2>BAJAR DE PESO</h2>
                <p>Reduce grasa corporal con rutinas diseñadas para ti.</p>
                <button class="boton1" onclick="redirigir('Bajar de Peso')">Comenzar</button>
            </div>
        </div>
        <div class="tarjeta" id="ganar-musculo">
            <img src="../publico/imagenes/gananciaMuscular.jpg" alt="Ganancia de Músculo">
            <div class="contenido">
                <h2>GANANCIA DE MÚSCULO</h2>
                <p>Construye masa muscular con entrenamientos efectivos.</p>
                <button class="boton" onclick="redirigir('Ganar Músculo')">Comenzar</button>
            </div>
        </div>
        <div class="tarjeta" id="mantenimiento">
            <img src="../publico/imagenes/turcas.jpg" alt="Mantenimiento">
            <div class="contenido">
                <h2>MANTENIMIENTO</h2>
                <p>Mantén tu forma física con rutinas equilibradas.</p>
                <button class="boton3" onclick="redirigir('Mantenimiento')">Comenzar</button>
            </div>
        </div>
    </div>

    <?php include '../vistas/footer.php'; ?>
   
    <!-- FontAwesome para los iconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="../js/objetivo.js"></script>
    <script>
    function redirigir(objetivo) {
        const nivel = "<?php echo htmlspecialchars($nivel); ?>"; // Verificar que el nivel se pase correctamente
        location.href = `rutina_personalizada.php?objetivo=${encodeURIComponent(objetivo)}&nivel=${encodeURIComponent(nivel)}`;
    }
    </script>
</body>
</html>
