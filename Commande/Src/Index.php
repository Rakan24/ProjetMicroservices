<?php
// Définir les en-têtes HTTP pour gérer les requêtes API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Inclure les fichiers nécessaires
require_once 'src/controller/CommandeControleur.php';
require_once 'src/modele/CommandeModele.php';
require_once 'src/config/database.php';

// Récupérer les informations de la requête
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

// Instancier les contrôleurs
$commandeController = new CommandeControleur();

try {
    // Gestion des requêtes POST
    if ($method === 'POST') {
        if (preg_match("/^\/commandes$/", $requestUri)) {
            // Créer une nouvelle commande
            $commandeController->creerCommande($data);
        } else {
            echo json_encode(["message" => "Route POST non reconnue."]);
        }
    }
    // Gestion des requêtes PUT
    elseif ($method === 'PUT') {
        if (preg_match("/^\/commandes\/statut$/", $requestUri)) {
            // Mettre à jour le statut d'une commande
            $commandeController->mettreAJourStatut($data);
        } else {
            echo json_encode(["message" => "Route PUT non reconnue."]);
        }
    }
    // Gestion des requêtes DELETE
    elseif ($method === 'DELETE') {
        if (preg_match("/^\/commandes\/(\d+)$/", $requestUri, $matches)) {
            $idCommande = $matches[1];
            // Annuler une commande
            $commandeController->annulerCommande($idCommande);
        } else {
            echo json_encode(["message" => "Route DELETE non reconnue."]);
        }
    }
    // Gestion des requêtes GET
    elseif ($method === 'GET') {
        if (preg_match("/^\/commandes\/client\/(\d+)$/", $requestUri, $matches)) {
            $idClient = $matches[1];
            // Afficher les commandes passées d'un client
            $commandeController->afficherCommandesPassees($idClient);
        } elseif (preg_match("/^\/commandes\/en-cours\/client\/(\d+)$/", $requestUri, $matches)) {
            $idClient = $matches[1];
            // Afficher les commandes en cours d'un client
            $commandeController->afficherCommandesEnCours($idClient);
        } elseif (preg_match("/^\/commandes\/a-preparer\/restaurant\/(\d+)$/", $requestUri, $matches)) {
            $idRestaurant = $matches[1];
            // Afficher les commandes à préparer pour un restaurant
            $commandeController->afficherCommandesAPreparer($idRestaurant);
        } elseif (preg_match("/^\/commandes\/a-livrer\/livreur\/(\d+)$/", $requestUri, $matches)) {
            $idLivreur = $matches[1];
            // Afficher les commandes à livrer pour un livreur
            $commandeController->afficherCommandesALivrer($idLivreur);
        } else {
            echo json_encode(["message" => "Route GET non reconnue."]);
        }
    }
    // Méthode non prise en charge
    else {
        echo json_encode(["message" => "Méthode non autorisée."]);
    }
} catch (Exception $e) {
    echo json_encode(["message" => "Erreur : " . $e->getMessage()]);
}
