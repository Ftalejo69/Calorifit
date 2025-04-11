<?php
require '../modelos/rutinas_modelo.php';
require '../configuracion/conexion.php';

// Obtener datos desde el modelo
$rutinas = obtenerRutinas($conexion);
$ejercicios = obtenerEjercicios($conexion);
$niveles = obtenerNiveles($conexion);
$objetivos = obtenerObjetivos($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Entrenador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #ffc107; /* Amarillo principal */
            color: #343a40;
            position: fixed;
            width: 250px;
        }
        .sidebar h2 {
            font-size: 1.8rem;
            font-weight: bold;
        }
        .sidebar a {
            color: #343a40;
            text-decoration: none;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
        }
        .sidebar a i {
            font-size: 1.8rem; /* Tamaño de los íconos */
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: #e0a800; /* Amarillo más oscuro */
            color: #fff;
        }
        .logout {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }
        .logout a {
            color: #fff;
            background-color: #dc3545; /* Rojo */
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .logout a:hover {
            background-color: #bd2130;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .content h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .card-header {
            background-color: #ffc107; /* Amarillo principal */
            color: #343a40;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .btn-success, .btn-danger, .btn-primary {
            font-size: 1rem;
            font-weight: bold;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
        // Función para mostrar una sección específica
        function mostrarSeccion(seccionId) {
            document.querySelectorAll('.seccion').forEach(seccion => {
                seccion.classList.add('hidden');
            });
            document.getElementById(seccionId).classList.remove('hidden');
        }

        // Configurar eventos para los botones del menú
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.menu-item').forEach(item => {
                item.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    mostrarSeccion(target);
                });
            });
        });

        function eliminarObjetivo(id) {
            if (!confirm('¿Estás seguro de que deseas eliminar este objetivo?')) return;

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    accion: 'eliminar_objetivo',
                    id: id,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Objetivo eliminado correctamente');
                    document.getElementById(`objetivo-${id}`).remove();
                } else {
                    alert('Error al eliminar el objetivo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar eliminar el objetivo.');
            });
        }

        function editarObjetivo(event, id) {
            event.preventDefault();

            const form = document.getElementById(`form-editar-objetivo-${id}`);
            const formData = new FormData(form);

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Objetivo actualizado correctamente');
                    location.reload();
                } else {
                    alert('Error al actualizar el objetivo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar actualizar el objetivo.');
            });
        }

        function agregarObjetivo(event, nivel) {
            event.preventDefault();

            const form = document.getElementById(`form-agregar-objetivo-${nivel}`);
            const formData = new FormData(form);

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Objetivo agregado correctamente');
                    location.reload();
                } else {
                    alert('Error al agregar el objetivo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar agregar el objetivo.');
            });
        }

        function guardarNivel(event, nivel) {
            event.preventDefault();

            const form = document.getElementById(`form-nivel-${nivel}`);
            const formData = new FormData(form);

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Nivel actualizado correctamente');
                    location.reload();
                } else {
                    alert('Error al actualizar el nivel.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar actualizar el nivel.');
            });
        }

        function mostrarObjetivos(nivel) {
            document.getElementById('nivelSeleccionado').value = nivel;

            // Cargar información de rutinas y niveles asociados
            fetch(`../controladores/rutinas_controlador.php?nivel=${nivel}`)
                .then(response => response.json())
                .then(data => {
                    const infoRutina = document.getElementById('infoRutina');
                    if (data.success) {
                        infoRutina.innerHTML = `
                            <h4 class="text-secondary">Rutinas para el nivel: ${nivel}</h4>
                            <ul>
                                ${data.rutinas.map(rutina => `<li>${rutina.nombre} - ${rutina.descripcion}</li>`).join('')}
                            </ul>
                        `;
                    } else {
                        infoRutina.innerHTML = '<p class="text-danger">No se encontraron rutinas para este nivel.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al cargar las rutinas.');
                });

            mostrarSeccion('seccionObjetivos');
        }

        function asignarEjercicios(event) {
            event.preventDefault();

            const form = document.getElementById('form-asignar-ejercicios');
            const formData = new FormData(form);

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Ejercicios asignados correctamente');
                    // Limpiar los campos del formulario para permitir nuevas asignaciones
                    form.reset();
                } else {
                    alert('Error al asignar los ejercicios.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar asignar los ejercicios.');
            });
        }

        function eliminarNivel(nivel) {
            if (!confirm('¿Estás seguro de que deseas eliminar este nivel? Se eliminarán también todos los objetivos y ejercicios asociados.')) return;

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    accion: 'eliminar_nivel',
                    nivel: nivel,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Nivel eliminado correctamente');
                    location.reload();
                } else {
                    alert('Error al eliminar el nivel.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar eliminar el nivel.');
            });
        }

        function agregarRutina(event) {
            event.preventDefault();

            const form = document.getElementById('form-agregar-rutina');
            const formData = new FormData(form);

            fetch('../controladores/rutinas_controlador.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Rutina agregada correctamente');
                    location.reload();
                } else {
                    alert('Error al agregar la rutina.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al intentar agregar la rutina.');
            });
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center py-3"><i class="bx bxs-layer"></i> Calorifit</h2>
        <a class="menu-item" data-target="seccionAgregarRutina"><i class="bx bx-plus-circle"></i> Agregar Rutinas</a>
        <a class="menu-item" data-target="seccionObjetivosExistentes"><i class="bx bx-list-ul"></i> Objetivos Existentes</a>
        <a class="menu-item" data-target="seccionNiveles"><i class="bx bx-layer"></i> Niveles</a>
        <div class="logout">
            <a href="../controladores/cerrar_sesion.php"><i class="bx bxs-log-out"></i> Cerrar Sesión</a>
        </div>
    </div>
    <div class="content">
        <h1 class="text-center mb-4 text-warning">Panel de Entrenador</h1>

        <!-- Sección Agregar Rutina -->
        <div id="seccionAgregarRutina" class="seccion hidden">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="h5 mb-0">Agregar Nueva Rutina</h2>
                </div>
                <div class="card-body">
                    <form id="form-agregar-rutina" onsubmit="agregarRutina(event)">
                        <input type="hidden" name="accion" value="agregar_rutina">
                        <div class="mb-3">
                            <label for="nivel" class="form-label">Nivel</label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="" disabled selected>Seleccionar Nivel</option>
                                <option value="Principiante">Principiante</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">URL de la Imagen</label>
                            <input type="text" class="form-control" id="imagen" name="imagen" placeholder="URL de la imagen">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Agregar Rutina</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sección Objetivos Existentes -->
        <div id="seccionObjetivosExistentes" class="seccion hidden">
            <h2 class="text-center mb-4 text-secondary">Objetivos Existentes</h2>
            <div class="row">
                <?php foreach ($niveles as $nivel): ?>
                <div class="col-md-12 mb-4">
                    <h3 class="text-warning"><?php echo htmlspecialchars($nivel['nivel']); ?></h3>
                    <div class="row">
                        <?php
                        $objetivos = obtenerObjetivosPorNivel($conexion, $nivel['nivel']);
                        ?>
                        <?php if (!empty($objetivos)): ?>
                            <?php foreach ($objetivos as $objetivo): ?>
                            <div class="col-md-4 mb-4" id="objetivo-<?php echo $objetivo['id']; ?>">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title text-center text-primary"><?php echo htmlspecialchars($objetivo['nombre']); ?></h5>
                                        <form id="form-editar-objetivo-<?php echo $objetivo['id']; ?>" onsubmit="editarObjetivo(event, <?php echo $objetivo['id']; ?>)">
                                            <input type="hidden" name="accion" value="editar_objetivo">
                                            <input type="hidden" name="id" value="<?php echo $objetivo['id']; ?>">
                                            <div class="mb-3">
                                                <label for="nombre-<?php echo $objetivo['id']; ?>" class="form-label">Nombre del Objetivo</label>
                                                <input type="text" class="form-control" id="nombre-<?php echo $objetivo['id']; ?>" name="nombre" value="<?php echo htmlspecialchars($objetivo['nombre']); ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-success w-100 mb-2">Guardar Cambios</button>
                                        </form>
                                        <button class="btn btn-danger w-100" onclick="eliminarObjetivo(<?php echo $objetivo['id']; ?>);">Eliminar Objetivo</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center">No hay objetivos disponibles para este nivel.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sección Niveles -->
        <div id="seccionNiveles" class="seccion hidden">
            <h2 class="text-center mb-4 text-secondary">Niveles</h2>
            <div class="row">
                <?php foreach ($niveles as $nivel): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($nivel['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($nivel['nivel']); ?>">
                        <div class="card-body text-center">
                            <h3 class="card-title text-warning"><?php echo htmlspecialchars($nivel['nivel']); ?></h3>
                            <form id="form-nivel-<?php echo htmlspecialchars($nivel['nivel']); ?>" onsubmit="guardarNivel(event, '<?php echo htmlspecialchars($nivel['nivel']); ?>')">
                                <input type="hidden" name="accion" value="editar_nivel">
                                <input type="hidden" name="nivel" value="<?php echo htmlspecialchars($nivel['nivel']); ?>">
                                <div class="mb-3">
                                    <label for="imagen-<?php echo htmlspecialchars($nivel['nivel']); ?>" class="form-label">URL de la Imagen</label>
                                    <input type="text" class="form-control" id="imagen-<?php echo htmlspecialchars($nivel['nivel']); ?>" name="imagen" value="<?php echo htmlspecialchars($nivel['imagen']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                            </form>
                            <button class="btn btn-danger w-100 mt-2" onclick="eliminarNivel('<?php echo htmlspecialchars($nivel['nivel']); ?>')">Eliminar Nivel</button>
                            <button class="btn btn-primary w-100 mt-2" onclick="mostrarObjetivos('<?php echo htmlspecialchars($nivel['nivel']); ?>')">Asignar Ejercicios a Objetivos</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sección Objetivos por Nivel -->
        <div id="seccionObjetivos" class="seccion hidden">
            <h2 class="text-center mb-4 text-secondary">Asignar Ejercicios a Objetivos</h2>
            <form id="form-asignar-ejercicios" onsubmit="asignarEjercicios(event)">
                <input type="hidden" name="accion" value="agregar_ejercicios_a_objetivos">
                <input type="hidden" id="nivelSeleccionado" name="nivel">
                <div id="infoRutina" class="mb-4">
                    <!-- Aquí se mostrarán las rutinas y niveles asociados dinámicamente -->
                </div>
                <div class="row">
                    <?php foreach (['Bajar de Peso', 'Mantenimiento', 'Ganar Músculo'] as $objetivo): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-warning"><?php echo htmlspecialchars($objetivo); ?></h5>
                                <div class="mb-2">
                                    <select class="form-select" name="ejercicios[<?php echo htmlspecialchars($objetivo); ?>][ejercicio_id]" required>
                                        <option value="" disabled selected>Seleccionar Ejercicio</option>
                                        <?php foreach ($ejercicios as $ejercicio): ?>
                                        <option value="<?php echo $ejercicio['id']; ?>"><?php echo htmlspecialchars($ejercicio['nombre']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="ejercicios[<?php echo htmlspecialchars($objetivo); ?>][series]" placeholder="Series" required>
                                </div>
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="ejercicios[<?php echo htmlspecialchars($objetivo); ?>][repeticiones]" placeholder="Repeticiones" required>
                                </div>
                                <div class="mb-2">
                                    <input type="number" class="form-control" name="ejercicios[<?php echo htmlspecialchars($objetivo); ?>][peso]" placeholder="Peso (kg)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-success w-100">Asignar Ejercicios</button>
            </form>
            <button class="btn btn-secondary mt-3" onclick="mostrarSeccion('seccionNiveles')">Volver a Niveles</button>
        </div>
    </div>
</body>
</html>
