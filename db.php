<?php
    $host = 'localhost';
    $dbname = 'crud_php';
    $port = '5432';
    $user = 'postgres';
    $password = '123456';

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        echo "Connection failed";
        die($e->getMessage());
    }
?>