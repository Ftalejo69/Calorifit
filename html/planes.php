<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CaloriFit</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include '../php/navbar.php'; ?>
  <!-- Main Banner -->
  <div class="container mt-5 pt-5 text-center">
    <img src="https://img.freepik.com/foto-gratis/vista-angulo-hombre-musculoso-irreconocible-preparandose-levantar-barra-club-salud_637285-2497.jpg" alt="Banner" class="img-fluid rounded shadow-lg">
  </div>

  <!-- Sección de Títulos -->
  <section class="text-center my-5">
    <h1 class="section-title">PLANES</h1>
    <h2 class="sub-title">CALORIFIT</h2>
  </section>

  <!-- Cards de planes -->
  <div class="container mb-5">
    <div class="row gy-4">
      <div class="col-md-4">
        <div class="card h-100 shadow">
          <img src="https://e00-mx-marca.uecdn.es/mx/assets/multimedia/imagenes/2023/05/20/16846178754107.jpg" class="card-img-top" alt="Hipertrofia">
          <div class="card-body text-center">
            <h5 class="card-title">Black</h5>
            <p class="card-text">Plan con ejercicios avanzados.</p>
            <p class="price"><span class="price-current">$40.000</span></p>
            <button class="btn btn-warning">Ver más +</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow">
          <img src="imagenmiujer.jpg" class="card-img-top" alt="Fuerza">
          <div class="card-body text-center">
            <h5 class="card-title">CALO</h5>
            <p class="card-text">Ejercicios de resistencia y potencia.</p>
            <p class="price"><span class="price-current">$40.000</span></p>
            <button class="btn btn-warning">Ver más +</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow">
          <img src="https://images.pexels.com/photos/414029/pexels-photo-414029.jpeg" class="card-img-top" alt="Resistencia">
          <div class="card-body text-center">
            <h5 class="card-title">FIIT</h5>
            <p class="card-text">Entrenamiento para mejorar tu aguante físico.</p>
            <p class="price"><span class="price-current">$40.000</span></p>
            <button class="btn btn-warning">Ver más +</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Panel de información -->
  <div class="container animate-panel d-none" id="infoPanel">
    <div class="card shadow-lg p-4 text-center">
      <h5 id="panelTitle"></h5>
      <p id="panelDescription"></p>
      <button class="btn btn-secondary mt-3" onclick="togglePanel()">Cerrar</button>
    </div>
  </div>

  <!-- Misión y Visión Mejorado -->
  <section class="container text-center my-5">
    <div class="mission-vision p-4 rounded shadow-lg">
      <h2 class="section-title">Nuestra Misión</h2>
      <p>Transformamos vidas a través del entrenamiento físico, con planes personalizados para cada usuario.</p>
      <h2 class="section-title mt-4">Nuestra Visión</h2>
      <p>Ser la plataforma líder en bienestar, ofreciendo las mejores soluciones para el desarrollo físico y mental.</p>
    </div>
  </section>

  <!-- Modal de Perfil -->
  <div id="perfil" class="modal">
    <div class="modal-contenido">
        <!-- El contenido del perfil se cargará aquí dinámicamente -->
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-center text-light py-4">
    <div class="container">
      <p>&copy; 2025 CaloriFit. Todos los derechos reservados.</p>
      <div>
        <a href="#" class="text-warning mx-2">Términos y Condiciones</a>
        <a href="#" class="text-warning mx-2">Política de Privacidad</a>
      </div>
      <div class="mt-3">
        <a href="#" class="text-warning mx-2">Facebook</a>
        <a href="#" class="text-warning mx-2">Instagram</a>
        <a href="#" class="text-warning mx-2">Twitter</a>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="scripts.js"></script>
</body>
</html>
