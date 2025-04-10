<?php
require '../configuracion/conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion === 'agregar_rutina') {
            $nivel = $_POST['nivel'];
            $imagen = $_POST['imagen'] ?? null; // Validar que la clave 'imagen' exista
            $query = "INSERT INTO rutinas (nivel, imagen) VALUES ('$nivel', '$imagen')";
            $conexion->query($query);
            header("Location: entrenador.php"); // Redirigir para evitar reenvío del formulario
            exit;
        } elseif ($accion === 'editar_rutina') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $nivel = $_POST['nivel'];
            $descripcion = $_POST['descripcion'];
            $imagen = $_POST['imagen'] ?? null; // Validar que la clave 'imagen' exista
            $query = "UPDATE rutinas SET nombre='$nombre', nivel='$nivel', descripcion='$descripcion', imagen='$imagen' WHERE id=$id";
            $conexion->query($query);
            header("Location: entrenador.php");
            exit;
        } elseif ($accion === 'eliminar_rutina') {
            $id = $_POST['id'];
            $query = "DELETE FROM rutinas WHERE id=$id";
            $conexion->query($query);
            header("Location: entrenador.php");
            exit;
        } elseif ($accion === 'agregar_ejercicio') {
            $rutina_id = $_POST['rutina_id'];
            $ejercicio_id = $_POST['ejercicio_id'];
            $series = $_POST['series'];
            $repeticiones = $_POST['repeticiones'];
            $peso = $_POST['peso'];
            $query = "INSERT INTO rutina_ejercicios (rutina_id, ejercicio_id, series, repeticiones, peso) VALUES ('$rutina_id', '$ejercicio_id', '$series', '$repeticiones', '$peso')";
            $conexion->query($query);
            header("Location: entrenador.php");
            exit;
        } elseif ($accion === 'agregar_ejercicios_a_objetivos') {
            $nivel = $_POST['nivel'];
            $ejercicios = $_POST['ejercicios'];

            foreach ($ejercicios as $objetivo => $datos) {
                $ejercicio_id = $datos['ejercicio_id'];
                $series = $datos['series'];
                $repeticiones = $datos['repeticiones'];
                $peso = $datos['peso'];

                // Verificar si la rutina para el nivel y objetivo existe, si no, crearla
                $query_rutina = "SELECT id FROM rutinas WHERE nivel = '$nivel' AND nombre = '$objetivo' LIMIT 1";
                $result_rutina = $conexion->query($query_rutina);
                if ($result_rutina->num_rows === 0) {
                    $descripcion = "Rutina para el objetivo $objetivo en el nivel $nivel.";
                    $query_insert_rutina = "INSERT INTO rutinas (nombre, nivel, descripcion) VALUES ('$objetivo', '$nivel', '$descripcion')";
                    $conexion->query($query_insert_rutina);
                    $rutina_id = $conexion->insert_id; // Obtener el ID de la rutina recién creada
                } else {
                    $rutina = $result_rutina->fetch_assoc();
                    $rutina_id = $rutina['id'];
                }

                // Insertar el ejercicio en la rutina correspondiente
                $query_insert = "INSERT INTO rutina_ejercicios (rutina_id, ejercicio_id, series, repeticiones, peso) 
                                 VALUES ('$rutina_id', '$ejercicio_id', '$series', '$repeticiones', '$peso')";
                $conexion->query($query_insert);
            }

            header("Location: entrenador.php");
            exit;
        } elseif ($accion === 'editar_objetivo') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $query_update = "UPDATE rutinas SET nombre = '$nombre' WHERE id = $id";
            $conexion->query($query_update);
            header("Location: entrenador.php");
            exit;
        } elseif ($accion === 'eliminar_objetivo') {
            $id = $_POST['id'];

            $query_delete = "DELETE FROM rutinas WHERE id = $id";
            $conexion->query($query_delete);
            header("Location: entrenador.php");
            exit;
        } elseif ($accion === 'editar_nivel') {
            $nivel = $_POST['nivel'];
            $imagen = $_POST['imagen'];

            $query_update = "UPDATE rutinas SET imagen = '$imagen' WHERE nivel = '$nivel'";
            $conexion->query($query_update);
            header("Location: entrenador.php");
            exit;
        }
    }
}

// Obtener rutinas
$query_rutinas = "SELECT id, nombre, nivel, descripcion, imagen FROM rutinas"; // Incluir la columna 'descripcion'
$result_rutinas = $conexion->query($query_rutinas);
$rutinas = $result_rutinas->fetch_all(MYSQLI_ASSOC); // Almacenar los resultados en un array

// Obtener ejercicios
$query_ejercicios = "SELECT id, nombre FROM ejercicios";
$result_ejercicios = $conexion->query($query_ejercicios);
$ejercicios = $result_ejercicios->fetch_all(MYSQLI_ASSOC); // Almacenar los resultados en un array

// Obtener niveles únicos desde la tabla rutinas con imágenes
$query_niveles = "
    SELECT nivel, imagen 
    FROM rutinas 
    WHERE id IN (
        SELECT MIN(id) 
        FROM rutinas 
        GROUP BY nivel
    )
";
$result_niveles = $conexion->query($query_niveles);
$niveles = $result_niveles->fetch_all(MYSQLI_ASSOC);

// Obtener objetivos agrupados por nivel
$query_objetivos = "SELECT id, nombre, nivel, descripcion, imagen FROM rutinas ORDER BY nivel";
$result_objetivos = $conexion->query($query_objetivos);
$objetivos = $result_objetivos->fetch_all(MYSQLI_ASSOC);

// Obtener rutinas agrupadas por nivel
$query_rutinas_por_nivel = "SELECT id, nombre, nivel, descripcion, imagen FROM rutinas ORDER BY nivel";
$result_rutinas_por_nivel = $conexion->query($query_rutinas_por_nivel);
$rutinas_por_nivel = $result_rutinas_por_nivel->fetch_all(MYSQLI_ASSOC);

// Verificar si se solicitó editar una rutina específica
$editarRutinaId = isset($_GET['editar']) ? $_GET['editar'] : null;
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
        function mostrarSeccion(seccionId) {
            document.querySelectorAll('.seccion').forEach(seccion => {
                seccion.classList.add('hidden');
            });
            document.getElementById(seccionId).classList.remove('hidden');
        }

        // Mostrar automáticamente la sección de editar rutinas si se selecciona una rutina
        document.addEventListener('DOMContentLoaded', () => {
            const editarRutinaId = "<?php echo $editarRutinaId; ?>";
            if (editarRutinaId) {
                mostrarSeccion('seccionEditarRutinas');
                const rutinaForm = document.getElementById(`form-editar-${editarRutinaId}`);
                if (rutinaForm) {
                    rutinaForm.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });

        function mostrarObjetivos(nivel) {
            document.getElementById('nivelSeleccionado').value = nivel;
            mostrarSeccion('seccionObjetivos');
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center py-3"><i class="bx bxs-layer"></i> Calorifit</h2>
        <a onclick="mostrarSeccion('seccionAgregarRutina')"><i class="bx bx-plus-circle"></i> Agregar Rutinas</a>
        <a onclick="mostrarSeccion('seccionObjetivosExistentes')"><i class="bx bx-list-ul"></i> Objetivos Existentes</a>
        <a onclick="mostrarSeccion('seccionNiveles')"><i class="bx bx-layer"></i> Niveles</a>
        <div class="logout">
            <a href="../controladores/cerrar_sesion.php"><i class="bx bxs-log-out"></i> Cerrar Sesión</a>
        </div>
    </div>
    <div class="content">
        <h1 class="text-center mb-4 text-warning">Panel de Entrenador</h1>

        <!-- Sección Agregar Rutina -->
        <div id="seccionAgregarRutina" class="seccion">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="h5 mb-0">Agregar Nueva Rutina</h2>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="accion" value="agregar_rutina">
                        <div class="mb-3">
                            <label for="nivel" class="form-label">Nivel</label>
                            <select class="form-select" id="nivel" name="nivel" required>
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
                        $query_objetivo = "SELECT id, nombre FROM rutinas WHERE nivel = '$nivel[nivel]' AND nombre IS NOT NULL AND nombre != ''";
                        $result_objetivo = $conexion->query($query_objetivo);
                        $objetivos = $result_objetivo->fetch_all(MYSQLI_ASSOC);
                        ?>
                        <?php if (!empty($objetivos)): ?>
                            <?php foreach ($objetivos as $objetivo): ?>
                                <?php if (!empty($objetivo['nombre'])): // Validar que el nombre no esté vacío ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <form method="POST">
                                                <input type="hidden" name="accion" value="editar_objetivo">
                                                <input type="hidden" name="id" value="<?php echo $objetivo['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="nombre-<?php echo $objetivo['id']; ?>" class="form-label">Nombre del Objetivo</label>
                                                    <input type="text" class="form-control" id="nombre-<?php echo $objetivo['id']; ?>" name="nombre" value="<?php echo htmlspecialchars($objetivo['nombre']); ?>" required>
                                                </div>
                                                <button type="submit" class="btn btn-success w-100 mb-2">Guardar Cambios</button>
                                            </form>
                                            <form method="POST">
                                                <input type="hidden" name="accion" value="eliminar_objetivo">
                                                <input type="hidden" name="id" value="<?php echo $objetivo['id']; ?>">
                                                <button type="submit" class="btn btn-danger w-100">Eliminar Objetivo</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
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
                            <form method="POST">
                                <input type="hidden" name="accion" value="editar_nivel">
                                <input type="hidden" name="nivel" value="<?php echo htmlspecialchars($nivel['nivel']); ?>">
                                <div class="mb-3">
                                    <label for="imagen-<?php echo htmlspecialchars($nivel['nivel']); ?>" class="form-label">URL de la Imagen</label>
                                    <input type="text" class="form-control" id="imagen-<?php echo htmlspecialchars($nivel['nivel']); ?>" name="imagen" value="<?php echo htmlspecialchars($nivel['imagen']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                            </form>
                            <button class="btn btn-primary w-100 mt-2" onclick="mostrarObjetivos('<?php echo htmlspecialchars($nivel['nivel']); ?>')">Agregar Ejercicios a Objetivos</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sección Objetivos por Nivel -->
        <div id="seccionObjetivos" class="seccion hidden">
            <h2 class="text-center mb-4 text-secondary">Agregar Ejercicios a Objetivos</h2>
            <form method="POST">
                <input type="hidden" name="accion" value="agregar_ejercicios_a_objetivos">
                <input type="hidden" id="nivelSeleccionado" name="nivel">
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
                <button type="submit" class="btn btn-success w-100">Agregar Ejercicios</button>
            </form>
            <button class="btn btn-secondary mt-3" onclick="mostrarSeccion('seccionNiveles')">Volver a Niveles</button>
        </div>
    </div>
</body>
</html>
