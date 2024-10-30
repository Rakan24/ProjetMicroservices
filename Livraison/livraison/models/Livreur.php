<?php
class Livreur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo; 
    }

    public function getLivreurDispo() {
        // récupérer un livreur disponible
        $sql = "SELECT * FROM livreurs WHERE statut = 'disponible' LIMIT 1";
        $stmt = $this->pdo->prepare($sql); 
        $stmt->execute(); 
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
}
?>
