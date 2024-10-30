<?php
session_start(); // Démarrer la session
class CommandeControleur
{
    private $_view;

    public function __construct($url)
    {
        // Vérifiez si des paramètres supplémentaires sont fournis dans l'URL
        // et gérez-les ou lancez une exception si l'URL n'est pas valide
        // Vérifier si les variables de session 'nom' et 'prenom' sont présentes
        if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
            // Rediriger vers une page de connexion ou afficher un message d'erreur
            header('Location: index.php');
            exit(); // Arrêter l'exécution du script
        }

        if  ($_SESSION['id_service'] != 1){

            header('Location: ?url=AccueilClient');
            exit();

        }

        if (isset($url) && is_array($url) && count($url) > 1)
            throw new Exception('Page introuvable');
        else
            $this->createCommande();
    }





    private function createCommande()
    {
        // Logique pour initialiser la création du patient
        // Cela inclut généralement la préparation des données nécessaires pour la vue
        // et ensuite charger la vue.
        if (isset($_POST['creer'])) {


            $commande = new passerCommande();
            $id_client = $_SESSION['id_client']; 
            $date_livraison	= date('2000-01-01 01:01:01');

            
            
            $commande->insererCommande($id_client, $date_livraison);


        }
        require_once('src/views/ViewCreationCommande.php');
    }
}
