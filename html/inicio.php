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
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
  <?php include '../php/navbar.php'; ?>
  <?php include '../php/modal_perfil.php'; ?>

  <!-- Sección de bienvenida -->
  <section class="welcome-section text-center">
    <h1>Bienvenido a <span>CaloriFit</span></h1>
    <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
<button id="openProfile" class="btn btn-outline-light mt-3">suscribete ahora</button>
    
  </section>

  <!-- Sección de planes -->
  <section class="container my-5">
    <h2 class="text-center sub-title mb-4">Nuestros Planes</h2>
    <div class="row gy-4">
      <!-- Tarjeta 1 -->
      <div class="col-md-4">
        <div class="card plan-card h-100 text-center">
          <img src="https://e00-mx-marca.uecdn.es/mx/assets/multimedia/imagenes/2023/05/20/16846178754107.jpg" class="card-img-top" alt="Plan FIT">
          <div class="card-body">
            <h5 class="card-title fw-bold">FIT</h5>
            <p class="card-text">Acceso a contenido exclusivo para mejorar tu entrenamiento.</p>
            <h3 class="price">$40.000<span class="fs-6">/mes</span></h3>
            <p class="price-discount text-decoration-line-through">$70.000</p>
            <button class="btn btn-outline-secondary w-100 mt-3">Ver más</button>
          </div>
        </div>
      </div>
      <!-- Tarjeta 2 -->
      <div class="col-md-4">
        <div class="card plan-card h-100 text-center">
          <img src="../imagenes/arnold.jpg" class="card-img-top" alt="Plan BLACK">
          <div class="card-body">
            <h5 class="card-title fw-bold">BLACK</h5>
            <p class="card-text">Acceso premium con beneficios exclusivos.</p>
            <h3 class="price">$60.000<span class="fs-6">/mes</span></h3>
            <p class="price-discount text-decoration-line-through">$90.000</p>
            <button class="btn btn-outline-secondary w-100 mt-3">Ver más</button>
          </div>
        </div>
      </div>
      <!-- Tarjeta 3 -->
      <div class="col-md-4">
        <div class="card plan-card h-100 text-center">
          <img src="https://th.bing.com/th/id/R.75c2ef94bc631ceb46e613eed9ab5471?rik=ylWJYGFtp4ZBwQ&riu=http%3a%2f%2f5b0988e595225.cdn.sohucs.com%2fimages%2f20190403%2f7f7a1ae827d64742b6e3c71131b11fc8.jpg&ehk=pgvHntSg5eORVPol8OfQnbRlsbz%2fenpbL7mVEChnag4%3d&risl=&pid=ImgRaw&r=0" class="card-img-top" alt="Plan CALO">
          <div class="card-body">
            <h5 class="card-title fw-bold">CALO</h5>
            <p class="card-text">Acceso completo a todas las áreas y servicios.</p>
            <h3 class="price">$80.000<span class="fs-6">/mes</span></h3>
            <p class="price-discount text-decoration-line-through">$120.000</p>
            <button class="btn btn-outline-secondary w-100 mt-3">Ver más</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tabla de comparación de planes -->
  <section class="container my-5">
    <h2 class="text-center mb-4 sub-title">Comparación de Planes</h2>
    <div class="table-responsive">
      <table class="table plan-comparison-table text-center align-middle">
        <thead>
          <tr>
            <th>Beneficios</th>
            <th>Plan Black</th>
            <th>Plan Fit</th>
            <th>Plan Calo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Acceso ilimitado a más de 1,700 sedes</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>Invitado 5 veces al mes</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>Spa y masajes</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>Descuentos en marcas aliadas</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
            <td><i class="fas fa-times-circle"></i></td>
          </tr>
          <tr>
            <td>App personalizada</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Seguimiento a tu progreso</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Entrenamientos en línea</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Clases grupales</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td>Acceso a todas las áreas</td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
            <td><i class="fas fa-check-circle"></i></td>
          </tr>
          <tr>
            <td class="fw-bold">Desde</td>
            <td class="fw-bold">$54,950/mes</td>
            <td class="fw-bold">$34,950/mes</td>
            <td class="fw-bold">$89,900/mes</td>
          </tr>
        </tbody>
      </table>
      <p class="table-note text-muted">*Valores promocionales. Aplican términos y condiciones.</p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="gym-footer">
    <div class="footer-content text-center">
      <h3>CaloriFit</h3>
      <p>Transformando cuerpos y mentes, un entrenamiento a la vez.</p>
      <ul class="socials d-flex justify-content-center list-unstyled">
        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
      </ul>
    </div>
    <div class="footer-bottom text-center">
      <p>© 2025 CaloriFit. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/script.js"></script>
</body>
</html>
