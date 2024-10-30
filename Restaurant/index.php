<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'src/controller/platController.php';
include_once 'src/controller/restaurantController.php';
include_once 'src/modele/Plat.php';
include_once 'src/modele/Restaurant.php';
include_once 'src/config/database.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$platController = new PlatController();
$restaurantController = new RestaurantController();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    if (preg_match("/^\/Restaurant\/plats$/", $requestUri)) {
        // Créer un plat
        $data = json_decode(file_get_contents("php://input"), true);
        $platController->creerPlat($data);
    }
    if (preg_match("/^\/Restaurant\/restaurant$/", $requestUri)) {
        // Créer un restaurant
        $data = json_decode(file_get_contents("php://input"), true);
        $restaurantController->creerRestaurant($data);
    }
} elseif ($method == 'PUT') {
    // Mettre à jour un plat
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true);
        $platController->mettreAJourPlat($id, $data);
    } else {
        echo json_encode(["message" => "ID du plat non spécifié."]);
    }
} elseif ($method == 'DELETE') {
    // Supprimer un plat
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $platController->supprimerPlat($id);
    } else {
        echo json_encode(["message" => "ID du plat non spécifié."]);
    }
} elseif ($method == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $platController->lireUnPlat($id);
    } else {
        // Lire tous les plats
        $platController->lirePlats();
    }
} else {
    echo json_encode(["message" => "Méthode non autorisée."]);
}
