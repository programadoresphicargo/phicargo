<?php


function conectarPostgresql()
{
    $host = 'localhost';
    $port = '5433';
    $dbname = 'BELCHEZ_MASTER_12_250724';
    $user = 'josimar';
    $password = 'choforo3d2';

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit;
    }
}
