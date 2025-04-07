<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - CaloriFit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../publico/css/login.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-warning">
    <div class="card card-custom p-4 shadow">
        <h1 class="title mb-4"><span>Calori</span><span class="fit">Fit</span></h1>
        <h4 class="text-center mb-4">Recuperar Contraseña</h4>
        
        <form id="recuperarForm" action="../modelos/recuperar.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Enviar Enlace de Recuperación</button>
        </form>
        <div id="recuperarAlert" class="alert mt-3 d-none"></div>
        <div class="text-center mt-3">
            <a href="index.php" class="text-warning">Volver al inicio</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../publico/js/recuperar.js"></script>
</body>
</html>
