<?php
require '../configuracion/conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion === 'agregar_rutina') {
            $nombre = $_POST['nombre'];
            $nivel = $_POST['nivel'];
            $descripcion = $_POST['descripcion'];
            $imagen = $_POST['imagen'] ?? null; // Validar que la clave 'imagen' exista
            $query = "INSERT INTO rutinas (nombre, nivel, descripcion, imagen) VALUES ('$nombre', '$nivel', '$descripcion', '$imagen')";
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
    </script>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center py-3"><i class="bx bxs-layer"></i> Calorifit</h2>
        <a onclick="mostrarSeccion('seccionAgregarRutina')"><i class="bx bx-plus-circle"></i> Agregar Rutinas</a>
        <a onclick="mostrarSeccion('seccionAgregarEjercicio')"><i class="bx bx-dumbbell"></i> Agregar Ejercicios</a>
        <a onclick="mostrarSeccion('seccionRutinasExistentes')"><i class="bx bx-list-ul"></i> Rutinas Existentes</a>
        <a onclick="mostrarSeccion('seccionEditarRutinas')"><i class="bx bx-edit"></i> Editar Rutinas</a>
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
                            <label for="nombre" class="form-label">Nombre de la Rutina</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ejemplo: Bajar de Peso" required>
                        </div>
                        <div class="mb-3">
                            <label for="nivel" class="form-label">Nivel</label>
                            <select class="form-select" id="nivel" name="nivel" required>
                                <option value="Principiante">Principiante</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción de la rutina" required></textarea>
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

        <!-- Sección Agregar Ejercicio -->
        <div id="seccionAgregarEjercicio" class="seccion hidden">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="h5 mb-0">Agregar Ejercicio a Rutina</h2>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="accion" value="agregar_ejercicio">
                        <div class="mb-3">
                            <label for="rutina_id" class="form-label">Rutina</label>
                            <select class="form-select" id="rutina_id" name="rutina_id" required>
                                <?php if (!empty($rutinas)): ?>
                                    <?php foreach ($rutinas as $rutina): ?>
                                        <option value="<?php echo $rutina['id']; ?>">
                                            <?php echo htmlspecialchars($rutina['nombre'] . " (" . $rutina['nivel'] . ")"); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay rutinas disponibles</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ejercicio_id" class="form-label">Ejercicio</label>
                            <select class="form-select" id="ejercicio_id" name="ejercicio_id" required>
                                <?php if (!empty($ejercicios)): ?>
                                    <?php foreach ($ejercicios as $ejercicio): ?>
                                        <option value="<?php echo $ejercicio['id']; ?>">
                                            <?php echo htmlspecialchars($ejercicio['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No hay ejercicios disponibles</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="series" class="form-label">Series</label>
                            <input type="number" class="form-control" id="series" name="series" placeholder="Número de series" required>
                        </div>
                        <div class="mb-3">
                            <label for="repeticiones" class="form-label">Repeticiones</label>
                            <input type="number" class="form-control" id="repeticiones" name="repeticiones" placeholder="Número de repeticiones" required>
                        </div>
                        <div class="mb-3">
                            <label for="peso" class="form-label">Peso (kg)</label>
                            <input type="number" class="form-control" id="peso" name="peso" placeholder="Peso en kg" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Asignar Ejercicio</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sección Editar Rutinas -->
        <div id="seccionEditarRutinas" class="seccion hidden">
            <h2 class="text-center mb-4 text-secondary">Editar Rutinas</h2>
            <div class="row">
                <?php foreach ($rutinas as $row): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($row['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                        <div class="card-body">
                            <form method="POST" id="form-editar-<?php echo $row['id']; ?>">
                                <input type="hidden" name="accion" value="editar_rutina">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <div class="mb-3">
                                    <label for="nombre-<?php echo $row['id']; ?>" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre-<?php echo $row['id']; ?>" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nivel-<?php echo $row['id']; ?>" class="form-label">Nivel</label>
                                    <select class="form-select" id="nivel-<?php echo $row['id']; ?>" name="nivel" required>
                                        <option value="Principiante" <?php echo $row['nivel'] === 'Principiante' ? 'selected' : ''; ?>>Principiante</option>
                                        <option value="Intermedio" <?php echo $row['nivel'] === 'Intermedio' ? 'selected' : ''; ?>>Intermedio</option>
                                        <option value="Avanzado" <?php echo $row['nivel'] === 'Avanzado' ? 'selected' : ''; ?>>Avanzado</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion-<?php echo $row['id']; ?>" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion-<?php echo $row['id']; ?>" name="descripcion" rows="3" required><?php echo htmlspecialchars($row['descripcion']); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="imagen-<?php echo $row['id']; ?>" class="form-label">URL de la Imagen</label>
                                    <input type="text" class="form-control" id="imagen-<?php echo $row['id']; ?>" name="imagen" value="<?php echo htmlspecialchars($row['imagen']); ?>">
                                </div>
                                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sección Rutinas Existentes -->
        <div id="seccionRutinasExistentes" class="seccion hidden">
            <h2 class="text-center mb-4 text-secondary">Rutinas Existentes</h2>
            <div class="row">
                <?php foreach ($rutinas as $row): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($row['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-warning"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                            <p class="text-muted"><strong>Nivel:</strong> <?php echo htmlspecialchars($row['nivel']); ?></p>
                            <a href="?editar=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="accion" value="eliminar_rutina">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
