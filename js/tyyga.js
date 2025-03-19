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
        newTask.setAttribute("draggable", "true");
        newTask.addEventListener("click", () => newTask.remove());
        newTask.addEventListener("dragstart", dragStart);
        newTask.addEventListener("dragend", dragEnd);

        // Agregar la tarea a la primera columna disponible
        for (let column of columns) {
            if (column.children.length < 5) { // Máximo 5 ejercicios por día
                column.appendChild(newTask);
                break;
            }
        }

        taskInput.value = "";
    });

    columns.forEach(column => {
        column.addEventListener("dragover", dragOver);
        column.addEventListener("drop", drop);
    });

    function dragStart(e) {
        e.dataTransfer.setData("text/plain", e.target.id);
        setTimeout(() => {
            e.target.classList.add("dragging");
        }, 0);
    }

    function dragEnd(e) {
        e.target.classList.remove("dragging");
    }

    function dragOver(e) {
        e.preventDefault();
    }

    function drop(e) {
        e.preventDefault();
        const id = e.dataTransfer.getData("text/plain");
        const draggable = document.getElementById(id);
        const dropTarget = e.target.closest(".task-list");
        if (dropTarget && dropTarget !== draggable.parentNode) {
            dropTarget.appendChild(draggable);
        }
        draggable.classList.remove("dragging");
    }

    document.querySelectorAll(".task").forEach(task => {
        task.addEventListener("dragstart", dragStart);
        task.addEventListener("dragend", dragEnd);
    });
});
