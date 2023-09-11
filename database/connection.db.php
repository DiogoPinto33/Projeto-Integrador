<?php
declare(strict_types=1);

function getDatabaseConnection(): PDO {
    $servername = 'localhost';
    $port = 3306;
    $database = 'projeto_integrador';
    $username = 'root';
    $password = 'Pi_1234_';

    try {
        $dsn = "mysql:host=$servername;port=$port;dbname=$database;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $db = new PDO($dsn, $username, $password, $options);
        return $db;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

?>
