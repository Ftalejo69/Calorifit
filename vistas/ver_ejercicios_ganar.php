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
    <title>Ejercicios para Ganar Músculo</title>
    <link rel="stylesheet" href="../publico/css/ver_ejercicios_ganar.css">
</head>
<body>
    <?php include '../vistas/navbar.php'; ?>
    <div class="header text-center">
        <h1 class="titulo">Ejercicios para Ganar Músculo</h1>
        <p class="subtitulo">Sigue esta rutina para alcanzar tus metas.</p>
    </div>
    <div class="contenedor-ejercicios">
        <div class="tarjetas-grid">
            <!-- Press de Banca -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Press de Banca</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/vthMCtgVtFw" 
                            title="Press de Banca - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio clave para desarrollar fuerza y masa muscular en el pecho.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Curl de Bíceps -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Curl de Bíceps</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/ykJmrZ5v0Oo" 
                            title="Curl de Bíceps - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio esencial para fortalecer y tonificar los bíceps.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Extensiones de Tríceps -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Extensiones de Tríceps</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/nRiJVZDpdL0" 
                            title="Extensiones de Tríceps - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Fortalece los tríceps y mejora la estabilidad del brazo.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Press Militar -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Press Militar</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/2yjwXTZQDDI" 
                            title="Press Militar - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio fundamental para desarrollar los hombros y la parte superior del cuerpo.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Remo con Barra -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Remo con Barra</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/9efgcAjQe7E" 
                            title="Remo con Barra - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio excelente para fortalecer la espalda y los músculos estabilizadores.</p>
                    <div class="autor">
                        <p>Calorifit</p>
                    </div>
                </div>
            </div>

            <!-- Sentadillas -->
            <div class="tarjeta-ejercicio">
                <h3 class="titulo-ejercicio">Sentadillas</h3>
                <div class="video-ejercicio">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/aclHkVaku9U" 
                            title="Sentadillas - Ejercicio" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div class="contenido-ejercicio">
                    <span class="descripcion-label">Descripción</span>
                    <p class="descripcion-ejercicio">Un ejercicio completo para fortalecer las piernas y mejorar la estabilidad.</p>
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
