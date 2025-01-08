<?php

require_once __DIR__ . '/../Modele/CommandeModele.php';

class CommandeControleur
{
    #-------------------------------------------------------------------------#
    #                        INSERT / UPDATE / DELETE                         #
    #-------------------------------------------------------------------------#

    public function handleCommandeCreation()
    {
        if (isset($_POST['creer'])) {
            $commandeModele = new CommandeModele();
            $id_client = $_SESSION['id_client'];
            $date_livraison = date('Y-m-d H:i:s'); //$_POST['date_livraison'] ?? date('Y-m-d H:i:s');
            
            $commandeModele->passerCommande($id_client, $date_livraison);
        }
        
        require_once __DIR__ . '/../Vue/ViewCreationCommande.php';
    }

    public function handleUpdateStatut()
    {
        // Vérifier que la requête est POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $id_commande = $_POST['id_commande'] ?? null;
            $nouveau_statut = $_POST['nouveau_statut'] ?? null;
    
            // Valider les données
            if ($id_commande && $nouveau_statut) {
                $commandeModele = new CommandeModele();
                $commandeModele->mettreAJourStatut($id_commande, $nouveau_statut);
    
                // Redirection après mise à jour en fonction du statut
                if ($nouveau_statut == 2) {
                    // Redirection vers la page des commandes à préparer (restaurant)
                    header("Location: index.php?url=Commande/handleShowCommandesAPreparer");
                } elseif ($nouveau_statut == 3) {
                    // Redirection vers la page des commandes à livrer (livreur)
                    header("Location: index.php?url=Commande/handleShowCommandesAPreparer");
                } elseif ($nouveau_statut == 4) {
                    // Redirection vers la page des commandes à livrer (livreur)
                    header("Location: index.php?url=Commande/handleShowCommandesALivrer");
                } else {
                    // Cas par défaut (optionnel)
                    echo "Statut non pris en charge pour la redirection.";
                }
                exit;
            } else {
                echo "Paramètres invalides pour la mise à jour du statut.";
            }
        } else {
            echo "Méthode de requête non autorisée.";
        }
    }
    
    

    public function handleDeleteCommande()
    {
        if (isset($_POST['annuler'])) {
            $commandeModele = new CommandeModele();
            $id_commande = $_POST['id_commande']; 
            $commandeModele->annulerCommande($id_commande);
        } else {
            echo "ID de commande non spécifié pour la suppression.";
        }
    }

    #-------------------------------------------------------------------------#
    #                           FONCTIONS DE VUES                             #
    #-------------------------------------------------------------------------#

    public function handleShowFormulaireCommande()
{
    // Vérification de la session pour id_client
    $id_client = $_SESSION['id_client'] ?? null;
    if (!$id_client) {
        // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
        header("Location: index.php");
        exit;
    }

    // Charger la vue pour créer une commande
    require_once __DIR__ . '/../Vue/ViewCreationCommande.php';
}



    public function handleShowCommandesPassees()
    {
        $commandeModele = new CommandeModele();
        $id_client = $_SESSION['id_client'];
        
        $commandesPassees = $commandeModele->afficherCommandesPassees($id_client);
    
        require_once __DIR__ . '/../Vue/ViewCommandesPassees.php';
    }

    public function handleShowCommandesEnCours()
    {
        $commandeModele = new CommandeModele();
        $id_client = $_SESSION['id_client'];
        
        $commandesEnCours = $commandeModele->afficherCommandesEnCours($id_client);
    
        require_once __DIR__ . '/../Vue/ViewCommandesEnCours.php';
    }

    public function handleShowCommandesAPreparer()
    {
        $commandeModele = new CommandeModele();
        $id_restaurant = $_SESSION['id_restaurant'];
        
        $commandesAPreparer = $commandeModele->afficherCommandesAPreparer($id_restaurant);
    
        require_once __DIR__ . '/../Vue/ViewCommandesAPreparer.php';
    }

    public function handleShowCommandesALivrer()
    {
        $commandeModele = new CommandeModele();
        
        $commandesALivrer = $commandeModele->afficherCommandesALivrer();
    
        require_once __DIR__ . '/../Vue/ViewCommandesALivrer.php';
    }

    #-------------------------------------------------------------------------#
    #                           GESTION DE LA CONNEXION                       #
    #-------------------------------------------------------------------------#



    //Methode temporaire !!
    public function handleSetSession()
    {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        // Vérification de l'existence des données POST
        if (isset($_POST['role'])) {
            $role = $_POST['role'];

            // Affectation des valeurs à la session en fonction du rôle
            switch ($role) {
                case 'client':
                    $_SESSION['id_client'] = 1; // Vous pouvez mettre la valeur appropriée ici
                    break;
                case 'livreur':
                    $_SESSION['id_livreur'] = 1; // Vous pouvez mettre la valeur appropriée ici
                    break;
                case 'restaurant':
                    $_SESSION['id_restaurant'] = 1; // Vous pouvez mettre la valeur appropriée ici
                    break;
                default:
                    echo "Rôle non reconnu.";
                    break;
            }
        }

        // Rediriger vers la page d'accueil après avoir mis à jour les sessions
        header("Location: Commande/Src/Vue/ViewAccueil.php");
        exit;
    }

        //Methode temporaire !!
        public function handleDeleteSession()
        {
            session_start();  // Démarre la session
            session_unset();  // Supprime toutes les variables de session
            session_destroy();  // Détruit la session

            // Rediriger vers la page d'accueil après avoir mis à jour les sessions
            header("Location: Commande/Src/Vue/ViewAccueil.php");
            exit;
        }






}

?>
