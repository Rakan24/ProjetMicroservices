<?php


class PlatController
{
    private $db;
    private $plat;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->plat = new Plat($this->db);
    }

    // Créer un nouveau plat
    public function creerPlat($data)
    {
        $this->plat->nom = $data['nom'];
        $this->plat->description = $data['description'];
        $this->plat->prix = $data['prix'];
        $this->plat->disponible = isset($data['disponible']) ? $data['disponible'] : 1;
        $this->plat->idRestaurant = $data['idRestaurant'];

        if ($this->plat->creerPlat()) {
            echo json_encode(["message" => "Le plat a été créé avec succès."]);
        } else {
            echo json_encode(["message" => "Impossible de créer le plat."]);
        }
    }

    // Mettre à jour un plat
    public function mettreAJourPlat($id, $data)
    {
        $this->plat->id = $id;
        $this->plat->nom = $data['nom'];
        $this->plat->description = $data['description'];
        $this->plat->prix = $data['prix'];
        $this->plat->disponible = isset($data['disponible']) ? $data['disponible'] : 1; // Valeur par défaut 1 (disponible)

        if ($this->plat->mettreAJourPlat()) {
            echo json_encode(["message" => "Le plat a été mis à jour avec succès."]);
        } else {
            echo json_encode(["message" => "Impossible de mettre à jour le plat."]);
        }
    }

    //Supprimer le plat
    public function supprimerPlat($id)
    {
        $this->plat->id = $id;
        if ($this->plat->supprimerPlat()) {
            echo json_encode(["message" => "Le plat a été supprimer."]);
        } else {
            echo json_encode(["message" => "Impossible de supprimer le plat."]);
        }
    }

    // Lire tous les plats
    public function lirePlats()
    {
        $stmt = $this->plat->lirePlats();
        $plats = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plats[] = $row;
        }

        echo json_encode($plats);
    }

    //lire un plat
    public function lireUnPlat($id)
    {
        $this->plat->id = $id;
        $stmt = $this->plat->lireUnPlat();
        $plat = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plat[] = $row;
        }

        echo json_encode($plat);
    }

    //afficher tous les plats d'un restaurant
    public function LireToutLesPlatUnRestaurant($idRestaurant)
    {
        $this->plat->idRestaurant = $idRestaurant;
        $stmt = $this->plat->LireToutLesPlatUnRestaurant();
        $plat = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $plat[] = $row;
        }

        echo json_encode($plat);
    }
}
