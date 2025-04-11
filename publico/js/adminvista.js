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
    const addTrainerBtn = document.getElementById("add-trainer-btn");
    if (addTrainerBtn) {
        addTrainerBtn.addEventListener("click", () => {
            const addModal = document.getElementById("add-trainer-modal");
            if (addModal) {
                addModal.classList.add("active");
            } else {
                console.error("No se encontró el modal de agregar entrenador.");
            }
        });
    }

    document.getElementById("add-plan-btn")?.addEventListener("click", () => {
        const planModal = document.getElementById("plan-modal");
        if (planModal) {
            planModal.classList.add("active");
            // Limpiar el formulario
            document.getElementById("plan-form").reset();
            document.getElementById("plan-id").value = "";
            document.getElementById("plan-modal-title").textContent = "Agregar Plan";
            benefitsContainer.innerHTML = '';
            addBenefitInput();
        }
    });

    // Funciones para manejar beneficios
    const benefitsContainer = document.getElementById('benefits-container');
    const addBenefitButton = document.getElementById('add-benefit');

    function addBenefitInput(value = '') {
        const benefitDiv = document.createElement('div');
        benefitDiv.className = 'benefit-item';
        benefitDiv.innerHTML = `
            <input type="text" class="benefit-input" value="${value}" placeholder="Ingrese un beneficio">
            <button type="button" class="remove-benefit">×</button>
        `;
        benefitsContainer.appendChild(benefitDiv);

        // Agregar evento para eliminar beneficio
        benefitDiv.querySelector('.remove-benefit').addEventListener('click', function() {
            benefitDiv.remove();
        });
    }

    addBenefitButton.addEventListener('click', () => addBenefitInput());

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
                        const beneficios = membresia.beneficios ? JSON.parse(membresia.beneficios) : [];
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${membresia.id}</td>
                            <td>${membresia.nombre}</td>
                            <td>$${membresia.precio}</td>
                            <td>${membresia.duracion} días</td>
                            <td>${membresia.descripcion}</td>
                            <td>${beneficios.join('<br>')}</td>
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
    async function cargarEntrenadores() {
        try {
            const response = await fetch('/Calorifit/controladores/entrenadores_controlador.php?action=get');
            if (!response.ok) throw new Error('HTTP error! status: ' + response.status);
            
            const result = await response.json();
            if (!result.success) {
                throw new Error(result.error || 'Error al cargar entrenadores');
            }

            const entrenadores = result.data;
            const tbody = document.querySelector('#trainers-table tbody');
            tbody.innerHTML = '';

            entrenadores.forEach(entrenador => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${entrenador.id}</td>
                    <td>${entrenador.nombre}</td>
                    <td>${entrenador.correo}</td>
                    <td>${entrenador.telefono}</td>
                    <td>
                        <button class="edit-btn" data-id="${entrenador.id}">
                            <i class='bx bx-edit'></i>
                        </button>
                        <button class="delete-btn" data-id="${entrenador.id}">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // Agregar eventos a los botones de editar y eliminar
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', () => abrirModalEdicion(button.dataset.id));
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', () => eliminarEntrenador(button.dataset.id));
            });
        } catch (error) {
            console.error('Error al cargar entrenadores:', error);
        }
    }

    function abrirModalEdicion(id) {
        const modal = document.getElementById('edit-trainer-modal');
        const form = document.getElementById('trainer-form');

        if (!modal || !form) {
            console.error("No se encontró el modal o el formulario de edición.");
            return;
        }

        fetch(`/Calorifit/controladores/entrenadores_controlador.php?action=getById&id=${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const entrenador = data.data;
                    form.querySelector("#trainer-id").value = entrenador.id;
                    form.querySelector("#trainer-name").value = entrenador.nombre;
                    form.querySelector("#trainer-email").value = entrenador.correo;
                    form.querySelector("#trainer-phone").value = entrenador.telefono;
                    modal.classList.add("active");
                } else {
                    console.error("Error al obtener los datos del entrenador:", data.error);
                }
            })
            .catch(error => console.error("Error al cargar los datos del entrenador:", error));
    }

    // Manejar el envío del formulario para agregar entrenador
    document.getElementById('add-trainer-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const datos = {
            nombre: formData.get('nombre'),
            correo: formData.get('correo'),
            telefono: formData.get('telefono')
        };

        try {
            const response = await fetch('/Calorifit/controladores/entrenadores_controlador.php?action=add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(datos)
            });

            const result = await response.json();
            if (result.success) {
                alert('Entrenador agregado correctamente');
                document.getElementById('add-trainer-modal').style.display = 'none';
                e.target.reset();
                await cargarEntrenadores();
            } else {
                throw new Error(result.error || 'Error al agregar entrenador');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
        }
    });

    // Manejar el envío del formulario para editar entrenador
    document.getElementById('trainer-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const datos = {
            id: formData.get('id'),
            nombre: formData.get('nombre'),
            correo: formData.get('correo'),
            telefono: formData.get('telefono')
        };

        try {
            const response = await fetch('/Calorifit/controladores/entrenadores_controlador.php?action=update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(datos)
            });

            const result = await response.json();
            if (result.success) {
                alert('Entrenador actualizado correctamente');
                document.getElementById('edit-trainer-modal').style.display = 'none';
                await cargarEntrenadores();
            } else {
                throw new Error(result.error || 'Error al actualizar entrenador');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
        }
    });

    // Función para cerrar el modal
    function cerrarModal() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('active');
        });
    }

    // Asignar el evento a todos los botones de cierre
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', cerrarModal);
    });

    // También cerramos el modal si el usuario hace clic fuera del contenido del modal
    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('modal')) {
            cerrarModal();
        }
    });

    async function eliminarEntrenador(id) {
        if (!confirm('¿Estás seguro de que deseas eliminar este entrenador?')) return;

        try {
            const response = await fetch(`/Calorifit/controladores/entrenadores_controlador.php?action=delete&id=${id}`, {
                method: 'DELETE'
            });

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.error || 'Error al eliminar entrenador');
            }

            alert('Entrenador eliminado correctamente');
            cargarEntrenadores();
        } catch (error) {
            console.error('Error al eliminar entrenador:', error);
        }
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
        const planModal = document.getElementById("plan-modal");
        if (planModal) {
            fetch(`/Calorifit/controladores/membresias_controlador.php?action=getById&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("plan-id").value = data.plan.id;
                        document.getElementById("plan-name").value = data.plan.nombre;
                        document.getElementById("plan-price").value = data.plan.precio;
                        document.getElementById("plan-duration").value = data.plan.duracion;
                        document.getElementById("plan-description").value = data.plan.descripcion;
                        
                        // Limpiar beneficios existentes
                        benefitsContainer.innerHTML = '';
                        
                        // Cargar beneficios
                        if (data.plan.beneficios) {
                            const beneficios = JSON.parse(data.plan.beneficios);
                            beneficios.forEach(beneficio => addBenefitInput(beneficio));
                        }
                        
                        document.getElementById("plan-modal-title").textContent = "Editar Plan";
                        planModal.classList.add("active");
                    } else {
                        throw new Error(data.error || "Error al obtener datos del plan");
                    }
                })
                .catch(error => {
                    console.error("Error al cargar el plan:", error);
                    alert("Error al cargar el plan");
                });
        }
    };

    window.eliminarMembresia = async function(id) {
        if (confirm("¿Estás seguro de eliminar esta membresía?")) {
            try {
                const response = await fetch(`/Calorifit/controladores/membresias_controlador.php?action=delete&id=${id}`, {
                    method: "DELETE"
                });

                const data = await response.json();
                if (data.success) {
                    alert("Membresía eliminada correctamente");
                    await cargarMembresias(); // Recargar la tabla inmediatamente
                } else {
                    throw new Error(data.error || "Error al eliminar membresía");
                }
            } catch (error) {
                console.error("Error:", error);
                alert("Error al eliminar la membresía");
            }
        }
    };

    // Manejar el envío del formulario de planes
    document.getElementById("plan-form")?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const planId = document.getElementById("plan-id").value;
        
        // Recoger todos los beneficios
        const beneficios = Array.from(document.querySelectorAll('.benefit-input'))
            .map(input => input.value.trim())
            .filter(value => value !== '');

        const formData = {
            nombre: document.getElementById("plan-name").value,
            precio: document.getElementById("plan-price").value,
            duracion: document.getElementById("plan-duration").value,
            descripcion: document.getElementById("plan-description").value,
            beneficios: JSON.stringify(beneficios)
        };

        const url = planId 
            ? `/Calorifit/controladores/membresias_controlador.php?action=update&id=${planId}` 
            : "/Calorifit/controladores/membresias_controlador.php?action=create";

        try {
            const response = await fetch(url, {
                method: planId ? "PUT" : "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();
            if (data.success) {
                alert(data.message || "Operación exitosa");
                document.getElementById("plan-modal").classList.remove("active");
                document.getElementById("plan-form").reset();
                benefitsContainer.innerHTML = '';
                addBenefitInput();
                await cargarMembresias(); // Recargar la tabla inmediatamente
            } else {
                throw new Error(data.error || "Error al procesar la solicitud");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Error al guardar el plan");
        }
    });

    // Manejar el envío del formulario de entrenadores
    async function guardarEntrenador(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const datos = {
            nombre: formData.get('nombre'),
            apellido: formData.get('apellido'),
            correo: formData.get('correo'),
            telefono: formData.get('telefono'),
            especialidad: formData.get('especialidad'),
            estado: formData.get('estado')
        };

        try {
            const response = await fetch('/Calorifit/controladores/entrenadores_controlador.php?action=add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(datos)
            });

            if (!response.ok) throw new Error('Error al guardar');
            
            const result = await response.json();
            if (result.success) {
                closeModal('trainer-modal');
                cargarEntrenadores();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

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
