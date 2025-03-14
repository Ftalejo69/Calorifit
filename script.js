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