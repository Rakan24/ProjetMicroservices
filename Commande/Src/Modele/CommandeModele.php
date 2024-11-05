<?php

require 'Database.php';

class CommandeModele
{
    // Définition des constantes de statut
    const STATUT_EN_ATTENTE = 1;
    const STATUT_EN_PREPARATION = 2;
    const STATUT_TERMINEE = 3;
    const STATUT_EN_LIVRAISON = 4;
    const STATUT_LIVREE = 5;

    protected function getBdd()
    {
        return Database::getBdd();
    }

    public function passerCommande($id_client, $date_livraison)
    {
        try {
            $stmt = $this->getBdd()->prepare("INSERT INTO commandes (id_client, date_livraison, id_statut) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $id_client);
            $stmt->bindParam(2, $date_livraison);
            $stmt->bindValue(3, self::STATUT_EN_ATTENTE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
            echo "<script>alert('Commande créée !'); document.location.href='?url=AccueilClient';</script>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        }
    }

    public function mettreAJourStatut($id_commande, $nouveau_statut)
    {
        try {
            $stmt = $this->getBdd()->prepare("UPDATE commandes SET id_statut = ? WHERE id_commande = ?");
            $stmt->bindParam(1, $nouveau_statut, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_commande, PDO::PARAM_INT);
            $stmt->execute();
            echo "Le statut de la commande a été mis à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du statut : " . $e->getMessage();
        }
    }

    public function afficherCommandesPassees($id_client)
    {
        try {
            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE id_client = ? AND id_statut = ?");
            $stmt->bindParam(1, $id_client, PDO::PARAM_INT);
            $stmt->bindValue(2, self::STATUT_LIVREE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
        }
    }
}
