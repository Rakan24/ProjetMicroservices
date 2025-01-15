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

    #-------------------------------------------------------------------------#
    #                        INSERT / UPDATE / DELETE                         #
    #-------------------------------------------------------------------------#

    public function passerCommande($id_client, $date_livraison)
    {
        try {
            
            $stmt = $this->getBdd()->prepare("INSERT INTO commandes (id_client, date_livraison, id_statut) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $id_client);
            $stmt->bindParam(2, $date_livraison);
            $stmt->bindValue(3, self::STATUT_EN_ATTENTE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();

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

    public function annulerCommande($id_commande)
    {
        try {
            $stmt = $this->getBdd()->prepare("DELETE FROM commandes WHERE id_commande = ?");
            $stmt->bindParam(1, $id_commande);
            $stmt->execute();
            echo "<script>alert('Commande annulée !'); document.location.href='?url=ViewAccueil';</script>";
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        }
    }

    #-------------------------------------------------------------------------#
    #                           FONCTIONS DE VUES                             #
    #-------------------------------------------------------------------------#

    public function afficherCommandesPassees($id_client = null)
    {
        try {

            // Vérification de la session pour id_client
            $id_client = $_SESSION['id_client'] ?? null;
            if (!$id_client) {
                // Rediriger vers la page d'accueil si l'utilisateur n'est pas un livreur
                header("Location: index.php");
                exit;
            }

            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE id_client = ? AND id_statut = ?");
            $stmt->bindParam(1, $id_client, PDO::PARAM_INT);
            $stmt->bindValue(2, self::STATUT_LIVREE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
    
            $commandesPassees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $commandesPassees; // Retourne les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function afficherCommandesEnCours($id_client = null)
    {
        try {

            // Vérification de la session pour id_client
            $id_client = $_SESSION['id_client'] ?? null;
            if (!$id_client) {
                // Rediriger vers la page d'accueil si l'utilisateur n'est pas un livreur
                header("Location: index.php");
                exit;
            }

            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE id_client = ? AND id_statut <> ?");
            $stmt->bindParam(1, $id_client, PDO::PARAM_INT);
            $stmt->bindValue(2, self::STATUT_LIVREE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
    
            $commandesEnCours = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $commandesEnCours; // Retourne les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function afficherCommandesAPreparer($id_restaurant = null)
    {
        try {

            // Vérification de la session pour id_restaurant
            $id_restaurant = $_SESSION['id_restaurant'] ?? null;
            if (!$id_restaurant) {
                // Rediriger vers la page d'accueil si l'utilisateur n'est pas un livreur
                header("Location: index.php");
                exit;
            }

            $stmt = $this->getBdd()->prepare("SELECT * FROM commandes WHERE id_restaurant = ? AND (id_statut = ? OR id_statut = ? OR id_statut = ?)");
            $stmt->bindParam(1, $id_restaurant, PDO::PARAM_INT);
            $stmt->bindValue(2, self::STATUT_EN_ATTENTE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->bindValue(3, self::STATUT_EN_PREPARATION, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->bindValue(4, self::STATUT_TERMINEE, PDO::PARAM_INT); // Utilisation de la constante
            $stmt->execute();
    
            $commandesAPreparer = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $commandesAPreparer; // Retourne les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }

    public function afficherCommandesALivrer()
    {
        // Vérification de la session pour id_livreur
        $idLivreur = $_SESSION['id_livreur'] ?? null;
        if (!$idLivreur) {
            // Rediriger vers la page d'accueil si l'utilisateur n'est pas un livreur
            header("Location: index.php");
            exit;
        }
    
        try {
            // Préparer la requête avec des conditions distinctes
            $sql = "SELECT * FROM commandes 
                    WHERE id_statut = :statut_terminee 
                       OR (id_statut = :statut_en_livraison AND id_livreur = :id_livreur)";
            $stmt = $this->getBdd()->prepare($sql);
    
            // Bind des paramètres
            $stmt->bindValue(':statut_terminee', self::STATUT_TERMINEE, PDO::PARAM_INT);
            $stmt->bindValue(':statut_en_livraison', self::STATUT_EN_LIVRAISON, PDO::PARAM_INT);
            $stmt->bindValue(':id_livreur', $idLivreur, PDO::PARAM_INT);
    
            // Exécuter la requête
            $stmt->execute();
    
            // Récupérer et retourner les commandes
            $commandesALivrer = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $commandesALivrer;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d'erreur
        }
    }
    
}

?>
