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
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
  background: linear-gradient(180deg, #121212 0%, #1e1e1e 100%);
  font-family: 'Poppins', sans-serif;
  color: #f8f9fa;
  overflow-x: hidden;
}

.section-title {
  font-size: 2.8rem;
  font-weight: 700;
  margin-bottom: 40px;
  color: #ffe600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  position: relative;
}

.section-title::after {
  content: '';
  width: 80px;
  height: 3px;
  background-color: #ffe600;
  display: block;
  margin: 15px auto 0;
  border-radius: 2px;
}

.trainer-card {
  background: #ffe600; /* Fondo amarillo sólido */
  border-radius: 20px; /* Bordes más redondeados */
  overflow: hidden;
  position: relative;
  height: 400px; /* Altura ajustada */
  width: 100%;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Sombra más suave */
}

.trainer-card:hover {
  transform: translateY(-10px); /* Efecto de elevación */
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); /* Sombra más pronunciada */
}

.trainer-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s ease-in-out;
  transform-style: preserve-3d;
}

.trainer-card:hover .trainer-card-inner {
  transform: rotateY(180deg); /* Efecto de rotación */
}

.trainer-card-front,
.trainer-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  border-radius: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.trainer-card-front {
  background: #ffe600; /* Fondo amarillo */
  color: #000; /* Texto negro */
}

.trainer-card-back {
  background: #292929; /* Fondo oscuro */
  color: #fff; /* Texto blanco */
  transform: rotateY(180deg);
}

.trainer-card-back .btn {
  margin-top: 15px;
  padding: 10px 25px;
  font-size: 1rem;
  background-color: #ffe600;
  color: #000;
  border: none;
  border-radius: 25px;
  transition: all 0.3s ease;
}

.trainer-card-back .btn:hover {
  background-color: #ffd700;
  transform: scale(1.1);
}

.trainer-image {
  width: 150px; /* Tamaño más grande */
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
  border: 5px solid #000; /* Borde negro */
  margin-bottom: 15px;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.trainer-image:hover {
  transform: scale(1.2);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3); /* Sombra más suave */
}

.card-title {
  color: #000; /* Texto negro */
  font-size: 1.8rem; /* Tamaño más grande */
  font-weight: 700;
  margin-top: 10px;
}

.trainer-description {
  color: #333; /* Texto gris oscuro */
  font-size: 1rem;
  margin-top: 10px;
  text-align: center;
  line-height: 1.5;
}

.mission-vision-card {
  background: linear-gradient(145deg, #1e1e1e, #292929); /* Fondo más elegante */
  border-radius: 20px; /* Bordes más redondeados */
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5), 0 4px 6px rgba(255, 230, 0, 0.2); /* Sombra más pronunciada */
  position: relative;
  overflow: hidden;
}

.mission-vision-card:hover {
  transform: translateY(-10px); /* Efecto de elevación */
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.6), 0 6px 12px rgba(255, 230, 0, 0.3); /* Sombra más intensa */
}

.mission-vision-card h3 {
  font-size: 1.8rem; /* Tamaño más grande */
  font-weight: 800;
  color: #ffe600;
  margin-bottom: 1.5rem;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mission-vision-card h3 i {
  margin-right: 10px; /* Espaciado entre el ícono y el texto */
}

.mission-vision-card p {
  color: #e0e0e0; /* Texto más claro */
  font-size: 1rem;
  line-height: 1.8;
  text-align: center;
}

.mission-vision-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle, rgba(255, 230, 0, 0.1), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.mission-vision-card:hover::before {
  opacity: 1; /* Efecto de brillo al pasar el mouse */
}

.welcome-section {
  padding: 60px 20px;
  background: radial-gradient(circle at center, #000 0%, #1a1a1a 100%);
}

.welcome-section h1 {
  font-size: 2.8rem; /* Tamaño ajustado */
  font-weight: 800;
  letter-spacing: 1.5px;
  color: #ffe600;
}

.welcome-section h1 span {
  color: #fff;
  font-size: inherit; /* Mantener el tamaño igual al de "Bienvenido" */
}

/* Botón eliminado */

.welcome-section p {
  font-size: 1.2rem;
  margin-top: 20px;
  color: #bbb;
}

.welcome-section .btn {
  margin-top: 20px;
  padding: 10px 30px;
  font-size: 1rem;
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

.main-image-container {
  position: relative;
  display: inline-block;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  width: 70%; /* Tamaño ligeramente aumentado */
  max-width: 320px;
  border: 5px solid #ffe600; /* Borde amarillo */
}

.main-image-container:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
}

.main-image {
  width: 100%;
  height: auto;
  transition: transform 0.3s ease;
}

.main-image-container:hover .main-image {
  transform: scale(1.08);
}

.main-image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  opacity: 0;
  transition: opacity 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffe600;
  font-size: 1.3rem; /* Tamaño ajustado */
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.main-image-container:hover .main-image-overlay {
  opacity: 1;
}

  </style>
</head>
<body>

<?php include '../vistas/navbar.php'; ?>
<?php include '../vistas/modal_perfil.php'; ?>

<section class="welcome-section text-center">
  <h1>Bienvenido a <span>Nosotros</span></h1>
</section>

<section class="container text-center my-5">
  <h2 class="section-title"><i class="fas fa-users"></i> Nuestros Entrenadores</h2>
  <p class="mt-3 text-light fs-5">"El éxito no es un accidente, es el resultado de la preparación, el trabajo duro y el aprendizaje constante."</p>
  
  <!-- Imagen principal con animación -->
  <div class="row justify-content-center mb-5">
    <div class="col-12 text-center">
      <div class="main-image-container">
        <img src="../publico/imagenes/nosotros.png" alt="Nuestros Entrenadores" class="main-image">
        <div class="main-image-overlay">¡Conócenos!</div>
      </div>
    </div>
  </div>

  <!-- Logros destacados -->
  <div class="row text-center text-light mb-5">
    <div class="col-md-4">
      <h3 class="fs-4 fw-bold text-warning">+500</h3>
      <p>Usuarios satisfechos</p>
    </div>
    <div class="col-md-4">
      <h3 class="fs-4 fw-bold text-warning">+10</h3>
      <p>Años de experiencia</p>
    </div>
    <div class="col-md-4">
      <h3 class="fs-4 fw-bold text-warning">100%</h3>
      <p>Planes personalizados</p>
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
            <button class="btn btn-primary" onclick="abrirModal('Juan Solano')">Contactar</button>
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
            <button class="btn btn-primary" onclick="abrirModal('Eddy Vargas')">Contactar</button>
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
            <button class="btn btn-primary" onclick="abrirModal('Samuel Borja')">Contactar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">Contacto con <span id="trainerName"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Teléfono:</strong> <span id="trainerPhone"></span></p>
        <p><strong>Correo:</strong> <span id="trainerEmail"></span></p>
        <div class="chat-container">
          <h6>Chat en vivo</h6>
          <div id="chatMessages" class="chat-messages border rounded p-3 mb-3" style="height: 200px; overflow-y: auto; background-color: #f8f9fa; color: #000;"></div>
          <div class="input-group">
            <input type="text" id="chatInput" class="form-control" placeholder="Escribe un mensaje...">
            <button class="btn btn-primary" id="sendMessageButton">Enviar</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<section class="container text-center my-5 about-section">
  <h2 class="section-title"><i class="fas fa-heartbeat"></i> Nosotros</h2>
  
  <div class="row justify-content-center">
    <div class="col-md-10">
      <p style="color: #fff;">
        En <strong>Calorifit</strong>, nos dedicamos a transformar vidas a través de la salud y el bienestar. Nuestro equipo de expertos trabaja incansablemente para ofrecer programas personalizados que se adapten a las necesidades de cada individuo.
      </p>
    </div>
  </div>

  <div class="row mt-5">
    <!-- Misión -->
    <div class="col-md-6 mb-4">
      <div class="card mission-vision-card">
        <div class="card-body">
          <h3 class="card-title"><i class="fas fa-bullseye"></i> Misión</h3>
          <p class="text-light">Inspirar y empoderar a las personas para alcanzar su máximo potencial físico y mental, promoviendo un estilo de vida saludable y sostenible.</p>
        </div>
      </div>
    </div>

    <!-- Visión -->
    <div class="col-md-6 mb-4">
      <div class="card mission-vision-card">
        <div class="card-body">
          <h3 class="card-title"><i class="fas fa-eye"></i> Visión</h3>
          <p class="text-light">Ser líderes en el ámbito del bienestar integral, reconocidos por nuestra innovación, excelencia y compromiso con la salud de nuestros clientes.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container text-center my-5">
  <h2 class="section-title"><i class="fas fa-comments"></i> Testimonios</h2>
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card bg-dark text-light shadow">
        <div class="card-body">
          <i class="fas fa-quote-left text-warning mb-3"></i>
          <p class="card-text">"Gracias a Calorifit, logré perder 10 kg en 3 meses. ¡Los entrenadores son increíbles!"</p>
          <h5 class="card-title">- María López</h5>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card bg-dark text-light shadow">
        <div class="card-body">
          <i class="fas fa-quote-left text-warning mb-3"></i>
          <p class="card-text">"El plan personalizado de nutrición cambió mi vida. ¡Altamente recomendado!"</p>
          <h5 class="card-title">- Carlos Pérez</h5>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card bg-dark text-light shadow">
        <div class="card-body">
          <i class="fas fa-quote-left text-warning mb-3"></i>
          <p class="card-text">"Nunca me sentí tan motivado para entrenar. ¡Gracias Calorifit!"</p>
          <h5 class="card-title">- Ana García</h5>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-4 position-relative">
    <a href="inicio.php" class="btn btn-warning btn-xl text-dark fw-bold rounded-pill animate-btn">Suscríbete</a>
    <div class="arrow-container">
      <i class="fas fa-arrow-down text-warning arrow" style="left: 45%;"></i>
      <i class="fas fa-arrow-down text-warning arrow" style="left: 55%;"></i>
    </div>
  </div>
</section>

<style>
  .arrow-container {
    position: absolute;
    top: -50px;
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 20px;
    animation: bounce 1.5s infinite;
  }

  .arrow {
    font-size: 2.5rem;
  }

  @keyframes bounce {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-10px);
    }
  }

  .btn-xl {
    padding: 15px 40px;
    font-size: 1.5rem;
  }

  .animate-btn {
    position: relative;
    animation: pulse 1.5s infinite;
  }

  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
  }
</style>

<!-- Modal de contacto -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">Contacto con <span id="trainerName"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Teléfono:</strong> <span id="trainerPhone"></span></p>
        <p><strong>Correo:</strong> <span id="trainerEmail"></span></p>
        <p><strong>Chat:</strong> <a href="#" id="trainerChat" target="_blank">Iniciar chat</a></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php include '../vistas/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const trainers = {
    "Juan Solano": {
      phone: "123-456-7890",
      email: "juan.solano@calorifit.com",
      chat: "https://chat.calorifit.com/juan-solano"
    },
    "Eddy Vargas": {
      phone: "987-654-3210",
      email: "eddy.vargas@calorifit.com",
      chat: "https://chat.calorifit.com/eddy-vargas"
    },
    "Samuel Borja": {
      phone: "555-123-4567",
      email: "samuel.borja@calorifit.com",
      chat: "https://chat.calorifit.com/samuel-borja"
    }
  };

  function contactarEntrenador(nombre) {
    const trainer = trainers[nombre];
    if (trainer) {
      document.getElementById('trainerName').textContent = nombre;
      document.getElementById('trainerPhone').textContent = trainer.phone;
      document.getElementById('trainerEmail').textContent = trainer.email;
      document.getElementById('trainerChat').href = trainer.chat;
      const contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
      contactModal.show();
    }
  }

  function abrirModal(nombre) {
    const trainer = trainers[nombre];
    if (trainer) {
      document.getElementById('trainerName').textContent = nombre;
      document.getElementById('trainerPhone').textContent = trainer.phone;
      document.getElementById('trainerEmail').textContent = trainer.email;
      document.getElementById('chatMessages').innerHTML = ''; // Limpiar mensajes previos
      const contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
      contactModal.show();
    }
  }

  document.getElementById('sendMessageButton').addEventListener('click', function () {
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');
    const message = chatInput.value.trim();

    if (message) {
      // Agregar mensaje del usuario al chat
      const userMessage = document.createElement('div');
      userMessage.textContent = `Tú: ${message}`;
      userMessage.style.fontWeight = 'bold';
      chatMessages.appendChild(userMessage);

      // Simular respuesta del entrenador
      setTimeout(() => {
        const trainerMessage = document.createElement('div');
        trainerMessage.textContent = `Entrenador: Gracias por tu mensaje. Te responderé pronto.`;
        chatMessages.appendChild(trainerMessage);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Desplazar hacia el final
      }, 1000);

      chatInput.value = ''; // Limpiar el campo de entrada
      chatMessages.scrollTop = chatMessages.scrollHeight; // Desplazar hacia el final
    }
  });

  document.querySelectorAll('.send-message-btn').forEach((button) => {
    button.addEventListener('click', function () {
      const chatContainer = this.closest('.chat-container');
      const chatInput = chatContainer.querySelector('.chat-input');
      const chatMessages = chatContainer.querySelector('.chat-messages');
      const message = chatInput.value.trim();

      if (message) {
        // Agregar mensaje del usuario al chat
        const userMessage = document.createElement('div');
        userMessage.textContent = `Tú: ${message}`;
        userMessage.style.fontWeight = 'bold';
        chatMessages.appendChild(userMessage);

        // Simular respuesta del entrenador
        setTimeout(() => {
          const trainerMessage = document.createElement('div');
          trainerMessage.textContent = `Entrenador: Gracias por tu mensaje. Te responderé pronto.`;
          chatMessages.appendChild(trainerMessage);
          chatMessages.scrollTop = chatMessages.scrollHeight; // Desplazar hacia el final
        }, 1000);

        chatInput.value = ''; // Limpiar el campo de entrada
        chatMessages.scrollTop = chatMessages.scrollHeight; // Desplazar hacia el final
      }
    });
  });
</script>

</body>
</html>
