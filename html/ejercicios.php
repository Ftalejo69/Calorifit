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
    <title>Planes de Entrenamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Agregar Font Awesome para los iconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styleEjerci.css">
</head>
<body>

<?php include '../php/navbar.php'; ?>

<?php include '../php/modal_perfil.php'; ?>
  <!-- Sección de bienvenida -->
  <section class="welcome-section text-center">
    <h1>EJERCICIOS <span>CALORIFIT</span></h1>
    <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
<button id="openProfile" class="btn btn-outline-light mt-3">EJERCICIOS</button>
    
  </section>

    

 
       <!-- Footer -->
<footer class="gym-footer">
    <div class="footer-content">
      <h3>CaloriFit</h3>
      <p>Transformando cuerpos y mentes, un entrenamiento a la vez.</p>
      <ul class="socials">
        <li><a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook"></a></li>
        <li><a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Instagram"></a></li>
        <li><a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="Twitter"></a></li>
      </ul>
    </div>
    <div class="footer-bottom">
      <p>© 2025 CaloriFit. Todos los derechos reservados.</p>
    </div>
  </footer>
    
    <script src="ejercicio.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
