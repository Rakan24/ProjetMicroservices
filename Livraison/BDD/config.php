<?php
// Configuration pour la connexion à la base de données
function getConnection() {
    $host = 'localhost';        // Adresse du serveur
    $dbname = 'service_livraison'; // Nom de la base de données
    $username = 'root';         // Nom d'utilisateur
    $password = '';             // Mot de passe

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
