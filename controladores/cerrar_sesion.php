<?php
session_start();
session_destroy();
header('Location: ../vistas/index.php');
exit;
?>
