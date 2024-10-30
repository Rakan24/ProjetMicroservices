<?php
class RestaurantController
{
    private $db;
    private $restaurant;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->restaurant = new Restaurant($this->db);
    }

    // Créer un nouveau Restaurant
    public function creerRestaurant($data)
    {
        $this->restaurant->nom = $data['nom'];
        $this->restaurant->adresse = $data['adresse'];
        $this->restaurant->cp = $data['cp'];
        $this->restaurant->ville = $data['ville'];
        $this->restaurant->idType = $data['idType'];

        if ($this->restaurant->creerRestaurant()) {
            echo json_encode(["message" => "Le Restaurant a été créé avec succès."]);
        } else {
            echo json_encode(["message" => "Impossible de créer le Restaurant."]);
        }
    }
}
