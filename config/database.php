<?php
try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=gymdb;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die(json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']));
}
