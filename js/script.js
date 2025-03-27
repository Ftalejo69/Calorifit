document.addEventListener("DOMContentLoaded", function () {
  var modal = document.getElementById("profileModal");
  var openBtn = document.getElementById("openProfile");
  var closeBtn = document.getElementById("closeProfile");

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
});

document.addEventListener("DOMContentLoaded", function () {
  // Verificar si Font Awesome está cargado
  if (!document.querySelector('link[href*="font-awesome"]')) {
    console.warn("Font Awesome no está cargado. Asegúrate de incluirlo en tu HTML.");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Verificar si los íconos están presentes en la tabla
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