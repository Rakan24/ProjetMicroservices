<?php

//require_once __DIR__ . '/../Modele/AccueilModele.php';

class AccueilControleur
{

    public function handleAccueil()
    {
        // Ici, vous pouvez récupérer des informations à afficher sur la page d'accueil
        // et charger la vue appropriée

        require_once __DIR__ . '/../Vue/ViewAccueil.php';  // Assurez-vous que cette vue existe
    }



}