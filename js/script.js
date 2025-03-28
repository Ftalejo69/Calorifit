document.addEventListener("DOMContentLoaded", function () {
  // Modal de perfil
  const modal = document.getElementById("profileModal");
  const openBtn = document.getElementById("openProfile");
  const closeBtn = document.getElementById("closeProfile");

  if (modal && openBtn && closeBtn) {
    openBtn.addEventListener("click", function (event) {
      event.preventDefault();
      modal.style.display = "flex";
    });

    closeBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  }

  // Verificar si Font Awesome está cargado
  if (!document.querySelector('link[href*="font-awesome"]')) {
    console.warn("Font Awesome no está cargado. Asegúrate de incluirlo en tu HTML.");
  }

  // Verificar íconos en la tabla
  const checkIcons = document.querySelectorAll(".fa-check-circle");
  const timesIcons = document.querySelectorAll(".fa-times-circle");

  if (checkIcons.length > 0 && timesIcons.length > 0) {
    console.log("Los íconos de check y X están presentes y deberían reflejar los estilos.");
    checkIcons.forEach(icon => console.log("Check icon color:", getComputedStyle(icon).color));
    timesIcons.forEach(icon => console.log("Times icon color:", getComputedStyle(icon).color));
  } else {
    console.warn("No se encontraron íconos de check o X en la tabla.");
  }
});