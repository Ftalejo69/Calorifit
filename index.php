<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CaloriFit - Registro e Inicio de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-custom { 
      width: 25rem; 
      background-color: black; /* Cambiado a negro */
      color: white; /* Color del texto blanco para contraste */
    }
    .title { 
      font-size: 2rem; 
      font-weight: bold; 
      text-align: center; 
    }
    .title span { 
      color: white; 
    }
    .title span.fit { 
      color: orange; 
      animation: pulse 1.5s infinite; 
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }

    /* Estilo para los inputs resaltados en amarillo */
    .form-control:focus {
      border-color: yellow;
      box-shadow: 0 0 0 0.2rem rgba(226, 226, 34, 0.25); /* Resalta el borde y el sombreado */
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-warning">
  
  <div class="card card-custom p-4 shadow">
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
        <form id="registerForm">
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
        <form id="loginForm">
          <input type="hidden" name="action" value="login">
          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="contraseña" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <div id="loginAlert" class="alert mt-3 d-none"></div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var loginTab = document.getElementById("login-tab");
      var registerTab = document.getElementById("register-tab");
      if (window.location.hash === "#login") new bootstrap.Tab(loginTab).show();

      document.getElementById("registerForm").addEventListener("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch("registro.php", { method: "POST", body: formData })
          .then(response => response.text())
          .then(data => {
            var alertDiv = document.getElementById("registerAlert");
            alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
            alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
            alertDiv.textContent = data;
          });
      });

      document.getElementById("loginForm").addEventListener("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch("registro.php", { method: "POST", body: formData })
          .then(response => response.text())
          .then(data => {
            var alertDiv = document.getElementById("loginAlert");
            alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
            alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
            alertDiv.textContent = data;
            if (data.includes("exitoso")) setTimeout(() => window.location.href = "index.html", 2000);
          });
      });
    });
  </script>
</body>
</html>
