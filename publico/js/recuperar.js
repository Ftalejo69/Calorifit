document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("recuperarForm");
    const alertDiv = document.getElementById("recuperarAlert");

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch("../modelos/recuperar.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alertDiv.classList.remove("d-none", "alert-danger", "alert-success");
            alertDiv.classList.add(data.includes("exitoso") ? "alert-success" : "alert-danger");
            alertDiv.textContent = data.trim();
        })
        .catch(error => {
            alertDiv.classList.remove("d-none", "alert-success");
            alertDiv.classList.add("alert-danger");
            alertDiv.textContent = "Error al procesar la solicitud";
        });
    });
});
