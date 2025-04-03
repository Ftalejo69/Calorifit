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
    <title>Planes de Entrenamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Agregar Font Awesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/ejercicios.css">
</head>
<body>

<?php include '../php/navbar.php'; ?>

<?php include '../php/modal_perfil.php'; ?>
  
<!-- Sección de bienvenida -->
<section class="welcome-section text-center">
  <h1>HISTORIAL <span>CALORIFIT</span></h1>
  <p>Transforma tu cuerpo y mente con nuestros planes exclusivos.</p>
  <button id="openProfile" class="btn btn-outline-light mt-3" onclick="location.href='#historial'">HISTORIAL</button>
</section>

<section class="history-section">
    <div class="history-header">
        <h2>Historial de Entrenamientos</h2>
        <form method="get" class="filter-form">
            <label for="tipo">Filtrar por tipo:</label>
            <select name="tipo" id="tipo">
                <option value="">Seleccionar tipo</option>
                <option value="Fuerza">Fuerza</option>
                <option value="Cardio">Cardio</option>
            </select>

            <label for="start_date">Desde:</label>
            <input type="date" name="start_date" id="start_date">

            <label for="end_date">Hasta:</label>
            <input type="date" name="end_date" id="end_date">

            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div id="historial"class="history-container">
        <!-- Aquí se generarán las tarjetas con los entrenamientos -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entrenamiento de Fuerza</h5>
                        <p class="card-text">Descripción del entrenamiento de fuerza, con enfoque en el desarrollo muscular.</p>
                        <p class="card-text">Duración: 60 minutos</p>
                        <p class="card-text">Series: 4 | Repeticiones: 10</p>
                        <p class="card-text">Fecha: 2025-03-25</p>
                        <a href="#" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entrenamiento de Cardio</h5>
                        <p class="card-text">Entrenamiento cardiovascular, ideal para mejorar la resistencia.</p>
                        <p class="card-text">Duración: 45 minutos</p>
                        <p class="card-text">Intensidad: Alta</p>
                        <p class="card-text">Fecha: 2025-03-26</p>
                        <a href="#" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entrenamiento de Fuerza</h5>
                        <p class="card-text">Entrenamiento para aumentar fuerza, enfocado en pesas.</p>
                        <p class="card-text">Duración: 50 minutos</p>
                        <p class="card-text">Series: 5 | Repeticiones: 8</p>
                        <p class="card-text">Fecha: 2025-03-27</p>
                        <a href="#" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entrenamiento Full Body</h5>
                        <p class="card-text">Entrenamiento que involucra todos los grupos musculares principales.</p>
                        <p class="card-text">Duración: 70 minutos</p>
                        <p class="card-text">Series: 3 | Repeticiones: 12</p>
                        <p class="card-text">Fecha: 2025-03-28</p>
                        <a href="#" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Entrenamiento de Cardio</h5>
                        <p class="card-text">Sesión de cardio para mejorar la capacidad cardiovascular.</p>
                        <p class="card-text">Duración: 40 minutos</p>
                        <p class="card-text">Intensidad: Moderada</p>
                        <p class="card-text">Fecha: 2025-03-29</p>
                        <a href="#" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../html/footer.php'; ?>


<script src="ejercicio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

