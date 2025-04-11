<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para ver su perfil.";
    exit;
}

$usuario = $_SESSION['usuario'];

// Obtener la lista de entrenadores desde la base de datos
include_once '../configuracion/conexion.php';
$query = "SELECT u.id, u.nombre, u.correo, u.telefono, u.imagen 
          FROM usuarios u 
          INNER JOIN usuarios_roles ur ON u.id = ur.usuario_id 
          INNER JOIN roles r ON ur.rol_id = r.id 
          WHERE r.nombre = 'entrenador'";
$result = $conexion->query($query);
$entrenadores = [];
while ($row = $result->fetch_assoc()) {
    $entrenadores[] = $row;
}
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

.testimonial-card {
  background: linear-gradient(145deg, #1e1e1e, #292929);
  border-radius: 20px;
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
  height: 100%;
}

.testimonial-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.6);
}

.testimonial-content {
  color: #fff;
  position: relative;
}

.testimonial-content i {
  color: #ffe600;
  font-size: 2rem;
  margin-bottom: 1rem;
  display: block;
}

.testimonial-content p {
  font-style: italic;
  margin-bottom: 1.5rem;
  font-size: 1rem;
  line-height: 1.6;
}

.testimonial-author {
  display: flex;
  align-items: center;
  margin-top: 1rem;
}

.testimonial-author img {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  margin-right: 1rem;
  border: 3px solid #ffe600;
}

.testimonial-author h5 {
  margin: 0;
  color: #ffe600;
  font-size: 1.1rem;
}

.testimonial-author small {
  color: #aaa;
  display: block;
  margin-top: 0.25rem;
}
  </style>
</head>
<body>

<?php include '../vistas/navbar.php'; ?>
<?php include '../vistas/modal_perfil.php'; ?>

<!-- Sección de bienvenida -->
<section class="welcome-section text-center">
  <h1>NOSOTROS <span>CALORIFIT</span></h1>
  <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
  <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#nosotros'">NOSOTROS</button>
</section>

<section class="container text-center my-5">
  <h2 class="section-title"><i class="fas fa-users"></i> Nuestros Entrenadores</h2>
  <p class="mt-3 text-light fs-5">"El éxito no es un accidente, es el resultado de la preparación, el trabajo duro y el aprendizaje constante."</p>
  
  <!-- Imagen principal con animación -->
  <div id="nosotros" class="row justify-content-center mb-5">
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
    <?php foreach ($entrenadores as $entrenador): ?>
    <div class="col-md-4 mb-4">
      <div class="trainer-card">
        <div class="trainer-card-inner">
          <!-- Parte frontal -->
          <div class="trainer-card-front">
            <img src="../publico/imagenes/<?php echo htmlspecialchars($entrenador['imagen']); ?>" 
                 alt="<?php echo htmlspecialchars($entrenador['nombre']); ?>" 
                 class="trainer-image">
            <h5 class="card-title"><?php echo htmlspecialchars($entrenador['nombre']); ?></h5>
            <p class="trainer-description">Entrenador profesional de Calorifit</p>
          </div>
          <!-- Parte trasera -->
          <div class="trainer-card-back">
            <h5><?php echo htmlspecialchars($entrenador['nombre']); ?></h5>
            <p>Entrenador certificado con experiencia en fitness y nutrición.</p>
            <button class="btn btn-primary" onclick="contactarEntrenador('<?php echo htmlspecialchars($entrenador['nombre']); ?>', '<?php echo htmlspecialchars($entrenador['telefono']); ?>', '<?php echo htmlspecialchars($entrenador['correo']); ?>')">Contactar</button>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Sección de Misión y Visión -->
<section class="container my-5">
  <div class="row">
    <div class="col-md-6 mb-4">
      <div class="mission-vision-card">
        <h3><i class="fas fa-bullseye"></i> Nuestra Misión</h3>
        <p>En Calorifit, nuestra misión es transformar vidas a través del fitness y la salud, proporcionando un ambiente motivador y profesional donde cada persona pueda alcanzar sus objetivos físicos y mentales. Nos comprometemos a brindar asesoramiento personalizado y apoyo continuo para que nuestros miembros logren resultados duraderos.</p>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="mission-vision-card">
        <h3><i class="fas fa-eye"></i> Nuestra Visión</h3>
        <p>Ser reconocidos como el centro líder en transformación física y bienestar integral, inspirando a las personas a adoptar un estilo de vida saludable y activo. Aspiramos a crear una comunidad fuerte y unida donde cada miembro se sienta apoyado en su viaje hacia una mejor versión de sí mismo.</p>
      </div>
    </div>
  </div>
</section>

<!-- Sección de Testimonios -->
<section class="container my-5">
  <h2 class="section-title mb-4">Testimonios</h2>
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="testimonial-card">
        <div class="testimonial-content">
          <i class="fas fa-quote-left"></i>
          <p>"Calorifit cambió mi vida por completo. Gracias a sus entrenadores profesionales y planes personalizados, logré mis objetivos de pérdida de peso y me siento mejor que nunca."</p>
          <div class="testimonial-author">
            <img src="../publico/imagenes/imagenmiujer.jpg" alt="María García">
            <div>
              <h5>María García</h5>
              <small>Miembro desde 2023</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="testimonial-card">
        <div class="testimonial-content">
          <i class="fas fa-quote-left"></i>
          <p>"Los entrenadores son excepcionales. Su dedicación y conocimiento me ayudaron a superar mis límites y alcanzar un nivel de fitness que nunca pensé posible."</p>
          <div class="testimonial-author">
            <img src="../publico/imagenes/David-Laid.jpg" alt="Carlos Rodríguez">
            <div>
              <h5>Carlos Rodríguez</h5>
              <small>Miembro desde 2022</small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="testimonial-card">
        <div class="testimonial-content">
          <i class="fas fa-quote-left"></i>
          <p>"El ambiente en Calorifit es increíble. La comunidad te motiva a dar lo mejor de ti mismo, y los resultados hablan por sí solos. ¡Totalmente recomendado!"</p>
          <div class="testimonial-author">
            <img src="../publico/imagenes/arnold.jpg" alt="Juan Martínez">
            <div>
              <h5>Juan Martínez</h5>
              <small>Miembro desde 2024</small>
            </div>
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

<?php include '../vistas/footer.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para contactar entrenador actualizada
    window.contactarEntrenador = function(nombre, telefono, correo) {
        document.getElementById('trainerName').textContent = nombre;
        document.getElementById('trainerPhone').textContent = telefono;
        document.getElementById('trainerEmail').textContent = correo;
        const contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
        contactModal.show();
    }

    // Resto del código JavaScript para el chat
    document.getElementById('sendMessageButton').addEventListener('click', function () {
        const chatInput = document.getElementById('chatInput');
        const chatMessages = document.getElementById('chatMessages');
        const message = chatInput.value.trim();

        if (message) {
            const userMessage = document.createElement('div');
            userMessage.textContent = `Tú: ${message}`;
            userMessage.style.fontWeight = 'bold';
            chatMessages.appendChild(userMessage);

            setTimeout(() => {
                const trainerMessage = document.createElement('div');
                trainerMessage.textContent = `Entrenador: Gracias por tu mensaje. Te responderé pronto.`;
                chatMessages.appendChild(trainerMessage);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);

            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
});
</script>

</body>
</html>
