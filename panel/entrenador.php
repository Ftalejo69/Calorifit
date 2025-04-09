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
        } elseif ($accion === 'editar_rutina') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $nivel = $_POST['nivel'];
            $descripcion = $_POST['descripcion'];
            $imagen = $_POST['imagen'] ?? null; // Validar que la clave 'imagen' exista
            $query = "UPDATE rutinas SET nombre='$nombre', nivel='$nivel', descripcion='$descripcion', imagen='$imagen' WHERE id=$id";
            $conexion->query($query);
        } elseif ($accion === 'eliminar_rutina') {
            $id = $_POST['id'];
            $query = "DELETE FROM rutinas WHERE id=$id";
            $conexion->query($query);
        } elseif ($accion === 'agregar_ejercicio') {
            $rutina_id = $_POST['rutina_id'];
            $ejercicio_id = $_POST['ejercicio_id'];
            $series = $_POST['series'];
            $repeticiones = $_POST['repeticiones'];
            $peso = $_POST['peso'];
            $query = "INSERT INTO rutina_ejercicios (rutina_id, ejercicio_id, series, repeticiones, peso) VALUES ('$rutina_id', '$ejercicio_id', '$series', '$repeticiones', '$peso')";
            $conexion->query($query);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Entrenador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Gestión de Rutinas</h1>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="h5">Agregar Nueva Rutina</h2>
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
        <h2 class="text-center mb-4">Rutinas Existentes</h2>
        <div class="row">
            <?php foreach ($rutinas as $row): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($row['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                        <p class="text-muted"><strong>Nivel:</strong> <?php echo htmlspecialchars($row['nivel']); ?></p>
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
        <h2 class="text-center mb-4">Asignar Ejercicios a Rutinas</h2>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="h5">Agregar Ejercicio a Rutina</h2>
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
</body>
</html>
