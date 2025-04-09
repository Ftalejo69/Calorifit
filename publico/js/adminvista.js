document.addEventListener("DOMContentLoaded", () => {
    // Variables para el menú de usuario
    const userInfo = document.getElementById("user-info");
    const userMenu = document.getElementById("user-menu");

    // Gestión de modales
    const modals = document.querySelectorAll(".modal");
    const closeButtons = document.querySelectorAll(".close-modal");

    // Ocultar todos los modales al inicio
    modals.forEach(modal => {
        modal.style.display = "none";
    });

    // Manejadores para abrir el modal de perfil
    document.getElementById("ver-perfil")?.addEventListener("click", (e) => {
        e.preventDefault();
        const profileModal = document.getElementById("profile-modal");
        if (profileModal) {
            profileModal.classList.add("active");
        }
        // Cerrar el menú desplegable cuando se abre el modal
        document.getElementById("user-menu")?.classList.remove("active");
    });

    // Abrir modal de perfil
    document.getElementById("view-profile")?.addEventListener("click", (e) => {
        e.preventDefault();
        const profileModal = document.getElementById("profile-modal");
        if (profileModal) {
            profileModal.classList.add("active");
        }
    });

    // Cerrar modal con la X
    document.querySelectorAll(".close-modal").forEach(button => {
        button.addEventListener("click", () => {
            const modal = button.closest(".modal");
            if (modal) {
                modal.classList.remove("active");
            }
        });
    });

    // Cerrar modal al hacer clic fuera
    window.addEventListener("click", (event) => {
        const modals = document.querySelectorAll(".modal");
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.remove("active");
            }
        });
    });

    // Funcionalidad del modal de perfil
    const profileForm = document.getElementById("profile-form");
    const editProfileBtn = document.getElementById("edit-profile");
    const saveProfileBtn = document.getElementById("save-profile");
    const profileInputs = document.querySelectorAll("#profile-form input");

    // Asegurar que los inputs estén bloqueados al inicio
    profileInputs.forEach(input => input.readOnly = true);
    saveProfileBtn.style.display = "none";

    editProfileBtn?.addEventListener("click", () => {
        profileInputs.forEach(input => {
            input.readOnly = false;
            input.classList.add("editable");
        });
        editProfileBtn.style.display = "none";
        saveProfileBtn.style.display = "block";
    });

    profileForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = {
            nombre: document.getElementById("profile-name").value,
            correo: document.getElementById("profile-email").value,
            telefono: document.getElementById("profile-phone").value
        };

        fetch("../controladores/actualizar_perfil.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Perfil actualizado correctamente");
                profileInputs.forEach(input => input.readOnly = true);
                editProfileBtn.style.display = "block";
                saveProfileBtn.style.display = "none";
                
                // Actualizar la información mostrada en el header
                document.querySelector(".user-details h2").textContent = formData.nombre;
                document.querySelector(".user-details p").textContent = formData.correo;
            } else {
                alert(data.message || "Error al actualizar el perfil");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error al actualizar el perfil");
        });
    });

    // Manejadores de eventos para el menú de usuario
    if (userInfo && userMenu) {
        userInfo.addEventListener("click", () => {
            userMenu.classList.toggle("active");
        });

        document.querySelector("#user-menu a[href='../vistas/index.php']").addEventListener("click", (e) => {
            e.preventDefault();
            window.location.href = "../controladores/cerrar_sesion.php";
        });

        document.addEventListener("click", (event) => {
            if (!userInfo.contains(event.target)) {
                userMenu.classList.remove("active");
            }
        });
    }

    // Manejadores de eventos para modales
    document.getElementById("add-trainer-btn")?.addEventListener("click", () => {
        const trainerModal = document.getElementById("trainer-modal");
        if (trainerModal) trainerModal.style.display = "flex";
    });

    document.getElementById("add-plan-btn")?.addEventListener("click", () => {
        const planModal = document.getElementById("plan-modal");
        if (planModal) planModal.style.display = "flex";
    });

    // Cargar datos de membresias
    function cargarMembresias() {
        const tableBody = document.querySelector("#plans-table tbody");
        if (!tableBody) {
            console.error("No se encontró el elemento tbody");
            return;
        }

        fetch("/Calorifit/controladores/membresias_controlador.php?action=get")
            .then(response => {
                if (!response.ok) {
                    console.error('Status:', response.status);
                    return response.text().then(text => {
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos:", data); // Para depuración
                tableBody.innerHTML = "";
                if (Array.isArray(data)) {
                    data.forEach(membresia => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${membresia.id}</td>
                            <td>${membresia.nombre}</td>
                            <td>$${membresia.precio}</td>
                            <td>${membresia.duracion} días</td>
                            <td>
                                <button class="btn-edit" onclick="editarMembresia(${membresia.id})">Editar</button>
                                <button class="btn-delete" onclick="eliminarMembresia(${membresia.id})">Eliminar</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    console.error("Los datos recibidos no son un array:", data);
                }
            })
            .catch(error => {
                console.error("Error detallado al cargar membresias:", error);
                alert("Error al cargar las membresias. Revisa la consola para más detalles.");
            });
    }

    // Cargar datos de entrenadores
    function cargarEntrenadores() {
        const tableBody = document.querySelector("#trainers-table tbody");
        if (!tableBody) return;

        fetch("../controladores/entrenadores_controlador.php?action=get")
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                tableBody.innerHTML = "";
                data.forEach(trainer => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${trainer.id}</td>
                        <td>${trainer.name}</td>
                        <td>${trainer.specialty}</td>
                        <td>
                            <button onclick="editarEntrenador(${trainer.id})">Editar</button>
                            <button onclick="eliminarEntrenador(${trainer.id})">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Error al cargar entrenadores:", error);
                alert("Error al cargar los entrenadores");
            });
    }

    // Función para cargar usuarios
    function cargarUsuarios() {
        const tableBody = document.querySelector("#users-table tbody");
        if (!tableBody) {
            console.error("No se encontró la tabla de usuarios");
            return;
        }

        fetch("../controladores/usuarios_controlador.php?action=get")
            .then(response => {
                if (!response.ok) {
                    console.error('Status:', response.status);
                    return response.text().then(text => {
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log("Datos de usuarios recibidos:", data); // Para depuración
                tableBody.innerHTML = "";
                if (Array.isArray(data)) {
                    data.forEach(usuario => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${usuario.id}</td>
                            <td>${usuario.nombre}</td>
                            <td>${usuario.correo}</td>
                            <td>${usuario.fecha_registro}</td>
                            <td><span class="estado-badge ${usuario.estado}">${usuario.estado}</span></td>
                            <td>
                                <button class="btn-edit" onclick="editarUsuario(${usuario.id})">Editar</button>
                                <button class="btn-delete" onclick="eliminarUsuario(${usuario.id})">Eliminar</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                } else {
                    console.error("Los datos recibidos no son un array:", data);
                }
            })
            .catch(error => {
                console.error("Error detallado al cargar usuarios:", error);
                alert("Error al cargar los usuarios. Revisa la consola para más detalles.");
            });
    }

    // Funciones para editar y eliminar
    window.editarMembresia = function(id) {
        fetch(`../controladores/membresias_controlador.php?action=edit&id=${id}`)
            .then(response => response.json())
            .then(data => {
                // Aquí puedes implementar la lógica para editar
                console.log("Editando membresía:", data);
            })
            .catch(error => console.error("Error:", error));
    }

    window.eliminarMembresia = function(id) {
        if (confirm("¿Estás seguro de eliminar esta membresía?")) {
            fetch(`../controladores/membresias_controlador.php?action=delete&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    cargarMembresias();
                })
                .catch(error => console.error("Error:", error));
        }
    }

    // Manejar el envío del formulario de planes
    document.getElementById("plan-form")?.addEventListener("submit", (e) => {
        e.preventDefault();
        const planId = document.getElementById("plan-id").value;
        const formData = {
            name: document.getElementById("plan-name").value,
            price: document.getElementById("plan-price").value,
            duration: document.getElementById("plan-duration").value
        };

        const url = planId ? 
            `../controladores/membresias_controlador.php?action=update&id=${planId}` :
            "../controladores/membresias_controlador.php?action=create";

        fetch(url, {
            method: planId ? "PUT" : "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            document.getElementById("plan-modal").style.display = "none";
            cargarMembresias();
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Error al guardar el plan");
        });
    });

    // Navegación del menú mejorada
    const menuLinks = document.querySelectorAll(".menu li a");
    const sections = document.querySelectorAll(".content-section");

    // Función actualizada para mostrar/ocultar secciones
    function showSection(sectionId) {
        sections.forEach(section => {
            section.classList.add('section-hidden');
        });
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.classList.remove('section-hidden');
        }

        // Cargar datos según la sección
        if (sectionId === 'planes') {
            cargarMembresias();
        } else if (sectionId === 'entrenadores') {
            cargarEntrenadores();
        } else if (sectionId === 'usuarios') {
            cargarUsuarios();
        }
    }

    // Asegurar que al menos una sección esté visible al inicio
    const defaultSection = 'dashboard';
    showSection(defaultSection);
    const defaultLink = document.querySelector(`a[href="#${defaultSection}"]`);
    if (defaultLink) {
        defaultLink.classList.add('active');
    }

    menuLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            event.preventDefault();
            
            // Remover clase active de todos los links
            menuLinks.forEach(l => l.classList.remove("active"));
            
            // Agregar clase active al link clickeado
            link.classList.add("active");

            // Obtener el id de la sección a mostrar
            const targetId = link.getAttribute("href").substring(1);
            showSection(targetId);
        });
    });

    // Cargar datos al iniciar y cuando se hace clic en las secciones
    cargarMembresias();
    cargarEntrenadores();
});
