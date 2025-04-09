<?php
// Asegúrate de iniciar sesión para acceder a los datos del usuario
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

$usuario = $_SESSION['usuario']; // Datos del usuario que están en la sesión
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios para Mantenimiento</title>
    <link rel="stylesheet" href="../publico/css/ver_ejercicios_mantenimiento.css">
</head>
<body>
    <?php include '../vistas/navbar.php'; ?>
    <div class="header text-center">
        <h1 class="titulo">Ejercicios para Mantenimiento</h1>
        <p class="subtitulo">Sigue esta rutina para alcanzar tus metas.</p>
    </div>
    <div class="contenedor-ejercicios">
        <div class="tarjetas-grid">
            <!-- Cinta de Correr -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Cinta de Correr</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/ji-5miebSAk" 
                            title="Cinta de Correr - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio cardiovascular ideal para mantener tu peso y mejorar tu resistencia.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Sentadilla -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Sentadilla</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/aclHkVaku9U" 
                            title="Sentadilla - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio fundamental para fortalecer las piernas y glúteos.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Abdominales -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Abdominales</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/5ER5Of4MOPI" 
                            title="Abdominales - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio clásico para fortalecer el core y mejorar la postura.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Flexiones -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Flexiones</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/IODxDxX7oi4" 
                            title="Flexiones - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio efectivo para trabajar el pecho, brazos y core.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Plancha -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Plancha</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/pSHjTRCQxIw" 
                            title="Plancha - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio isométrico excelente para fortalecer el core y mejorar la estabilidad.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../vistas/footer.php'; ?>
</body>
</html>
