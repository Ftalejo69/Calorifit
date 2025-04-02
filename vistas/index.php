<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CaloriFit - Registro e Inicio de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
.card-custom { 
  width: 25rem; 
  background-color: #2c2c2c; /* Un gris oscuro en lugar de negro para suavizar el contraste */
  color: #ffffff; /* Color del texto blanco para contraste */
  border-radius: 12px; /* Bordes redondeados para un aspecto más moderno */
  padding: 2rem; /* Espaciado interno generoso */
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Sombra para dar profundidad */
  transition: transform 0.3s, box-shadow 0.3s; /* Transiciones suaves para efectos */
}

.card-custom:hover {
  transform: translateY(-5px); /* Efecto de elevación al pasar el ratón */
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6); /* Sombra más pronunciada al pasar el ratón */
}

.title { 
  font-size: 2.5rem; /* Tamaño de fuente más grande para el título */
  font-weight: bold; 
  text-align: center; 
  margin-bottom: 1rem; /* Espacio debajo del título */
  text-transform: uppercase; /* Texto en mayúsculas para un efecto más impactante */
  letter-spacing: 1px; /* Espaciado entre letras para mayor legibilidad */
}

.title span { 
  color: #ffffff; /* Color blanco para el texto normal */
}

.title span.fit { 
  color: #ffcc00; /* Color dorado para el texto destacado */
  animation: pulse 1.5s infinite; /* Animación de pulso */
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

.form-control { 
  background-color: #3a3a3a; /* Fondo oscuro para los campos de entrada */
  color: #ffffff; /* Texto claro en los campos de entrada */
  border: 1px solid #444; /* Borde gris oscuro */
  border-radius: 5px; /* Bordes redondeados en los campos de entrada */
  padding: 0.75rem; /* Espaciado interno en los campos de entrada */
  transition: border-color 0.3s, box-shadow 0.3s; /* Transiciones suaves para el borde */
}

.form-control:focus {
  border-color: #ffcc00; /* Color dorado al enfocar */
  box-shadow: 0 0 0 0.2rem rgba(255, 204, 0, 0.25); /* Sombreado dorado al enfocar */
  outline: none; /* Elimina el contorno predeterminado */
}
    .login-card {
      animation: pulse-login 2s infinite; /* Hace el movimiento de palpitar */
    }

    @keyframes pulse-login {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .login-card:hover {
      animation: none;
    }
  </style>
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

      function clearForm(form, alertDiv) {
        form.reset(); 
        setTimeout(() => {
          alertDiv.classList.add("d-none");
          alertDiv.textContent = "";
        }, 2000);
      }

      document.getElementById("registerForm").addEventListener("submit", function (e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var alertDiv = document.getElementById("registerAlert");

        fetch("registro.php", { method: "POST", body: formData })
          .then(response => response.text())
          .then(data => {
            alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
            alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
            alertDiv.textContent = data;

            if (data.includes("exitoso")) {
              clearForm(form, alertDiv);
            }
          });
      });

      document.getElementById("loginForm").addEventListener("submit", function (e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);
        var alertDiv = document.getElementById("loginAlert");

        fetch("registro.php", { method: "POST", body: formData })
          .then(response => response.text())
          .then(data => {
            alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
            alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
            alertDiv.textContent = data;

            if (data.includes("exitoso")) {
              clearForm(form, alertDiv);
              setTimeout(() => window.location.href = "../vista/inicio.php", 1000);
            }
          });
      });
    });
  </script>

</body>
</html>
