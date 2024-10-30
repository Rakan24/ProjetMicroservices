<?php
class Plat
{
    private $conn;
    private $table = 'plat';

    public $id;
    public $nom;
    public $description;
    public $prix;
    public $disponible;
    public $idRestaurant;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Créer un nouveau plat
    public function creerPlat()
    {
        $query = "INSERT INTO " . $this->table . " (nom, description, prix, disponible, restaurant_id) VALUES (:nom, :description, :prix, :disponible, :id_restaurant)";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->disponible = htmlspecialchars(strip_tags($this->disponible));
        $this->idRestaurant = htmlspecialchars(strip_tags($this->idRestaurant));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':disponible', $this->disponible);
        $stmt->bindParam(':id_restaurant', $this->idRestaurant);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Mettre à jour un plat
    public function mettreAJourPlat()
    {
        $query = "UPDATE " . $this->table . " SET nom = :nom, description = :description, prix = :prix, disponible = :disponible WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->disponible = htmlspecialchars(strip_tags($this->disponible));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->bindParam(':disponible', $this->disponible);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Supprimer Plat
    public function supprimerPlat()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //lire les plats
    public function lirePlats()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //lire un plat
    public function lireUnPlat()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        return $stmt;
    }
}
