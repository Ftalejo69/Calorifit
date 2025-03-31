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
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrenadores</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .image-card {
      border-radius: 5%;
      width: 600px;
      height: 400px;
      object-fit: cover;
      margin: 0 auto;
      transition: transform 0.3s ease;
    }
    .image-card:hover {
      transform: scale(1.1);
    }
    .section-title {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

  <!-- Sección de Entrenadores -->


<?php include '../php/navbar.php'; ?>
<?php include '../php/modal_perfil.php'; ?>
  <!-- Main Banner -->
  <section class="container text-center my-5">
    <h2 class="section-title">Nuestros Entrenadores</h2>
    
    <!-- Row para las imágenes -->
    <div class="row justify-content-center">
      <!-- Entrenador 1 -->
   
      <!-- Entrenador 2 -->
      <div class="col-6">
        <img src="../imagenes/nosotros.png" alt="Entrenador 2" class="image-card">
      
      </div>

      <!-- Entrenador 3 -->

      
      
  </section>
   <div class="col-md-4">
        <img src="../imagenes/entrenador1.jpg" alt="Entrenador 1" class="image-card">
        <p class="trainer-description">Entrenador 1: Especialista en nutrición y entrenamiento físico.</p>
      </div>

      <!-- Entrenador 2 -->
      <div class="col-md-4">
        <img src="../imagenes/entrenador2.jpg" alt="Entrenador 2" class="image-card">
        <p class="trainer-description">Entrenador 2: Experto en desarrollo de fuerza y resistencia.</p>
      </div>

      <!-- Entrenador 3 -->
      <div class="col-md-4">
        <img src="../imagenes/entrenador3.jpg" alt="Entrenador 3" class="image-card">
        <p class="trainer-description">Entrenador 3: Líder en programas de entrenamiento funcional.</p>
      </div>
    </div>


  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>