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
  background: linear-gradient(145deg, #1e1e1e, #2a2a2a);
  border-radius: 20px;
  overflow: hidden;
  perspective: 1000px;
  position: relative;
  height: 350px;
  width: 100%;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.trainer-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
}

.trainer-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s;
  transform-style: preserve-3d;
}

.trainer-card:hover .trainer-card-inner {
  transform: rotateY(180deg);
}

.trainer-card-front,
.trainer-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  border-radius: 20px;
}

.trainer-card-front {
  background: linear-gradient(145deg, #1f1f1f, #292929);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.trainer-card-back {
  background: linear-gradient(145deg, #ffe600, #ffd700);
  color: #000;
  transform: rotateY(180deg);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  position: relative;
}

.trainer-card-back .btn {
  margin-top: 15px;
  padding: 10px 25px;
  font-size: 1rem;
  background-color: #000;
  color: #ffe600;
  border: 2px solid #ffe600;
  border-radius: 25px;
  transition: all 0.3s ease;
}

.trainer-card-back .btn:hover {
  background-color: #ffe600;
  color: #000;
}

.trainer-image {
  width: 130px;
  height: 130px;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid #ffe600;
  margin-bottom: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.trainer-image:hover {
  transform: scale(1.1);
  box-shadow: 0 10px 20px rgba(255, 230, 0, 0.5);
}

.card-title {
  color: #ffe600;
  font-size: 1.6rem;
  font-weight: 700;
  margin-top: 10px;
}

.trainer-description {
  color: #ccc;
  font-size: 1rem;
  margin-top: 10px;
}

.trainer-card-back h5 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.trainer-card-back p {
  font-size: 1rem;
  line-height: 1.5;
  text-align: center;
}

.mission-vision-card {
  background: linear-gradient(145deg, #2e2e2e, #3a3a3a);
  border-radius: 20px;
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 4px 6px rgba(255, 230, 0, 0.1);
  position: relative;
  overflow: hidden;
}

.mission-vision-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(255, 230, 0, 0.15), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.mission-vision-card:hover::before {
  opacity: 1;
}

.mission-vision-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5), 0 8px 12px rgba(255, 230, 0, 0.2);
}

.mission-vision-card h3 {
  font-size: 1.8rem;
  font-weight: 700;
  color: #ffe600;
  margin-bottom: 1rem;
}

.mission-vision-card p {
  color: #e0e0e0;
  font-size: 1.1rem;
  line-height: 1.8;
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

.main-image {
  width: 50%;
  max-width: 350px;
  height: auto;
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.4s ease;
  margin: 0 auto;
  display: block;
  border: 4px solid transparent;
}

.main-image:hover {
  transform: scale(1.1);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
  border: 4px solid #ffe600;
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
    <div class="col-12 text-center">
      <img src="../publico/imagenes/nosotros.png" alt="Nuestros Entrenadores" class="main-image">
    </div>
  </div>

  <!-- Row para las tarjetas de los entrenadores -->
  <div class="row justify-content-center">
    <!-- Entrenador 1 -->
    <div class="col-md-4 mb-4">
      <div class="trainer-card">
        <div class="trainer-card-inner">
          <!-- Parte frontal -->
          <div class="trainer-card-front">
            <img src="../publico/imagenes/solno.jpeg" alt="Entrenador 1" class="trainer-image">
            <h5 class="card-title">Juan Solano</h5>
            <p class="trainer-description">Experto en desarrollo de fuerza y resistencia.</p>
          </div>
          <!-- Parte trasera -->
          <div class="trainer-card-back">
            <h5>Juan Solano</h5>
            <p>Certificado en entrenamiento de fuerza avanzada. Más de 10 años de experiencia ayudando a clientes a alcanzar sus metas.</p>
            <button class="btn" onclick="contactarEntrenador('Juan Solano')">Contactar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Entrenador 2 -->
    <div class="col-md-4 mb-4">
      <div class="trainer-card">
        <div class="trainer-card-inner">
          <!-- Parte frontal -->
          <div class="trainer-card-front">
            <img src="../publico/imagenes/eddy.jpeg" alt="Entrenador 2" class="trainer-image">
            <h5 class="card-title">Eddy Vargas</h5>
            <p class="trainer-description">Especialista en nutrición y entrenamiento físico.</p>
          </div>
          <!-- Parte trasera -->
          <div class="trainer-card-back">
            <h5>Eddy Vargas</h5>
            <p>Nutriólogo certificado y entrenador personal. Experto en planes alimenticios personalizados.</p>
            <button class="btn" onclick="contactarEntrenador('Eddy Vargas')">Contactar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Entrenador 3 -->
    <div class="col-md-4 mb-4">
      <div class="trainer-card">
        <div class="trainer-card-inner">
          <!-- Parte frontal -->
          <div class="trainer-card-front">
            <img src="../publico/imagenes/borja.jpeg" alt="Entrenador 3" class="trainer-image">
            <h5 class="card-title">Samuel Borja</h5>
            <p class="trainer-description">Líder en programas de entrenamiento funcional.</p>
          </div>
          <!-- Parte trasera -->
          <div class="trainer-card-back">
            <h5>Samuel Borja</h5>
            <p>Especialista en entrenamiento funcional y rehabilitación. Ayudando a clientes a mejorar su movilidad y fuerza.</p>
            <button class="btn" onclick="contactarEntrenador('Samuel Borja')">Contactar</button>
          </div>
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
          <p class="text-light">Inspirar y empoderar a las personas para alcanzar su máximo potencial físico y mental, promoviendo un estilo de vida saludable y sostenible.</p>
        </div>
      </div>
    </div>

    <!-- Visión -->
    <div class="col-md-6 mb-4">
      <div class="card mission-vision-card">
        <div class="card-body">
          <h3 class="card-title">Visión</h3>
          <p class="text-light">Ser líderes en el ámbito del bienestar integral, reconocidos por nuestra innovación, excelencia y compromiso con la salud de nuestros clientes.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../vistas/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function contactarEntrenador(nombre) {
    alert(`Has contactado a ${nombre}. Pronto recibirás más información.`);
  }
</script>

</body>
</html>
