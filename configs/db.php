<?php

// Conexión a la base de datos con PDO.

$host = 'localhost';
$dbname = 'tarea';
$user = 'root';
$dbpassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Hubo un error en la conexión: '.$e->getMessage();
}