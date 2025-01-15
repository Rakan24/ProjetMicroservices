<?php
require_once 'controllers/LivraisonController.php';

$controller = new LivraisonController();

// Récupération de la route demandée
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestURI = $_SERVER['REQUEST_URI'];

// Routing simple
if (strpos($requestURI, '/livraisons') !== false && $requestMethod === 'GET') {
    $controller->getAllLivraisons();
} elseif (strpos($requestURI, '/livraison/create') !== false && $requestMethod === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->createLivraison($data);
} elseif (strpos($requestURI, '/livraison/update') !== false && $requestMethod === 'PUT') {
    $id = $_GET['id']; // Exemple: /livraison/update?id=1
    $data = json_decode(file_get_contents('php://input'), true);
    $controller->updateLivraison($id, $data);
} elseif (strpos($requestURI, '/livreurs/disponibles') !== false && $requestMethod === 'GET') {
    $controller->getLivreursDisponibles();
} else {
    echo json_encode(['status' => 404, 'message' => 'Route non trouvée']);
}
?>
