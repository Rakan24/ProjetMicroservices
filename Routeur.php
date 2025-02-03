<?php

class Routeur
{
    private $url;

    public function __construct($url)
    {
        // Filtrer et sécuriser l'URL pour éviter l'injection de code
        $this->url = array_map('htmlspecialchars', $url);
    }

    public function routerRequete()
    {
        if (empty($this->url)) {
            // Default homepage if no URL is specified
            $this->redirectToDefault();
            return; // Stop execution here to avoid running the rest
        }

        // First segment of the URL determines the service
        $service = ucfirst(strtolower($this->url[0])); // Ex: 'Commande', 'Livraison'
        $action = $this->url[1] ?? null;              // Action: 'createCommande', etc.
        $params = array_slice($this->url, 2);         // Retrieve all remaining parameters

        // Build the path to the controller
        $controllerClass = $service . 'Controleur';
        $controllerPath = "$service/Src/Controleur/$controllerClass.php";

        // Check if the controller exists for the specified service
        if (!file_exists($controllerPath)) {
            throw new Exception("Service non reconnu : " . $service);
        }

        // Require the controller
        require_once $controllerPath;

        // Ensure the class exists after including the file
        if (!class_exists($controllerClass)) {
            throw new Exception("Le contrôleur spécifié est introuvable : " . $controllerClass);
        }

        $controller = new $controllerClass();

        // Routing based on the action
        if ($action && method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            throw new Exception("Action non reconnue : " . ($action ?? 'Aucune action spécifiée'));
        }
    }

    private function redirectToDefault()
    {
        // Check if the current URL is already the default homepage
        if (basename($_SERVER['PHP_SELF']) === 'index.php') {
            // Serve homepage content or exit without redirection
            return;
        }

        // Redirect to the homepage (index.php)
        header('Location: index.php');
        exit; // Ensure no further code is executed after the redirect
    }
}
