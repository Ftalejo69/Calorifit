<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CaloriFit - Registro e Inicio de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../publico/css/login.css" rel="stylesheet"> <!-- Archivo CSS externo -->
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-warning">
  
  <div class="card card-custom p-4 shadow login-card">
    <h1 class="title"><span>Calori</span><span class="fit">Fit</span></h1>
    
    <ul class="nav nav-tabs mb-3" id="authTab">
      <li class="nav-item">
        <button class="nav-link active" id="register-tab" data-bs-toggle="tab" data-bs-target="#register">Registrarse</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login">Iniciar Sesión</button>
      </li>
    </ul>

    <div class="tab-content">
      <!-- Formulario de Registro -->
      <div class="tab-pane fade show active" id="register">
        <form id="registerForm" action="../modelos/registro.php" method="POST">
          <input type="hidden" name="action" value="register">
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="telefono" required pattern="[0-9]+">
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="contraseña" required>
          </div>
          <button type="submit" class="btn btn-warning w-100">Registrarse</button>
        </form>
        <div id="registerAlert" class="alert mt-3 d-none"></div>
      </div>

      <!-- Formulario de Inicio de Sesión -->
      <div class="tab-pane fade" id="login">
        <form id="loginForm" action="../modelos/login.php" method="POST">
          <input type="hidden" name="action" value="login">
          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="contraseña" required>
          </div>
          <button type="submit" class="btn btn-warning w-100">Entrar</button>
        </form>
        <div id="loginAlert" class="alert mt-3 d-none"></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script src="../publico/js/login.js"></script>

</body>
</html>
