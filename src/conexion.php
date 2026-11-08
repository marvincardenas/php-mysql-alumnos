<?php

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    if (!$host) {
        throw new Exception('La variable DB_HOST no está configurada');
    }

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (Throwable $e) {
    error_log($e->getMessage());
    die('Error de conexión: ' . htmlspecialchars($e->getMessage()));
}

?>
