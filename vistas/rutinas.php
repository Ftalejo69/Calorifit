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
    <title>Document</title>
    <link rel="stylesheet" href="../publico/css/rutinas.css">
      <!-- Agregar Font Awesome para los iconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body >

<?php include '../vistas/navbar.php'; ?>
<?php include '../vistas/modal_perfil.php'; ?>

 <!-- Sección de bienvenida -->
 <section class="welcome-section text-center">
    <h1> RUTINAS <span>CALORIFIT</span></h1>
    <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
<button id="openProfile" class="btn btn-outline-light mt-3"onclick="location.href='#rutinas'">ver las rutinas</button>
    
  </section>
<div class="header">
        <h1 class="titulo">IMPULSA <span class="resaltar">TU COMPROMISO Y MOTIVACIÓN</span></h1>
        <p class="subtitulo">Elige tu programa de acompañamiento y seguimiento según tu objetivo</p>
    </div>
    
    <div id="rutinas" class="contenedor-tarjetas">
        <div class="tarjeta">
            <img src="https://www.ific.es/blog/wp-content/uploads/2015/10/novato.jpg" alt="Principiante">
            <div class="contenido">
                <h2>PRINCIPIANTE</h2>
                <p>Empieza desde cero con un programa adaptado a ti.</p>
                <button class="boton" onclick="redirigirNivel('Principiante')">Seleccionar Nivel</button>
            </div>
        </div>
        
        <div class="tarjeta">
            <img src="../imagenes/David-Laid.jpg" alt="Intermedio">
            <div class="contenido">
                <h2>INTERMEDIO</h2>
                <p>Mejora tu rendimiento y lleva tu entrenamiento al siguiente nivel.</p>
                <button class="boton" onclick="redirigirNivel('Intermedio')">Seleccionar Nivel</button>
            </div>
        </div>
        
        <div class="tarjeta">
            <img src="../imagenes/David-Laid.jpg" alt="Avanzado">
            <div class="contenido">
                <h2>AVANZADO</h2>
                <p>Desafía tus límites y alcanza el máximo potencial.</p>
                <button class="boton" onclick="redirigirNivel('Avanzado')">Seleccionar Nivel</button>
            </div>
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
        <img src="../publico/imagenes/arnold.png" alt="Intermedio" class="section-image">
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


        <!-- Footer -->
        <?php include '../vistas/footer.php'; ?>
      <script src="https://i.pinimg.com/originals/f2/ff/e4/f2ffe4ca8602818a4fd4abf1e3563964.jpg" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script>
        function redirigirNivel(nivel) {
            location.href = `objetivo.php?nivel=${encodeURIComponent(nivel)}`;
        }
        </script>
</body>
</html>