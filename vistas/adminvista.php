<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['roles']) || !in_array('admin', array_column($_SESSION['usuario']['roles'], 'nombre'))) {
    header('Location: inicio.php');
    exit;
}
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Calorifit</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/adminvista.css">
    <script src="/Calorifit/publico/js/adminvista.js" defer></script>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2><i class="bx bxs-layer"></i> Calorifit</h2>
        </div>
        <ul class="menu">
            <li><a href="#dashboard" class="menu-link"><i class="bx bxs-dashboard"></i> Dashboard</a></li>
            <li><a href="#perfil" class="menu-link"><i class="bx bxs-user"></i> Perfil</a></li>
            <li><a href="#planes" class="menu-link"><i class="bx bxs-book"></i> Planes</a></li>
            <li><a href="#entrenadores" class="menu-link"><i class="bx bx-dumbbell"></i> Entrenadores</a></li>
            <li><a href="#usuarios" class="menu-link"><i class="bx bxs-group"></i> Usuarios</a></li>
            <li><a href="#settings" class="menu-link"><i class="bx bxs-cog"></i> Settings</a></li>
        </ul>
        <div class="logout">
            <a href="../controladores/cerrar_sesion.php"><i class="bx bxs-log-out"></i> Cerrar Sesión</a>
        </div>
    </aside>
    <div class="main-content">
        <div class="header">
            <div class="welcome">
                <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h1>
                <p>¡Es bueno verte de nuevo!</p>
            </div>
            <div class="user-info" id="user-info">
                <div class="user-details">
                    <h2><?php echo htmlspecialchars($usuario['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($usuario['correo']); ?></p>
                </div>
                <div class="user-menu" id="user-menu">
                    <a href="#" id="ver-perfil">Ver Perfil</a>
                    <a href="../vistas/index.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>

        <!-- Modal de Perfil -->
        <div id="profile-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Mi Perfil</h2>
                <form id="profile-form">
                    <div class="form-group">
                        <label for="profile-name">Nombre:</label>
                        <input type="text" id="profile-name" name="profile-name" 
                               placeholder="Nombre del usuario" 
                               value="<?php echo htmlspecialchars($usuario['nombre']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="profile-email">Correo:</label>
                        <input type="email" id="profile-email" name="profile-email" 
                               placeholder="Correo electrónico"
                               value="<?php echo htmlspecialchars($usuario['correo']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="profile-phone">Teléfono:</label>
                        <input type="tel" id="profile-phone" name="profile-phone" 
                               placeholder="Número de teléfono"
                               value="<?php echo htmlspecialchars($usuario['telefono']); ?>" readonly>
                    </div>
                    <div class="form-buttons">
                        <button type="button" id="edit-profile" class="btn-edit">Editar</button>
                        <button type="submit" id="save-profile" class="btn-submit" style="display: none;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="stats-cards">
            <div class="card green">
                <div class="card-icon"><i class="bx bxs-user"></i></div>
                <div class="card-title">Fans Data</div>
                <div class="card-value">2387 ↑</div>
            </div>
            <div class="card blue">
                <div class="card-icon"><i class="bx bxs-wallet"></i></div>
                <div class="card-title">Income</div>
                <div class="card-value">$3920 ↑</div>
            </div>
            <div class="card pink">
                <div class="card-icon"><i class="bx bxs-briefcase"></i></div>
                <div class="card-title">Works</div>
                <div class="card-value">12 ↑</div>
            </div>
            <div class="card orange">
                <div class="card-icon"><i class="bx bxs-message"></i></div>
                <div class="card-title">Messages</div>
                <div class="card-value">893 ↑</div>
            </div>
        </div>
        
        <!-- Sección de Dashboard -->
        <section id="dashboard" class="content-section">
            <!-- Contenido del dashboard -->
        </section>

        <!-- Sección de Planes/Membresías -->
        <section id="planes" class="content-section">
            <h2>Gestión de Planes</h2>
            <button class="add-button" id="add-plan-btn">
                <i class="bx bx-plus"></i> Agregar Plan
            </button>
            <div class="table-container">
                <table id="plans-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Duración</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los planes se cargarán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Sección de Entrenadores -->
        <section id="entrenadores" class="content-section">
            <h2>Gestión de Entrenadores</h2>
            <button class="add-button" id="add-trainer-btn">
                <i class="bx bx-plus"></i> Agregar Entrenador
            </button>
            <div class="table-container">
                <table id="trainers-table" class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los entrenadores se cargarán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Modal para Agregar Entrenador -->
        <div id="add-trainer-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Agregar Nuevo Entrenador</h2>
                <form id="add-trainer-form">
                    <div class="form-group">
                        <label for="new-trainer-name">Nombre:</label>
                        <input type="text" id="new-trainer-name" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="new-trainer-email">Correo:</label>
                        <input type="email" id="new-trainer-email" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="new-trainer-phone">Teléfono:</label>
                        <input type="tel" id="new-trainer-phone" name="telefono" required>
                    </div>
                    <button type="submit" class="btn-submit">Agregar Entrenador</button>
                </form>
            </div>
        </div>

        <!-- Modal para Editar Entrenador -->
        <div id="edit-trainer-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Editar Entrenador</h2>
                <form id="trainer-form">
                    <input type="hidden" id="trainer-id" name="id">
                    <div class="form-group">
                        <label for="trainer-name">Nombre:</label>
                        <input type="text" id="trainer-name" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="trainer-email">Correo:</label>
                        <input type="email" id="trainer-email" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="trainer-phone">Teléfono:</label>
                        <input type="tel" id="trainer-phone" name="telefono" required>
                    </div>
                    <button type="submit" class="btn-submit">Guardar Cambios</button>
                </form>
            </div>
        </div>

        <!-- Sección de Usuarios -->
        <section id="usuarios" class="content-section">
            <h2>Gestión de Usuarios</h2>
            <div class="table-container">
                <table id="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Fecha Registro</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los usuarios se cargarán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
