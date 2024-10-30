<?php
// routes/api.php - API pour gérer les livraisons
include '../controllers/LivraisonController.php'; // Inclure le contrôleur de livraison

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input")); // Récupérer les données JSON
    $id_livraison = $data->id_livraison; // Extraire l'ID de la livraison

    // Instancier le contrôleur de livraison et affecter la livraison
    $controller = new LivraisonController($GLOBALS['pdo']);
    $response = $controller->affecterLivraison($id_livraison);
    
    echo json_encode($response); // Retourner la réponse au format JSON
}
?>
