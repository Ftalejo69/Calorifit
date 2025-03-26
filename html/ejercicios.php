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


  <div class="container1">
    <h1>Creación de Planes de Entrenamiento</h1>
    <form id="plan-form">
        <label for="tipo-entrenamiento">Tipo de Entrenamiento:</label>
        <select id="tipo-entrenamiento">
            <option value="fuerza">Fuerza</option>
            <option value="resistencia">Resistencia</option>
            <option value="flexibilidad">Flexibilidad</option>
        </select>
        <button type="button" id="agregar-ejercicio">Agregar Ejercicio</button>
    </form>
    
    <div id="lista-ejercicios"></div>
    <button id="guardar-plan">Guardar Plan</button>
    <h2>Mis Planes</h2>
    <div id="planes-guardados"></div>
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
    
    <script src="ejercicio.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
