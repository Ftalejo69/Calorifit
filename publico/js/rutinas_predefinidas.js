document.getElementById("categoria").addEventListener("change", function() {
    let categoria = this.value;
    fetch("rutinas.php?categoria=" + categoria)
        .then(response => response.json())
        .then(data => {
            let rutinasDiv = document.getElementById("rutinas");
            rutinasDiv.innerHTML = "";
            data.forEach(rutina => {
                let rutinaItem = document.createElement("div");
                rutinaItem.classList.add("rutina");
                rutinaItem.innerHTML = `
                    <h2>${rutina.nombre}</h2>
                    <p>${rutina.descripcion}</p>
                    <p><strong>Duración:</strong> ${rutina.duracion} minutos</p>
                    <button onclick="marcarFavorito('${rutina.id}')">⭐ Marcar como Favorita</button>
                `;
                rutinasDiv.appendChild(rutinaItem);
            });
        });
});

function marcarFavorito(id) {
    fetch("favorito.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id
    }).then(() => alert("Rutina marcada como favorita"));
}