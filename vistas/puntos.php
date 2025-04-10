<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicie sesión para continuar.";
    exit;
}

$puntos = $_SESSION['usuario']['puntos'] ?? 0;

// Initialize redeemed rewards if not set
if (!isset($_SESSION['usuario']['recompensas'])) {
    $_SESSION['usuario']['recompensas'] = [];
}

// Handle reward redemption
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['canjear'])) {
    $recompensa = $_POST['recompensa'];
    $puntos_requeridos = $_POST['puntos_requeridos'];

    if ($puntos >= $puntos_requeridos) {
        $puntos -= $puntos_requeridos;
        $_SESSION['usuario']['puntos'] = $puntos;
        $_SESSION['usuario']['recompensas'][] = $recompensa; // Add reward to user's rewards
        $mensaje = "¡Has canjeado '$recompensa' por $puntos_requeridos puntos!";
    } else {
        $error = "No tienes suficientes puntos para canjear esta recompensa.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Puntos</title>
    <link rel="stylesheet" href="../publico/css/puntos.css">
</head>
<body>
    <?php include '../vistas/navbar.php'; ?>
    <div class="header text-center">
        <h1 class="titulo">ESTOS SON TUS <span class="resaltar">PUNTOS</span></h1>
        <p class="subtitulo">Sigue completando rutinas para ganar más puntos y alcanzar tus metas.</p>
    </div>
    <div class="puntos-container text-center">
        <p class="puntos-text">Tienes un total de:</p>
        <h2 class="puntos-total"><?php echo $puntos; ?> puntos</h2>
        <p class="puntos-info">¡Sigue esforzándote para desbloquear más recompensas!</p>
    </div>

    <div class="rewards-container text-center">
        <h2 class="titulo">Canjear Recompensas</h2>
        <form method="POST" class="rewards-form">
            <select name="recompensa" class="form-select" required>
                <option value="Insignia de Bronce" data-puntos="50">Insignia de Bronce - 50 puntos</option>
                <option value="Insignia de Plata" data-puntos="100">Insignia de Plata - 100 puntos</option>
                <option value="Insignia de Oro" data-puntos="200">Insignia de Oro - 200 puntos</option>
            </select>
            <input type="hidden" name="puntos_requeridos" id="puntos_requeridos" value="50">
            <button type="submit" name="canjear" class="boton">Canjear</button>
        </form>
        <?php if (isset($mensaje)): ?>
            <p class="mensaje text-success"><?php echo $mensaje; ?></p>
        <?php elseif (isset($error)): ?>
            <p class="mensaje text-danger"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <div class="redeemed-rewards text-center">
        <h2 class="titulo">Tus Recompensas</h2>
        <?php if (!empty($_SESSION['usuario']['recompensas'])): ?>
            <ul class="rewards-list">
                <?php foreach ($_SESSION['usuario']['recompensas'] as $recompensa): ?>
                    <li class="reward-item">
                        <?php if ($recompensa === 'Insignia de Bronce'): ?>
                            <img src="https://img.pikbest.com/origin/08/98/98/75vpIkbEsTkYy.png!w700wp" alt="Insignia de Bronce" class="reward-image">
                        <?php elseif ($recompensa === 'Insignia de Plata'): ?>
                            <img src="../publico/imagenes/insignia_plata.png" alt="Insignia de Plata" class="reward-image">
                        <?php elseif ($recompensa === 'Insignia de Oro'): ?>
                            <img src="../publico/imagenes/insignia_oro.png" alt="Insignia de Oro" class="reward-image">
                        <?php endif; ?>
                        <p><?php echo htmlspecialchars($recompensa); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-rewards">Aún no has canjeado ninguna recompensa.</p>
        <?php endif; ?>
    </div>

    <script>
        const recompensaSelect = document.querySelector('select[name="recompensa"]');
        const puntosRequeridosInput = document.getElementById('puntos_requeridos');

        recompensaSelect.addEventListener('change', function () {
            const selectedOption = recompensaSelect.options[recompensaSelect.selectedIndex];
            puntosRequeridosInput.value = selectedOption.getAttribute('data-puntos');
        });
    </script>
</body>
</html>
