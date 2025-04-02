document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM cargado correctamente."); // Debug

  // Manejo de panel de información de planes
  function togglePanel(plan) {
    var panel = document.getElementById("infoPanel");
    var title = document.getElementById("panelTitle");
    var description = document.getElementById("panelDescription");

    if (plan) {
      title.innerText = plan + " - Detalles";
      description.innerText = "Este plan está diseñado para mejorar tu " + plan.toLowerCase() + ".";
      panel.classList.remove("d-none");
      panel.classList.add("fade-in");
    } else {
      panel.classList.remove("fade-in");
      panel.classList.add("fade-out");
      setTimeout(() => {
        panel.classList.add("d-none");
        panel.classList.remove("fade-out");
        title.innerText = "";
      }, 300);
    }
  }

  document.querySelectorAll(".btn-warning").forEach(button => {
    button.addEventListener("click", function () {
      let plan = this.closest(".card-body").querySelector(".card-title").innerText;
      togglePanel(plan);
    });
  });

  // 📌 Manejo del modal con Bootstrap
  const btnPerfil = document.getElementById("btnPerfil");
  const modalElement = document.getElementById("modalPerfil");

  if (btnPerfil && modalElement) {
    btnPerfil.setAttribute("data-bs-toggle", "modal");
    btnPerfil.setAttribute("data-bs-target", "#modalPerfil");
  }

  // Desplazamiento suave para los enlaces de la barra de navegación
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });
});
