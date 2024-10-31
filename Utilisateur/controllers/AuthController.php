<?php
require_once 'Service/AuthService.php';

class AuthController {
    private $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function register($data) {
        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];
        $firstName = $data['first_name'];
        $lastName = $data['last_name'];

        $result = $this->authService->register($email, $password, $role, $firstName, $lastName);

        echo json_encode($result);
    }

    public function login($data) {
        $email = $data['email'];
        $password = $data['password'];

        $result = $this->authService->login($email, $password);

        echo json_encode($result);
    }
}
