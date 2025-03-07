document.getElementById("agregar-ejercicio").addEventListener("click", agregarEjercicio);
document.getElementById("guardar-plan").addEventListener("click", guardarPlan);

function agregarEjercicio() {
    const listaEjercicios = document.getElementById("lista-ejercicios");
    const ejercicioDiv = document.createElement("div");
    ejercicioDiv.classList.add("ejercicio");
    ejercicioDiv.innerHTML = `
        <input type="text" placeholder="Nombre del ejercicio" required>
        <input type="number" placeholder="Series" required>
        <input type="number" placeholder="Repeticiones" required>
        <input type="number" placeholder="Descanso (segundos)" required>
        <button type="button" onclick="this.parentElement.remove()">Eliminar</button>
    `;
    listaEjercicios.appendChild(ejercicioDiv);
}

function guardarPlan() {
    const tipoEntrenamiento = document.getElementById("tipo-entrenamiento").value;
    const listaEjercicios = document.querySelectorAll("#lista-ejercicios .ejercicio");
    if (listaEjercicios.length === 0) {
        alert("Agrega al menos un ejercicio.");
        return;
    }
    let ejercicios = [];
    listaEjercicios.forEach(ejercicio => {
        let inputs = ejercicio.getElementsByTagName("input");
        ejercicios.push({
            nombre: inputs[0].value,
            series: parseInt(inputs[1].value),
            repeticiones: parseInt(inputs[2].value),
            descanso: parseInt(inputs[3].value)
        });
    });
    fetch("guardar_plan.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ tipo: tipoEntrenamiento, ejercicios })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        cargarPlanes();
    })
    .catch(error => console.error("Error:", error));
}

function cargarPlanes() {
    fetch("obtener_planes.php")
    .then(response => response.json())
    .then(planes => {
        const contenedor = document.getElementById("planes-guardados");
        contenedor.innerHTML = "";
        planes.forEach(plan => {
            let div = document.createElement("div");
            div.classList.add("plan");
            div.innerHTML = `
                <h3>${plan.tipo} (${plan.fecha_creacion})</h3>
                <ul>
                    ${plan.ejercicios ? plan.ejercicios.split(',').map(e => `<li>${e}</li>`).join("") : "<li>Sin ejercicios</li>"}
                </ul>
            `;
            contenedor.appendChild(div);
        });
    })
    .catch(error => console.error("Error al obtener planes:", error));
}

document.addEventListener("DOMContentLoaded", cargarPlanes);