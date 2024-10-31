<?php
require_once 'controllers/AuthController.php';

$data = json_decode(file_get_contents('php://input'), true);
$authController = new AuthController();
$authController->register($data);
