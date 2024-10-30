<?php
include '../config/db.php'; 
include '../models/Livreur.php'; 
include '../models/Livraison.php'; 

class LivraisonController {
    private $livreurModel;
    private $livraisonModel;

    public function __construct($pdo) {
        $this->livreurModel = new Livreur($pdo);
        $this->livraisonModel = new Livraison($pdo);
    }

    public function affecterLivraison($id_livraison) {
        // Récupérer un livreur disponible
        $livreur = $this->livreurModel->getLivreurDispo();

        if ($livreur) {
            $id_livreur = $livreur['id_livreur']; 

            // Affecter la livraison au livreur
            if ($this->livraisonModel->affecterLivraison($id_livraison, $id_livreur)) {
                return ['message' => 'Livraison affectée avec succès au livreur ' . $livreur['nom']];
            } else {
                return ['message' => 'Erreur lors de l\'affectation de la livraison'];
            }
        } else {
            return ['message' => 'Aucun livreur disponible']; // Aucune dispo de livreur
        }
    }
}
?>
