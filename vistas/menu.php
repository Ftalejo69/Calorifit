<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../publico/css/menu.css">
    <link rel="stylesheet" href="../publico/css/modal.css">
    <script src="../public/js/menu.js" defer></script> <!-- Incluir el archivo JavaScript -->
    <script src="../public/js/modal.js" defer></script>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2><i class="bx bxs-layer"></i> Calorifit</h2>
        </div>
        <ul class="menu">
            <li><a href="#" class="active"><i class="bx bxs-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="bx bxs-user"></i> Perfil</a></li>
            <li><a href="#"><i class="bx bxs-book"></i>Planes</a></li>
            <li><a href="#"><i class="bx bx-dumbbell"></i> Entrenadores</a></li>
            <li><a href="#"><i class="bx bxs-group"></i>Usuarios</a></li>
            <li><a href="#"><i class="bx bxs-help-circle"></i> Help Center</a></li>
            <li><a href="#"><i class="bx bxs-cog"></i> Settings</a></li>
        </ul>
        <div class="logout">
            <a href="#"><i class="bx bxs-log-out"></i> Logout</a>
        </div>
    </aside>
    <div class="main-content">
        <div class="header">
            <div class="welcome">
                <h1>Günaydın, Jon</h1>
                <p>Welcome back, nice to see you again!</p>
            </div>
            <div class="user-info" id="user-info">
                <img src="https://via.placeholder.com/50" alt="User Avatar">
                <div class="user-details">
                    <h2>Jon Pantau</h2>
                    <p>Turkish Daily</p>
                </div>
                <!-- Mini menú desplegable -->
                <div class="user-menu" id="user-menu">
                    <a href="#" id="view-profile">Ver Perfil</a>
                    <a href="#">Cerrar Sesión</a>
                </div>
                <!-- Modal for User Profile -->
                <div id="profile-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-modal" id="close-modal">&times;</span>
                        <h2>Perfil de Usuario</h2>
                        <form id="profile-form">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" name="name" value="Jon Pantau">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" value="jon.pantau@example.com">
                            <label for="role">Rol:</label>
                            <input type="text" id="role" name="role" value="Turkish Daily">
                            <div class="modal-buttons">
                                <button type="button" id="edit-button">Editar</button>
                                <button type="submit" id="save-button" disabled>Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
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
    </div>
</body>
</html>
