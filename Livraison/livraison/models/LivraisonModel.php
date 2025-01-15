<?php
require_once 'config.php';

class LivraisonModel {
    private $db;

    public function __construct() {
        $this->db = getConnection(); // Connexion à la base
    }

    // Récupérer toutes les livraisons
    public function getAllLivraisons() {
        $query = $this->db->prepare("SELECT * FROM livraisons");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Créer une nouvelle livraison
    public function createLivraison($data) {
        $query = $this->db->prepare("INSERT INTO livraisons (id_commande, id_livreur, date_livraison_estimee) VALUES (:id_commande, :id_livreur, :date_livraison)");
        return $query->execute($data);
    }

    // Mettre à jour une livraison
    public function updateLivraison($id, $data) {
        $query = $this->db->prepare("UPDATE livraisons SET statut_livraison = :statut, position_actuelle = :position WHERE id_livraison = :id");
        return $query->execute(array_merge($data, ['id' => $id]));
    }

    // Récupérer les livreurs disponibles
    public function getLivreursDisponibles() {
        $query = $this->db->prepare("SELECT * FROM livreurs WHERE statut = 'disponible'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
