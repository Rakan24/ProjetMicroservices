<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Routeur.php';

try {
    // Récupère l'URL et la transforme en tableau
    $url = isset($_GET['url']) ? explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL)) : [];

    // Instancie le routeur et lui passe l'URL
    $routeur = new Routeur($url);
    $routeur->routerRequete();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
