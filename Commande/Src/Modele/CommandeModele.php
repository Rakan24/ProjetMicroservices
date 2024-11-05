<?php

require_once __DIR__ . '/../BDD/Database.php';

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


            ///Tests///
            //print_r($stmt->errorInfo());
            //echo "ID Client: $id_client, Date Livraison: $date_livraison\n";
            ///Tests///


            echo "<script>alert('Commande créée !'); document.location.href='?url=ViewAccueil';</script>";
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
    
            // Récupérer les résultats
            $commandesPassees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $commandesPassees; // Retournez les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // En cas d'erreur, assurez-vous de retourner un tableau vide
        }
    }

    public function afficherCommandesEnCours($id_client)
    {
        try {
            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE id_client = ? AND id_statut <> ?");
            $stmt->bindParam(1, $id_client, PDO::PARAM_INT);
            $stmt->bindValue(2, self::STATUT_LIVREE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
    
            // Récupérer les résultats
            $commandesEnCours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $commandesEnCours; // Retournez les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // En cas d'erreur, assurez-vous de retourner un tableau vide
        }
    }

    public function afficherCommandesAPreparer($id_restaurant)
    {
        try {
            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE id_restaurant = ? AND (id_statut = ? OR id_statut = ?)");
            $stmt->bindParam(1, $id_client, PDO::PARAM_INT);
            $stmt->bindValue(2, self::STATUT_EN_ATTENTE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->bindValue(3, self::STATUT_EN_PREPARATION, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
    
            // Récupérer les résultats
            $commandesAPreparer = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $commandesAPreparer; // Retournez les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // En cas d'erreur, assurez-vous de retourner un tableau vide
        }
    }

    public function afficherCommandesALivrer()
    {
        try {
            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE (id_statut = ? OR id_statut = ?)");
            $stmt->bindValue(1, self::STATUT_TERMINEE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->bindValue(2, self::STATUT_EN_LIVRAISON, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
    
            // Récupérer les résultats
            $commandesALivrer = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $commandesALivrer; // Retournez les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // En cas d'erreur, assurez-vous de retourner un tableau vide
        }
    }
    
}
