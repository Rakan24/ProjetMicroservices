<?php

class CommandeModele
{

    private $conn;
    private $table = 'commandes';

    public $id_commande;
    public $id_client;
    public $date_livraison;
    public $date_commande;
    public $id_satut;
    public $id_restaurant;
    public $id_livreur;

    public function __construct($db)
    {
        $this->conn = $db;
    }




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

    // Créer une nouvelle commande
    public function creerCommande()
    {
        $query = "INSERT INTO " . $this->table . " (id_client, date_livraison, id_statut, id_restaurant, id_livreur) 
                  VALUES (:id_client, :date_livraison, :id_statut, :id_restaurant, :id_livreur)";

        $stmt = $this->conn->prepare($query);

        // Sécurisation des données
        $this->id_client = htmlspecialchars(strip_tags($this->id_client));
        $this->date_livraison = htmlspecialchars(strip_tags($this->date_livraison));
        $this->id_satut = htmlspecialchars(strip_tags($this->id_satut));
        $this->id_restaurant = htmlspecialchars(strip_tags($this->id_restaurant));
        $this->id_livreur = htmlspecialchars(strip_tags($this->id_livreur));

        // Liaison des paramètres
        $stmt->bindParam(':id_client', $this->id_client);
        $stmt->bindParam(':date_livraison', $this->date_livraison);
        $stmt->bindValue(':id_statut', self::STATUT_EN_ATTENTE, PDO::PARAM_INT); // Utilisation de la constante
        $stmt->bindParam(':id_restaurant', $this->id_restaurant);
        $stmt->bindParam(':id_livreur', $this->id_livreur);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function mettreAJourStatut()
    {
        $query = "UPDATE " . $this->table . " SET id_statut = :id_statut WHERE id_commande = :id_commande";
    
        $stmt = $this->conn->prepare($query);
    
        // Sécurisation des données
        $this->id_commande = htmlspecialchars(strip_tags($this->id_commande));
        $this->id_statut = htmlspecialchars(strip_tags($this->id_statut));
    
        // Liaison des paramètres
        $stmt->bindParam(':id_statut', $this->id_statut, PDO::PARAM_INT);
        $stmt->bindParam(':id_commande', $this->id_commande, PDO::PARAM_INT);
    
        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function annulerCommande()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_commande = :id_commande";
    
        $stmt = $this->conn->prepare($query);
    
        // Sécurisation des données
        $this->id_commande = htmlspecialchars(strip_tags($this->id_commande));
    
        // Liaison des paramètres
        $stmt->bindParam(':id_commande', $this->id_commande, PDO::PARAM_INT);
    
        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    #-------------------------------------------------------------------------#
    #                           FONCTIONS DE VUES                             #
    #-------------------------------------------------------------------------#

    public function afficherCommandesPassees()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_client = :id_client AND id_statut = :id_statut";
        $stmt = $this->conn->prepare($query);
    
        // Sécurisation des données
        $this->id_client = htmlspecialchars(strip_tags($this->id_client));
    
        // Liaison des paramètres
        $stmt->bindParam(':id_client', $this->id_client, PDO::PARAM_INT);
        $stmt->bindValue(':id_statut', self::STATUT_LIVREE, PDO::PARAM_INT); // Utilisation de la constante
    
        // Exécution de la requête
        $stmt->execute();
    
        // Retourne le statement pour que l'appelant puisse récupérer les données
        return $stmt;
    }

    public function afficherCommandesEnCours()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_client = :id_client AND id_statut <> :id_statut";
        $stmt = $this->conn->prepare($query);
    
        // Sécurisation des données
        $this->id_client = htmlspecialchars(strip_tags($this->id_client));
    
        // Liaison des paramètres
        $stmt->bindParam(':id_client', $this->id_client, PDO::PARAM_INT);
        $stmt->bindValue(':id_statut', self::STATUT_LIVREE, PDO::PARAM_INT); // Utilisation de la constante
    
        // Exécution de la requête
        $stmt->execute();
    
        // Retourne le statement pour que l'appelant puisse récupérer les données
        return $stmt;
    }

    public function afficherCommandesAPreparer()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_restaurant = :id_restaurant AND (id_statut = :statut_en_attente OR id_statut = :statut_en_preparation OR id_statut = :statut_terminee)";
        $stmt = $this->conn->prepare($query);
    
        // Sécurisation des données
        $this->id_restaurant = htmlspecialchars(strip_tags($this->id_restaurant));
    
        // Liaison des paramètres
        $stmt->bindParam(':id_restaurant', $this->id_restaurant, PDO::PARAM_INT);
        $stmt->bindValue(':statut_en_attente', self::STATUT_EN_ATTENTE, PDO::PARAM_INT);
        $stmt->bindValue(':statut_en_preparation', self::STATUT_EN_PREPARATION, PDO::PARAM_INT);
        $stmt->bindValue(':statut_terminee', self::STATUT_TERMINEE, PDO::PARAM_INT);
    
        // Exécution de la requête
        $stmt->execute();
    
        // Retourne le statement pour que l'appelant puisse récupérer les données
        return $stmt;
    }

    public function afficherCommandesALivrer()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id_statut = :statut_terminee OR (id_statut = :statut_en_livraison AND id_livreur = :id_livreur)";
        $stmt = $this->conn->prepare($query);
    
        // Sécurisation des données
        $this->id_livreur = htmlspecialchars(strip_tags($this->id_livreur));
    
        // Liaison des paramètres
        $stmt->bindValue(':statut_terminee', self::STATUT_TERMINEE, PDO::PARAM_INT);
        $stmt->bindValue(':statut_en_livraison', self::STATUT_EN_LIVRAISON, PDO::PARAM_INT);
        $stmt->bindParam(':id_livreur', $this->id_livreur, PDO::PARAM_INT);
    
        // Exécution de la requête
        $stmt->execute();
    
        // Retourne le statement pour que l'appelant puisse récupérer les données
        return $stmt;
    }
    
}

?>
