document.addEventListener("DOMContentLoaded", () => {
    const addTaskBtn = document.getElementById("addTaskBtn");
    const taskInput = document.getElementById("taskInput");
    const columns = document.querySelectorAll(".column .task-list");
    
    addTaskBtn.addEventListener("click", () => {
        const taskText = taskInput.value.trim();
        if (taskText === "") return;

        const newTask = document.createElement("li");
        newTask.classList.add("task");
        newTask.textContent = taskText;
        newTask.addEventListener("click", () => newTask.remove());

        // Agregar la tarea a la primera columna disponible
        for (let column of columns) {
            if (column.children.length < 5) { // Máximo 5 ejercicios por día
                column.appendChild(newTask);
                break;
            }
        }

        taskInput.value = "";
    });
});
