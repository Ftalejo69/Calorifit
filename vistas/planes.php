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
    body {
      background-color: #f9f9f9;
      font-family: 'Poppins', sans-serif;
      color: #333;
    }

    /* Títulos con animación */
    .section-title {
      font-size: 3rem;
      font-weight: 600;
      margin-bottom: 50px;
      color: #f1c40f; /* Amarillo */
      text-transform: uppercase;
      letter-spacing: 1px;
      animation: fadeIn 1.5s ease-out;
    }

    /* Animación para el título */
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .main-image {
      border-radius: 15px;
      width: 100%;
      max-width: 900px;
      height: auto;
      margin: 30px auto;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .trainer-card {
      background-color: #fff;
      border: none;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .trainer-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .trainer-image {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      object-fit: cover;
      margin-top: 20px;
      border: 5px solid #f1c40f; /* Amarillo */
    }

    .trainer-description {
      font-size: 1.2rem;
      font-weight: 500;
      color: #7f8c8d;
      margin-top: 15px;
    }

    .card-body {
      padding: 2rem;
    }

    .card-title {
      font-size: 1.6rem;
      font-weight: 600;
      color: #34495e;
      margin-bottom: 15px;
    }

    .trainer-card .card-body {
      padding: 2rem;
    }

    .row {
      margin-top: 60px;
    }

    .card-footer {
      background-color: #f9fafb;
      border-top: 1px solid #ecf0f1;
    }

    .card-footer .btn {
      font-size: 1.1rem;
      background-color: #f1c40f; /* Amarillo */
      border: none;
      padding: 10px 20px;
      color: black;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .card-footer .btn:hover {
      background-color: #e67e22; /* Naranja */
    }

    .mission-vision-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .mission-vision-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .mission-vision-card .card-body {
      padding: 2rem;
    }

    .mission-vision-card .card-title {
      font-size: 1.6rem;
      font-weight: 600;
      color: #f1c40f; /* Amarillo */
    }

    .mission-vision-card .card-body p {
      color: rgb(0, 0, 0);
      font-size: 1rem;
      line-height: 1.8;
    }

    .container {
      max-width: 1200px;
    }

    /* Efecto hover para la imagen de la sección de entrenadores */
    .trainer-image:hover {
      border-color: #e67e22; /* Naranja */
    }

    /* Estilo para la sección Nosotros */
    .about-section p {
      font-size: 1.2rem;
      color: #7f8c8d;
      line-height: 1.8;
    }

    .about-section h3 {
      color: #f1c40f; /* Amarillo */
    }
    .welcome-section {
    background-color: #333; /* Fondo oscuro para resaltar el texto */
    color: white; /* Color de texto blanco para los elementos de la sección */
    padding: 50px 20px; /* Espaciado alrededor de la sección */
    text-align: center; /* Centrar todo el contenido */
    font-family: 'Arial', sans-serif; /* Familia de fuente general */
    opacity: 0; /* Comienza invisible para la animación */
    animation: fadeIn 2s ease-out forwards, slideUp 2s ease-out forwards; /* Animaciones */
  }
  
  /* Animación de desvanecimiento */
  @keyframes fadeIn {
    0% {
      opacity: 0; /* Comienza invisible */
    }
    100% {
      opacity: 1; /* Se hace visible al final */
    }
  }
  
  /* Animación de deslizamiento desde abajo */
  @keyframes slideUp {
    0% {
      transform: translateY(30px); /* Comienza 30px abajo */
    }
    100% {
      transform: translateY(0); /* Se mueve a su posición original */
    }
  }
  
  /* Estilos para el h1 */
  .welcome-section h1 {
    font-size: 40px; /* Tamaño de texto grande */
    font-weight: bold; /* Negrita para el encabezado */
    margin-bottom: 20px; /* Separación hacia abajo */
    color: white; /* Color blanco para el h1 */
    opacity: 0; /* Comienza invisible */
    animation: fadeIn 2s ease-out 0.5s forwards, slideUp 2s ease-out 0.5s forwards; /* Animación */
  }
  
  /* Estilos para el span */
  .welcome-section h1 span {
    color: #ffe600; /* Color naranja para el texto dentro del span */
    font-size: 40px; /* Mismo tamaño de letra que el h1 */
    font-weight: bold; /* Negrita para resaltar */
  }
  
  /* Estilos para el p */
  .welcome-section p {
    font-size: 25px; /* Tamaño de fuente moderado */
    font-family: 'Roboto', sans-serif; /* Fuente más elegante y moderna */
    color: #ccc; /* Color gris claro para el párrafo */
    line-height: 1.6; /* Espaciado entre líneas para mayor legibilidad */
    margin-bottom: 30px; /* Separación hacia abajo */
    opacity: 0; /* Comienza invisible */
    animation: fadeIn 2s ease-out 1s forwards, slideUp 2s ease-out 1s forwards; /* Animación */
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
