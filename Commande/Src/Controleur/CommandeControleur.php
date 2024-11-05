<?php

require_once __DIR__ . '/../Modele/CommandeModele.php';

class CommandeControleur
{
    public function handleCommandeCreation()
    {
        if (isset($_POST['creer'])) {
            $commandeModele = new CommandeModele();
            $id_client = 1; //$_SESSION['id_client']; 
            $date_livraison = date('Y-m-d H:i:s'); //$_POST['date_livraison'] ?? date('Y-m-d H:i:s');
            
            $commandeModele->passerCommande($id_client, $date_livraison);
        }
        
        require_once __DIR__ . '/../Vue/ViewCreationCommande.php';
    }

    public function handleUpdateStatut($id_commande, $nouveau_statut)
    {
        if ($id_commande && $nouveau_statut) {
            $commandeModele = new CommandeModele();
            $commandeModele->mettreAJourStatut($id_commande, $nouveau_statut);
        } else {
            echo "Paramètres invalides pour la mise à jour du statut.";
        }
    }

    public function handleDeleteCommande($id_commande)
    {
        if ($id_commande) {
            $commandeModele = new CommandeModele();
            $commandeModele->annulerCommande($id_commande);
        } else {
            echo "ID de commande non spécifié pour la suppression.";
        }
    }








    public function handleShowCommandesPassees()
    {
        $commandeModele = new CommandeModele();
        $id_client = 1;// $_SESSION['id_client'];
        
        $commandesPassees = $commandeModele->afficherCommandesPassees($id_client);
    
        require_once __DIR__ . '/../Vue/ViewCommandesPassees.php';
    }

    public function handleShowCommandesEnCours()
    {
        $commandeModele = new CommandeModele();
        $id_client = 1;// $_SESSION['id_client'];
        
        $commandesEnCours = $commandeModele->afficherCommandesEnCours($id_client);
    
        require_once __DIR__ . '/../Vue/ViewCommandesEnCours.php';
    }

    public function handleShowCommandesAPreparer()
    {
        $commandeModele = new CommandeModele();
        $id_restaurant = 1;// $_SESSION['id_restaurant'];
        
        $commandesEnCours = $commandeModele->afficherCommandesAPreparer($id_restaurant);
    
        require_once __DIR__ . '/../Vue/ViewCommandesAPreparer.php';
    }

    public function handleShowCommandesALivrer()
    {
        $commandeModele = new CommandeModele();
        
        $commandesEnCours = $commandeModele->afficherCommandesALivrer();
    
        require_once __DIR__ . '/../Vue/ViewCommandesALivrer.php';
    }
    
}
