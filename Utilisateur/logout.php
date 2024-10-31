<?php
require_once 'Service/database.php';

// Récupérer les données JSON envoyées dans la requête POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier que le refresh token est bien fourni
if (!isset($data['refreshToken'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Le refresh token est requis pour la déconnexion.']);
    exit();
}

$refreshToken = $data['refreshToken'];

try {
    // Connexion à la base de données
    $db = Database::getInstance();

    // Supprimer le refresh token de la table
    $stmt = $db->prepare("DELETE FROM refresh_token WHERE token = ?");
    $stmt->execute([$refreshToken]);

    // Vérifier si le token a été supprimé
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Déconnexion réussie.']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Le refresh token est invalide ou déjà révoqué.']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la déconnexion : ' . $e->getMessage()]);
}
