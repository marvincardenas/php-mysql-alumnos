
<?php

$databaseUrl = getenv('DATABASE_URL');

try {

    if ($databaseUrl) {

        // Conexión mediante DATABASE_URL (Render)
        $db = parse_url($databaseUrl);

        $host = $db['host'];
        $port = $db['port'] ?? '5432';
        $dbname = ltrim($db['path'], '/');
        $username = urldecode($db['user']);
        $password = urldecode($db['pass']);

    } else {

        // Conexión mediante variables DB_* (Docker)
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT') ?: '5432';
        $dbname = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

    }

    if (!$host || !$dbname || !$username) {
        throw new Exception('Faltan variables de conexión PostgreSQL');
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
