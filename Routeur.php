<?php

class Routeur
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function routerRequete()
    {
        if (empty($this->url)) {
            // Page d'accueil par défaut si aucune URL spécifiée
            $this->redirectToDefault();
            return; // Terminer ici pour éviter d'exécuter le reste
        }

        // Premier segment de l'URL pour déterminer le service
        $service = ucfirst(strtolower($this->url[0])); // Ex: 'Commande', 'Livraison'
        $action = $this->url[1] ?? null;              // Action : 'createCommande', etc.
        $params = array_slice($this->url, 2);         // Récupère tous les paramètres restants

        // Construire le chemin vers le contrôleur
        $controllerClass = $service . 'Controleur';
        $controllerPath = "$service/Src/Controleur/$controllerClass.php";

        // Vérifier si le contrôleur existe pour le service spécifié
        if (!file_exists($controllerPath)) {
            throw new Exception("Service non reconnu : " . htmlspecialchars($service));
        }

        require_once $controllerPath;
        $controller = new $controllerClass();

        // Routage basé sur l'action
        if (method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            throw new Exception("Action non reconnue : " . htmlspecialchars($action));
        }
    }

    private function redirectToDefault()
    {
        // Définir la page par défaut, ici la page d'accueil du client, ou une page d'accueil générique
        require_once 'Commande/Src/Controleur/AccueilControleur.php';  // Changer si nécessaire
        $controller = new AccueilControleur();  // Assurez-vous que vous avez ce contrôleur
        $controller->handleAccueil();  // Appeler la méthode pour la page d'accueil
    }
}
