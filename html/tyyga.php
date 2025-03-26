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
    <title>Rutina de Gym</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
      <!-- Agregar Font Awesome para los iconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/tyyga.css">
    <script defer src="../js/tyyga.js"></script>
</head>
<body>
    <header>
        <h1>Rutina de Gym</h1>
    </header>
    <?php include '../php/navbar.php'; ?>
    <?php include '../php/modal_perfil.php'; ?>
  
    <!-- Contenedor para agregar nuevas tareas -->
    <div class="add-task-container">
        <label for="taskInput" class="visually-hidden">Añadir ejercicio</label>
        <input type="text" id="taskInput" placeholder="Añadir ejercicio...">
        <button id="addTaskBtn">Agregar</button>
    </div>
    
    <!-- Contenedor para limpiar todas las tareas -->
    <div class="clear-tasks-container">
        <button id="clearTasksBtn">Limpiar todas las tareas</button>
    </div>

    <!-- Contador total de tareas -->
    <div id="totalTaskCounter" class="total-task-counter">Total de tareas: 0</div>
    
    <!-- Contenedor principal de columnas -->
    <div class="columns">
        <!-- Columna para Lunes -->
        <div class="column" id="lunes">
            <h4>🏋️ Lunes - Pecho y Tríceps</h4>
            <ul class="task-list">
                <li class="task" id="task1" draggable="true">Press de banca</li>
                <li class="task" id="task2" draggable="true">Fondos</li>
                <li class="task" id="task3" draggable="true">Aperturas</li>
            </ul>
        </div>
        <!-- Columna para Martes -->
        <div class="column" id="martes">
            <h4>🏋️ Martes - Espalda y Bíceps</h4>
            <ul class="task-list">
                <li class="task" id="task4" draggable="true">Dominadas</li>
                <li class="task" id="task5" draggable="true">Remo con barra</li>
                <li class="task" id="task6" draggable="true">Curl de bíceps</li>
            </ul>
        </div>
        <!-- Columna para Miércoles -->
        <div class="column" id="miercoles">
            <h4>🏃 Miércoles - Piernas</h4>
            <ul class="task-list">
                <li class="task" id="task7" draggable="true">Sentadillas</li>
                <li class="task" id="task8" draggable="true">Prensa</li>
                <li class="task" id="task9" draggable="true">Peso muerto</li>
            </ul>
        </div>
        <!-- Columna para Jueves -->
        <div class="column" id="jueves">
            <h4>💪 Jueves - Hombros y Abdomen</h4>
            <ul class="task-list">
                <li class="task" id="task10" draggable="true">Press militar</li>
                <li class="task" id="task11" draggable="true">Elevaciones laterales</li>
                <li class="task" id="task12" draggable="true">Plancha</li>
            </ul>
        </div>
        <!-- Columna para Viernes -->
        <div class="column" id="viernes">
            <h4>⚡ Viernes - Cardio y Full Body</h4>
            <ul class="task-list">
                <li class="task" id="task13" draggable="true">HIIT</li>
                <li class="task" id="task14" draggable="true">Burpees</li>
                <li class="task" id="task15" draggable="true">Battle ropes</li>
            </ul>
        </div>
    </div>

    <!-- Modal para confirmar eliminación -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <p>¿Estás seguro de que deseas eliminar esta tarea?</p>
            <button id="confirmDelete" class="confirm">Eliminar</button>
            <button id="cancelDelete" class="cancel">Cancelar</button>
        </div>
    </div>

    <footer>
        <p>&copy; Calorifit. Todos los derechos reservados.</p>
    </footer>
</body>
</html>