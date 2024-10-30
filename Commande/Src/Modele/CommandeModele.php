<?php

require 'Database.php'; // Inclure le fichier de connexion à la base de données
class CommandeModele
{

    protected function getBdd()
    {
        return Database::getBdd();
    }



    public function passerCommande($id_client, $date_livraison)
    {
        try {
            $dernier_id = $this->getBdd()->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        }

        $stmt2 = $this->getBdd()->prepare("INSERT INTO commandes(id_client, date_livraison) VALUES (?,?)");

        $stmt2->bindParam(1, $id_client);
        $stmt2->bindParam(2, $date_livraison);

        try {
            $stmt2->execute();
            echo "<script>alert('Commande créée !');
        document.location.href='?url=AccueilClient';
        </script>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        }

    }



    public function annulerCommande($id_commande)
    {
        try {
            // Préparer la requête de suppression
            $stmt = $this->getBdd()->prepare("DELETE FROM commandes WHERE id = ?");
            
            // Associer l'ID de la commande à supprimer
            $stmt->bindParam(1, $id_commande, PDO::PARAM_INT);
            
            // Exécuter la requête
            $stmt->execute();
            
            echo "La commande a été supprimée avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la commande : " . $e->getMessage();
        }
    }



    public function mettreAJourStatut($id_commande, $nouveau_statut)
    {

        try {
            // Préparer la requête de mise à jour
            $stmt = $this->getBdd()->prepare("UPDATE commandes SET id_statut = ? WHERE id = ?");
            
            // Associer les valeurs
            $stmt->bindParam(1, $nouveau_statut);
            $stmt->bindParam(2, $id_commande, PDO::PARAM_INT);
            
            // Exécuter la requête
            $stmt->execute();
            
            echo "Le statut de la commande a été mis à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du statut : " . $e->getMessage();
        }
    }

    

    public function afficherCommandesPassees($id_client)
{
    try {
        // Préparer la requête de sélection pour les commandes livrées
        $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE client_id = ? AND statut_id = 5");

        // Associer l'ID du client
        $stmt->bindParam(1, $id_client, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        // Récupérer toutes les commandes livrées
        $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Afficher les commandes récupérées
        return $commandes;

    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
    }
}



}
