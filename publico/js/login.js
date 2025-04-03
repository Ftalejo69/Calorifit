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

    fetch("../modelos/registro.php", { method: "POST", body: formData })
      .then(response => {
        if (!response.ok) throw new Error("Error en la conexión con el servidor.");
        return response.text();
      })
      .then(data => {
        alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
        alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
        alertDiv.textContent = data.trim(); // Asegúrate de eliminar espacios en blanco

        if (data.includes("exitoso")) {
          clearForm(form, alertDiv);
          setTimeout(() => {
            // Cambiar a la pestaña de inicio de sesión
            new bootstrap.Tab(document.getElementById("login-tab")).show();
          }, 2000);
        }
      })
      .catch(error => {
        alertDiv.classList.remove("d-none", "alert-success");
        alertDiv.classList.add("alert-danger");
        alertDiv.textContent = error.message;
      });
  });

  document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    var alertDiv = document.getElementById("loginAlert");

    fetch("../modelos/login.php", { method: "POST", body: formData }) // Cambiado a login.php
      .then(response => {
        if (!response.ok) throw new Error("Error en la conexión con el servidor.");
        return response.text();
      })
      .then(data => {
        alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
        alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
        alertDiv.textContent = data.trim(); // Asegúrate de eliminar espacios en blanco

        if (data.includes("exitoso")) {
          clearForm(form, alertDiv);
          setTimeout(() => window.location.href = "inicio.php", 1000);
        }
      })
      .catch(error => {
        alertDiv.classList.remove("d-none", "alert-success");
        alertDiv.classList.add("alert-danger");
        alertDiv.textContent = error.message;
      });
  });
});