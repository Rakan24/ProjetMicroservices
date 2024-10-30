<?php
class Livraison {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; 
    }

    public function affecterLivraison($id_livraison, $id_livreur) {
        // maj le livreur et le statut de la livraison
        $sql = "UPDATE livraisons SET id_livreur = ?, statut_livraison = 'en cours' WHERE id_livraison = ?";
        $stmt = $this->pdo->prepare($sql); 
        return $stmt->execute([$id_livreur, $id_livraison]); 
    }
}
?>
