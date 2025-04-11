<?php
require_once '../modelos/rutinas_modelo.php';
require_once '../configuracion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;

    if ($accion === 'agregar_rutina') {
        $nivel = $_POST['nivel'];
        $imagen = $_POST['imagen'] ?? null;

        // Validar que el nivel no esté vacío
        if (empty($nivel)) {
            echo json_encode(['success' => false, 'message' => 'El nivel es obligatorio.']);
            exit;
        }

        // Insertar la rutina en la base de datos
        $query = "INSERT INTO rutinas (nivel, imagen) VALUES (?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $nivel, $imagen);
        $resultado = $stmt->execute();

        echo json_encode(['success' => $resultado]);
        exit;
    } elseif ($accion === 'editar_rutina') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $nivel = $_POST['nivel'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'] ?? null;
        $query = "UPDATE rutinas SET nombre='$nombre', nivel='$nivel', descripcion='$descripcion', imagen='$imagen' WHERE id=$id";
        $conexion->query($query);
        header("Location: ../panel/entrenador.php");
        exit;
    } elseif ($accion === 'eliminar_rutina') {
        $id = $_POST['id'];
        $query = "DELETE FROM rutinas WHERE id=$id";
        $conexion->query($query);
        header("Location: ../panel/entrenador.php");
        exit;
    } elseif ($accion === 'eliminar_objetivo') {
        $id = $_POST['id'];
        $query = "DELETE FROM rutinas WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        echo json_encode(['success' => $resultado]);
        exit;
    } elseif ($accion === 'editar_nivel') {
        $nivel = $_POST['nivel'];
        $imagen = $_POST['imagen'];

        $query = "UPDATE rutinas SET imagen = ? WHERE nivel = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $imagen, $nivel);
        $resultado = $stmt->execute();

        echo json_encode(['success' => $resultado]);
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
            $query_rutina = "SELECT id FROM rutinas WHERE nivel = ? AND nombre = ? LIMIT 1";
            $stmt_rutina = $conexion->prepare($query_rutina);
            $stmt_rutina->bind_param("ss", $nivel, $objetivo);
            $stmt_rutina->execute();
            $result_rutina = $stmt_rutina->get_result();

            if ($result_rutina->num_rows === 0) {
                $descripcion = "Rutina para el objetivo $objetivo en el nivel $nivel.";
                $query_insert_rutina = "INSERT INTO rutinas (nombre, nivel, descripcion) VALUES (?, ?, ?)";
                $stmt_insert_rutina = $conexion->prepare($query_insert_rutina);
                $stmt_insert_rutina->bind_param("sss", $objetivo, $nivel, $descripcion);
                $stmt_insert_rutina->execute();
                $rutina_id = $conexion->insert_id; // Obtener el ID de la rutina recién creada
            } else {
                $rutina = $result_rutina->fetch_assoc();
                $rutina_id = $rutina['id'];
            }

            // Insertar el ejercicio en la rutina correspondiente
            $query_insert = "INSERT INTO rutina_ejercicios (rutina_id, ejercicio_id, series, repeticiones, peso) 
                             VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conexion->prepare($query_insert);
            $stmt_insert->bind_param("iiiii", $rutina_id, $ejercicio_id, $series, $repeticiones, $peso);
            $stmt_insert->execute();
        }

        echo json_encode(['success' => true]);
        exit;
    } elseif ($accion === 'eliminar_nivel') {
        $nivel = $_POST['nivel'];

        // Eliminar todos los ejercicios asociados a los objetivos del nivel
        $query_eliminar_ejercicios = "
            DELETE re
            FROM rutina_ejercicios re
            INNER JOIN rutinas r ON re.rutina_id = r.id
            WHERE r.nivel = ?
        ";
        $stmt_ejercicios = $conexion->prepare($query_eliminar_ejercicios);
        $stmt_ejercicios->bind_param("s", $nivel);
        $stmt_ejercicios->execute();

        // Eliminar todos los objetivos asociados al nivel
        $query_eliminar_objetivos = "DELETE FROM rutinas WHERE nivel = ?";
        $stmt_objetivos = $conexion->prepare($query_eliminar_objetivos);
        $stmt_objetivos->bind_param("s", $nivel);
        $stmt_objetivos->execute();

        // Eliminar el nivel
        $query_eliminar_nivel = "DELETE FROM niveles WHERE nivel = ?";
        $stmt_nivel = $conexion->prepare($query_eliminar_nivel);
        $stmt_nivel->bind_param("s", $nivel);
        $resultado = $stmt_nivel->execute();

        echo json_encode(['success' => $resultado]);
        exit;
    } elseif ($accion === 'editar_objetivo') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        // Validar que el nombre no esté vacío
        if (empty($nombre)) {
            echo json_encode(['success' => false, 'message' => 'El nombre del objetivo es obligatorio.']);
            exit;
        }

        // Actualizar el objetivo en la base de datos
        $query = "UPDATE rutinas SET nombre = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si", $nombre, $id);
        $resultado = $stmt->execute();

        echo json_encode(['success' => $resultado]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nivel'])) {
    $nivel = $_GET['nivel'];

    // Obtener rutinas asociadas al nivel
    $query = "SELECT nombre, descripcion FROM rutinas WHERE nivel = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $nivel);
    $stmt->execute();
    $result = $stmt->get_result();

    $rutinas = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['success' => true, 'rutinas' => $rutinas]);
    exit;
}
?>
