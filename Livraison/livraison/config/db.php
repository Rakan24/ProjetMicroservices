<?php
$host = 'localhost';
$db   = 'restaurant';
$user = 'root';
$pass = '';  

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Échec de la connexion à la base de données: " . $e->getMessage();
}
?>
