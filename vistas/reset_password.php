<?php
session_start();
if (!isset($_GET['token'])) {
    header('Location: index.php');
    exit;
}
$token = $_GET['token'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña - CaloriFit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../publico/css/login.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-warning">
    <div class="card card-custom p-4 shadow">
        <h1 class="title"><span>Calori</span><span class="fit">Fit</span></h1>
        <h4 class="text-center mb-4">Restablecer Contraseña</h4>
        
        <form id="resetForm" action="../controladores/reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" name="nueva_password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" name="confirmar_password" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Cambiar Contraseña</button>
        </form>
        <div id="resetAlert" class="alert mt-3 d-none"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
