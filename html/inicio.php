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
  <title>CaloriFit</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="../css/estilo.css">
  <!-- Agregar Font Awesome para los iconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
  <?php include '../php/navbar.php'; ?>
  <?php include '../php/modal_perfil.php'; ?>



  <!-- Sección de Títulos -->
  <section class="text-center my-5">
    <h1 class="section-title">PLANES</h1>
    <h2 class="sub-title">CALORIFIT</h2>
  </section>

  <!-- Cards de planes -->
  <div class="container mb-5">
    <div class="row gy-4">
      <!-- Tarjeta 1 -->
      <a href="planes"></a><div class="col-md-4"></a>
        <div class="card">
          <img src="https://e00-mx-marca.uecdn.es/mx/assets/multimedia/imagenes/2023/05/20/16846178754107.jpg" class="card-img-top" alt="Hipertrofia">
          <div class="card-body">
            <h5 class="card-title">FIT</h5>
            <p class="card-text">Acceso a </p>
            <p class="card.t" style="color: rgb(255, 191, 0); margin-top: -40px; margin-left: 70px;"> Mucho Contenido</p>
            <p class="price">
                 <span class="price-discount" style="text-decoration: line-through;">$70.000</span>
              <span class="price-current" style="position: absolute ; margin-top: 20px; margin-left: -59px;">$40.000</span>
            </p>
            <div class="testo">
            <p class="card-detail">PLAN CON VARIEDAD </p>
            </div>
            <p class="card-validity">
              Válido del 1 al 5 de marzo del 2025.<br>
              PROMOCIÓN NO ACUMULABLE CON OTRAS PROMOCIONES.<br>
              No válida para la sede Buenavista Barranquilla.
            </p>
            <button class="btn btn-warning">Ver más +</button>
          </div>
        </div>
      </div>
      <!-- Tarjeta 2 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="arnold.jpg" class="card-img-top" alt="Fuerza">
          <div class="card-body">
            <h5 class="card-title">BLACK</h5>
            <p class="card-text">Acceso a </p>
            <p class="card.t" style="color: rgb(255, 191, 0); margin-top: -40px; margin-left: 70px;"> Mucho Contenido</p>
            <p class="price">
              <span class="price-discount" style="text-decoration: line-through;">$70.000</span>
              <span class="price-current" style="position: absolute ; margin-top: 20px; margin-left: -59px;">$40.000</span>
            </p>
            <div class="testo">
            <p class="card-detail">PLAN CON VARIEDAD </p>
            </div>
            <p class="card-validity">
              Válido del 1 al 5 de marzo del 2025.<br>
              PROMOCIÓN NO ACUMULABLE CON OTRAS PROMOCIONES.<br>
              No válida para la sede Buenavista Barranquilla.
            </p>
            <button class="btn btn-warning">Ver más +</button>
          </div>
        </div>
      </div>
      <!-- Tarjeta 3 -->
      <div class="col-md-4">
        <div class="card h-100">
          <img src="https://th.bing.com/th/id/R.75c2ef94bc631ceb46e613eed9ab5471?rik=ylWJYGFtp4ZBwQ&riu=http%3a%2f%2f5b0988e595225.cdn.sohucs.com%2fimages%2f20190403%2f7f7a1ae827d64742b6e3c71131b11fc8.jpg&ehk=pgvHntSg5eORVPol8OfQnbRlsbz%2fenpbL7mVEChnag4%3d&risl=&pid=ImgRaw&r=0" class="card-img-top" alt="Fuerza">
          <div class="card-body">
            <h5 class="card-title">CALO</h5>
            <p class="card-text">Acceso a </p>
            <p class="card.t" style="color: rgb(255, 191, 0); margin-top: -40px; margin-left: 70px;"> Mucho Contenido</p>
            <p class="price">
              <span class="price-discount" style="text-decoration: line-through;">$70.000</span>
              <span class="price-current" style="position: absolute ; margin-top: 20px; margin-left: -59px;">$40.000</span>
            </p>
            <div class="testo">
            <p class="card-detail">PLAN CON VARIEDAD</p>
            </div>
            <p class="card-validity">
              Válido del 1 al 5 de marzo del 2025.<br>
              PROMOCIÓN NO ACUMULABLE CON OTRAS PROMOCIONES.<br>
              No válida para la sede Buenavista Barranquilla.
            </p>
            <button class="btn btn-warning" onclick="togglePanel()">Ver más +</button>
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- Panel extra (Tarjeta detallada) -->
 <div class="container info-panel" id="infoPanel">
  <div class="card">
    <img src="https://th.bing.com/th/id/R.75c2ef94bc631ceb46e613eed9ab5471?rik=ylWJYGFtp4ZBwQ&riu=http%3a%2f%2f5b0988e595225.cdn.sohucs.com%2fimages%2f20190403%2f7f7a1ae827d64742b6e3c71131b11fc8.jpg&ehk=pgvHntSg5eORVPol8OfQnbRlsbz%2fenpbL7mVEChnag4%3d&risl=&pid=ImgRaw&r=0" alt="Ejercicio">
    <div class="text-content">
      <h5 class="card-title">Fuerza - Detalles</h5>
      <p class="card-text">
        La fuerza en el gym es la capacidad de generar tensión muscular al vencer una resistencia. El entrenamiento de fuerza, también conocido como entrenamiento de resistencia, es un método para fortalecer los músculos.
      </p>
    </div>
    <button class="btn btn-secondary btn-close-panel" onclick="togglePanel()">Cerrar</button>
  </div>
</div>
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


  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script personalizado -->
  <script>
    function togglePanel() {
      var panel = document.getElementById("infoPanel");
      panel.style.display = (panel.style.display === "none" || panel.style.display === "") ? "block" : "none";
    }
  </script>
  
  <script src="script.js"></script>
  
  <script>
  // Script para activar/desactivar los inputs y cambiar el texto del botón
  document.getElementById("editarBtn").addEventListener("click", function() {
    var telefonoInput = document.getElementById("telefono");
    var passwordInput = document.getElementById("password");

    // Habilitar o deshabilitar los campos de Teléfono y Contraseña
    telefonoInput.disabled = !telefonoInput.disabled;
    passwordInput.disabled = !passwordInput.disabled;

    // Cambiar el texto del botón entre "Editar" y "Guardar"
    if (telefonoInput.disabled) {
      this.textContent = "Editar";  // Si los campos están deshabilitados, cambiar el texto a "Editar"
    } else {
      this.textContent = "Guardar";  // Si los campos están habilitados, cambiar el texto a "Guardar"
    }
  });
  
</body>
</html>
