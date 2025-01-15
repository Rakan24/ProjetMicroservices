<?php
require_once '../models/LivraisonModel.php';

class LivraisonController {
    private $livraisonModel;

    public function __construct() {
        $this->livraisonModel = new LivraisonModel();
    }

    // Récupérer toutes les livraisons
    public function getAllLivraisons() {
        $livraisons = $this->livraisonModel->getAllLivraisons();
        echo json_encode(['status' => 200, 'data' => $livraisons]);
    }

    // Créer une livraison
    public function createLivraison($data) {
        if ($this->livraisonModel->createLivraison($data)) {
            echo json_encode(['status' => 201, 'message' => 'Livraison créée avec succès']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Erreur lors de la création']);
        }
    }

    // Mettre à jour une livraison
    public function updateLivraison($id, $data) {
        if ($this->livraisonModel->updateLivraison($id, $data)) {
            echo json_encode(['status' => 200, 'message' => 'Mise à jour réussie']);
        } else {
            echo json_encode(['status' => 500, 'message' => 'Erreur lors de la mise à jour']);
        }
    }

    // Récupérer les livreurs disponibles
    public function getLivreursDisponibles() {
        $livreurs = $this->livraisonModel->getLivreursDisponibles();
        echo json_encode(['status' => 200, 'data' => $livreurs]);
    }
}
