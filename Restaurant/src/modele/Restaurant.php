<?php
class Restaurant
{
    private $conn;
    private $table = 'restaurant';

    public $id;
    public $nom;
    public $adresse;
    public $cp;
    public $ville;
    public $idType;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Créer un nouveau restaurant
    public function creerRestaurant()
    {
        $query = "INSERT INTO " . $this->table . " (nom, adresse, cp, ville, type_id) VALUES (:nom, :adresse, :cp, :ville, :id_type)";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->adresse = htmlspecialchars(strip_tags($this->adresse));
        $this->cp = htmlspecialchars(strip_tags($this->cp));
        $this->ville = htmlspecialchars(strip_tags($this->ville));
        $this->idType = htmlspecialchars(strip_tags($this->idType));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':cp', $this->cp);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':id_type', $this->idType);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
