<?php

require_once 'models/CommandeModele.php';

class CommandeControleur
{
    public function handleCommandeCreation()
    {
        if (isset($_POST['creer'])) {
            $commandeModele = new CommandeModele();
            $id_client = $_SESSION['id_client']; 
            $date_livraison = $_POST['date_livraison'] ?? date('Y-m-d H:i:s');
            
            $commandeModele->passerCommande($id_client, $date_livraison);
        }
        
        require_once('src/views/ViewCreationCommande.php');
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
        $id_client = $_SESSION['id_client'];
        
        $commandesPassees = $commandeModele->afficherCommandesPassees($id_client);

        require_once('src/views/ViewCommandesPassees.php');
    }
}
