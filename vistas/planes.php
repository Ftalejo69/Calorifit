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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body{
  background: linear-gradient(180deg, #000000 0%, #1a1a1a 100%);
  font-family: 'Poppins', sans-serif;
  color: #ffe600;
  overflow-x: hidden;
}

.section-title {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 50px;
  color: #ffe600;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: relative;
}

.section-title::after {
  content: '';
  width: 100px;
  height: 4px;
  background-color: #ffe600;
  display: block;
  margin: 20px auto 0;
  border-radius: 2px;
}

.trainer-card {
  background-color: #1f1f1f;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 25px rgba(255, 230, 0, 0.2);
  transition: all 0.4s ease;
}

.trainer-card:hover {
  transform: scale(1.03);
  box-shadow: 0 20px 40px rgba(255, 230, 0, 0.3);
}

.trainer-image {
  width: 140px;
  height: 140px;
  object-fit: cover;
  border-radius: 50%;
  margin-top: 25px;
  border: 4px solid #ffe600;
  transition: border-color 0.3s;
}

.trainer-image:hover {
  border-color: #fff;
}

.card-title {
  color: #ffe600;
  font-size: 1.5rem;
  font-weight: 600;
}

.card-footer .btn {
  background-color: #ffe600;
  color: #000;
  border-radius: 30px;
  font-weight: bold;
  padding: 10px 25px;
  transition: all 0.3s ease;
}

.card-footer .btn:hover {
  background-color: transparent;
  color: #ffe600;
  border: 2px solid #ffe600;
}

.mission-vision-card {
  background-color: #2c2c2c;
  border-radius: 15px;
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 6px 20px rgba(255, 230, 0, 0.15);
}

.mission-vision-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(255, 230, 0, 0.25);
}

.about-section p {
  color: #ccc;
  font-size: 1.1rem;
  line-height: 1.8;
}

.welcome-section {
  padding: 70px 20px;
  background: radial-gradient(circle at center, #000 0%, #1b1b1b 100%);
}

.welcome-section h1 {
  font-size: 3rem;
  font-weight: 800;
  letter-spacing: 2px;
  color: #ffe600;
}

.welcome-section h1 span {
  color: #fff;
}

.welcome-section p {
  font-size: 1.3rem;
  margin-top: 20px;
  color: #ccc;
}

.welcome-section .btn {
  margin-top: 20px;
  padding: 10px 30px;
  font-size: 1.1rem;
  background-color: transparent;
  border: 2px solid #ffe600;
  color: #ffe600;
  transition: 0.3s ease;
  border-radius: 30px;
}

.welcome-section .btn:hover {
  background-color: #ffe600;
  color: #000;
}

  </style>
</head>
<body>

<?php include '../vistas/navbar.php'; ?>
<?php include '../vistas/modal_perfil.php'; ?>

<section class="welcome-section text-center">
    <h1>Bienvenido a <span>Nosotros</span></h1>
    <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#planes'">Nosotros</button>

  </section>

<section class="container text-center my-5">
  <h2 class="section-title">Nuestros Entrenadores</h2>
  
  <!-- Imagen principal -->
  <div class="row justify-content-center mb-5">
    <div class="col-12">
      <img src="../publico/imagenes/nosotros.png" alt="Nuestros Entrenadores" class="main-image">
    </div>
  </div>

  <!-- Row para las tarjetas de los entrenadores -->
  <div class="row justify-content-center">
    <!-- Entrenador 1 -->
    <div class="col-md-4 mb-4">
      <div class="card trainer-card text-center">
        <img src="../publico/imagenes/solno.jpeg" alt="Entrenador 1" class="trainer-image">
        <div class="card-body">
          <h5 class="card-title">Juan Solano</h5>
          <p class="trainer-description">Experto en desarrollo de fuerza y resistencia.</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn">Ver más</a>
        </div>
      </div>
    </div>

    <!-- Entrenador 2 -->
    <div class="col-md-4 mb-4">
      <div class="card trainer-card text-center">
        <img src="../publico/imagenes/eddy.jpeg" alt="Entrenador 2" class="trainer-image">
        <div class="card-body">
          <h5 class="card-title">Eddy Vargas</h5>
          <p class="trainer-description">Especialista en nutrición y entrenamiento físico.</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn">Ver más</a>
        </div>
      </div>
    </div>

    <!-- Entrenador 3 -->
    <div class="col-md-4 mb-4">
      <div class="card trainer-card text-center">
        <img src="../publico/imagenes/borja.jpeg" alt="Entrenador 3" class="trainer-image">
        <div class="card-body">
          <h5 class="card-title">Samuel Borja</h5>
          <p class="trainer-description">Líder en programas de entrenamiento funcional.</p>
        </div>
        <div class="card-footer text-center">
          <a href="#" class="btn">Ver más</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container text-center my-5 about-section">
  <h2 class="section-title">Nosotros</h2>
  
  <div class="row justify-content-center">
    <div class="col-md-10">
      <p>
        En <strong>Calorifit</strong>, nos dedicamos a transformar vidas a través de la salud y el bienestar. Nuestro equipo de expertos trabaja incansablemente para ofrecer programas personalizados que se adapten a las necesidades de cada individuo.
      </p>
    </div>
  </div>

  <div class="row mt-5">
    <!-- Misión -->
    <div class="col-md-6 mb-4">
      <div class="card mission-vision-card">
        <div class="card-body">
          <h3 class="card-title">Misión</h3>
          <p>Inspirar y empoderar a las personas para alcanzar su máximo potencial físico y mental, promoviendo un estilo de vida saludable y sostenible.</p>
        </div>
      </div>
    </div>

    <!-- Visión -->
    <div class="col-md-6 mb-4">
      <div class="card mission-vision-card">
        <div class="card-body">
          <h3 class="card-title">Visión</h3>
          <p>Ser líderes en el ámbito del bienestar integral, reconocidos por nuestra innovación, excelencia y compromiso con la salud de nuestros clientes.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../vistas/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
