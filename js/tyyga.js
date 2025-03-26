document.addEventListener("DOMContentLoaded", () => {
    const addTaskBtn = document.getElementById("addTaskBtn");
    const taskInput = document.getElementById("taskInput");
    const columns = document.querySelectorAll(".column .task-list");
    const deleteModal = document.getElementById("deleteModal");
    const confirmDeleteBtn = document.getElementById("confirmDelete");
    const cancelDeleteBtn = document.getElementById("cancelDelete");
    const clearTasksBtn = document.getElementById("clearTasksBtn");
    const totalTaskCounter = document.getElementById("totalTaskCounter");
    let taskIdCounter = 16; // Iniciar el contador después del último ID existente
    let taskToDelete = null;

    addTaskBtn.addEventListener("click", () => {
        const taskText = taskInput.value.trim();
        if (taskText === "") return;

        addTaskBtn.classList.add("loading");

        setTimeout(() => {
            const newTask = document.createElement("li");
            newTask.classList.add("task");
            newTask.textContent = taskText;
            newTask.setAttribute("draggable", "true");
            newTask.setAttribute("id", `task${taskIdCounter++}`);
            newTask.addEventListener("click", () => showDeleteModal(newTask));
            newTask.addEventListener("dragstart", dragStart);
            newTask.addEventListener("dragend", dragEnd);

            let selectedColumn = null;

            // Intentar agregar automáticamente a la primera columna disponible
            for (let column of columns) {
                if (column.children.length < 5) { // Máximo 5 ejercicios por día
                    column.appendChild(newTask);
                    updateTaskCounter(column);
                    selectedColumn = column.parentNode.id;
                    break;
                }
            }

            // Si no se encontró una columna automáticamente, preguntar al usuario
            if (!selectedColumn) {
                const dayOptions = Array.from(columns).map(column => column.parentNode.id).join(", ");
                selectedColumn = prompt(`¿En qué día deseas guardar la tarea? Opciones disponibles: ${dayOptions}`);
                const targetColumn = document.getElementById(selectedColumn)?.querySelector(".task-list");
                if (targetColumn) {
                    targetColumn.appendChild(newTask);
                    updateTaskCounter(targetColumn);
                } else {
                    alert("Día no válido. La tarea no se guardará.");
                    addTaskBtn.classList.remove("loading");
                    return;
                }
            }

            saveTask(taskText, selectedColumn);
            taskInput.value = "";
            updateTotalTaskCounter();
            alert("Nueva tarea agregada!");
            addTaskBtn.classList.remove("loading");
        }, 500); // Simular tiempo de carga
    });

    function saveTask(nombre, dia) {
        fetch('../php/tareas.php?action=add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nombre, dia })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Tarea guardada con ID:', data.id);
        });
    }

    function deleteTask(id) {
        fetch(`../php/tareas.php?action=delete&id=${id}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            console.log('Tarea eliminada:', data.success);
        });
    }

    clearTasksBtn.addEventListener("click", () => {
        columns.forEach(column => {
            while (column.firstChild) {
                column.removeChild(column.firstChild);
            }
            updateTaskCounter(column);
        });
        updateTotalTaskCounter();
    });

    columns.forEach(column => {
        column.addEventListener("dragover", dragOver);
        column.addEventListener("drop", drop);
        updateTaskCounter(column);
        updateTotalTaskCounter();
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
            updateTaskCounter(dropTarget);
            updateTaskCounter(draggable.parentNode);
        }
        draggable.classList.remove("dragging");
    }

    function showDeleteModal(task) {
        taskToDelete = task;
        deleteModal.style.display = "block";
    }

    confirmDeleteBtn.addEventListener("click", () => {
        if (taskToDelete) {
            const taskId = taskToDelete.id.replace('task', '');
            taskToDelete.classList.add("removing");
            setTimeout(() => {
                taskToDelete.remove();
                updateTaskCounter(taskToDelete.parentNode);
                updateTotalTaskCounter();
                deleteTask(taskId);
                taskToDelete = null;
            }, 500);
        }
        deleteModal.style.display = "none";
    });

    cancelDeleteBtn.addEventListener("click", () => {
        taskToDelete = null;
        deleteModal.style.display = "none";
    });

    function updateTaskCounter(column) {
        let counter = column.querySelector(".task-counter");
        if (!counter) {
            counter = document.createElement("div");
            counter.classList.add("task-counter");
            column.parentNode.insertBefore(counter, column.nextSibling);
        }
        counter.textContent = `Tareas: ${column.children.length}`;
    }

    function updateTotalTaskCounter() {
        let totalTasks = 0;
        columns.forEach(column => {
            totalTasks += column.children.length;
        });
        totalTaskCounter.textContent = `Total de tareas: ${totalTasks}`;
    }

    document.querySelectorAll(".task").forEach(task => {
        task.addEventListener("dragstart", dragStart);
        task.addEventListener("dragend", dragEnd);
        task.addEventListener("click", () => showDeleteModal(task));
    });

    fetchTasks();

    function fetchTasks() {
        fetch('../php/tareas.php?action=get')
            .then(response => response.json())
            .then(data => {
                data.forEach(task => {
                    const column = document.getElementById(task.dia);
                    const newTask = document.createElement("li");
                    newTask.classList.add("task");
                    newTask.textContent = task.nombre;
                    newTask.setAttribute("draggable", "true");
                    newTask.setAttribute("id", `task${task.id}`);
                    newTask.addEventListener("click", () => showDeleteModal(newTask));
                    newTask.addEventListener("dragstart", dragStart);
                    newTask.addEventListener("dragend", dragEnd);
                    column.querySelector(".task-list").appendChild(newTask);
                });
                updateTotalTaskCounter();
            });
    }
});
