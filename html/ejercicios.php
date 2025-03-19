<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes de Entrenamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styleEjerci.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../html/inicio.php">
                <span class="calori">Calori</span><span class="fit">Fit</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../html/planes.php">Planes</a></li>
                    <li class="nav-item"><a class="nav-link" href="../html/rutinas.php">Rutinas</a></li>
                    <li class="nav-item"><a class="nav-link" href="../html/ejercicios.php">Ejercicio</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="index.php">Cerrar sesión</a></li>
                    <li class="nav-item"><a href="#" id="openProfile" class="btn btn-dark">Ver Perfil</a></li>
                </ul>
            </div>
        </div>
    </nav>

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
