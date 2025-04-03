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

    fetch("../modelos/registro.php", { method: "POST", body: formData })
      .then(response => response.text())
      .then(data => {
        alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
        alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
        alertDiv.textContent = data;

        if (data.includes("exitoso")) {
          clearForm(form, alertDiv);
          setTimeout(() => window.location.href = "inicio.php", 1000);
        }
      });
  });
});
