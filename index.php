<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CaloriFit - Registro e Inicio de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilo general de la página */
    body {
      background-color: #f4f4f4; /* Fondo gris claro */
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Estilo de la tarjeta */
    .card-custom { 
      width: 400px; 
      background-color: #2c2c2c; /* Fondo oscuro */
      color: white; 
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      margin: 0 auto;
    }

    /* Título de la página */
    .title { 
      font-size: 2rem; 
      font-weight: 600; 
      text-align: center; 
      margin-bottom: 1rem;
      color: white;
    }

    .title span { 
      color: #FFD700; /* Dorado */
    }

    /* Estilo de los campos de entrada */
    .form-control {
      background-color: #444444;
      border: 1px solid #555555;
      color: #ddd;
      border-radius: 8px;
      padding: 0.75rem;
    }

    /* Efecto cuando el campo de entrada está en foco */
    .form-control:focus {
      border-color: #FFD700; /* Dorado */
      box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    }

    /* Estilo del botón */
    .btn-warning {
      background-color: #FFD700; /* Dorado */
      border-color: #FFD700;
      color: black;
      font-weight: bold;
      padding: 0.75rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .btn-warning:hover {
      background-color: #e6c200; /* Dorado oscuro */
      border-color: #e6c200;
      color: white;
    }

    /* Estilo para los enlaces */
    .text-warning {
      color: #FFD700 !important;
      font-weight: 600;
      text-decoration: none;
    }

    /* Estilo para las alertas */
    .alert {
      border-radius: 8px;
      font-weight: 600;
      padding: 1rem;
    }

    .alert-success {
      background-color: #28a745;
      color: white;
    }

    .alert-danger {
      background-color: #dc3545;
      color: white;
    }

    /* Asegurar que el cursor de texto (caret) sea visible solo en los inputs */
    input, textarea, select, .form-control {
      caret-color: #FFD700; /* Cursor dorado en los campos de formulario */
    }

    /* Evitar que el cursor se muestre en otros elementos */
    body, div, p, span, a, button {
      caret-color: transparent;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
  
  <div class="card card-custom shadow login-card">
    <h1 class="title"><span>Calori</span><span>Fit</span></h1>
    
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
          <button type="submit" class="btn btn-warning w-100">Entrar</button>
        </form>
        
        <!-- Enlace para olvidar la contraseña -->
        <div class="text-center mt-3">
          <a href="javascript:void(0);" id="forgotPasswordLink" class="text-warning">¿Olvidaste tu contraseña?</a>
        </div>

        <!-- Formulario de Recuperación de Contraseña (Oculto por defecto) -->
        <div id="forgotPasswordForm" style="display: none;">
          <form id="forgotPasswordSubmitForm">
            <div class="mb-3">
              <label class="form-label">Correo</label>
              <input type="email" class="form-control" name="correo" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Recuperar Contraseña</button>
          </form>
          <div id="forgotPasswordAlert" class="alert mt-3 d-none"></div>
          <div class="text-center mt-3">
            <a href="javascript:void(0);" id="backToLoginLink" class="text-warning">Volver al inicio de sesión</a>
          </div>
        </div>

        <div id="loginAlert" class="alert mt-3 d-none"></div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    var loginTab = document.getElementById("login-tab");
    var registerTab = document.getElementById("register-tab");
    var loginAlert = document.getElementById("loginAlert");
    var forgotPasswordForm = document.getElementById("forgotPasswordForm");
    var loginForm = document.getElementById("loginForm");
    var forgotPasswordLink = document.getElementById('forgotPasswordLink');
    var backToLoginLink = document.getElementById('backToLoginLink');

    // Si la URL contiene el hash "#login", muestra la pestaña de login
    if (window.location.hash === "#login") new bootstrap.Tab(loginTab).show();

    // Cambiar al formulario de recuperación de contraseña
    forgotPasswordLink.addEventListener('click', function () {
      loginForm.style.display = 'none';
      loginAlert.classList.add('d-none'); 
      forgotPasswordForm.style.display = 'block';
      forgotPasswordLink.style.display = 'none';
    });

    // Volver al formulario de inicio de sesión
    backToLoginLink.addEventListener('click', function () {
      forgotPasswordForm.style.display = 'none';
      loginForm.style.display = 'block';
      forgotPasswordLink.style.display = 'block';
    });

    // Manejo del formulario de registro
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
          clearForm(document.getElementById("registerForm"));
        });
    });

    // Manejo del formulario de inicio de sesión
    document.getElementById("loginForm").addEventListener("submit", function (e) {
      e.preventDefault();
      var formData = new FormData(this);
      fetch("registro.php", { method: "POST", body: formData })
        .then(response => response.text())
        .then(data => {
          loginAlert.classList.remove("d-none", "alert-danger", "alert-success");
          loginAlert.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
          loginAlert.textContent = data;

          if (data.includes("exitoso")) {
            setTimeout(() => window.location.href = "menu.php", 2000);
          }

          clearForm(document.getElementById("loginForm"));
        });
    });

    document.getElementById("forgotPasswordSubmitForm").addEventListener("submit", function (e) {
      e.preventDefault();
      alert("Recuperación de contraseña solicitada");
      clearForm(document.getElementById("forgotPasswordSubmitForm"));
    });

    function clearForm(form) {
      var inputs = form.querySelectorAll('input');
      inputs.forEach(input => {
        input.value = '';
      });
    }

    function disableAutocomplete(form) {
      form.setAttribute('autocomplete', 'off');
    }

    disableAutocomplete(document.getElementById("registerForm"));
    disableAutocomplete(document.getElementById("loginForm"));
    disableAutocomplete(document.getElementById("forgotPasswordSubmitForm"));
  });
  </script>
</body>
</html>