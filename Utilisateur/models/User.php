<?php

require_once 'Service/database.php';

class User {
    private $id;
    private $email;
    private $passwordHash;
    private $role;
    private $firstName;
    private $lastName;

    public function __construct($email, $passwordHash, $role, $firstName, $lastName) {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    // Méthode pour sauvegarder un nouvel utilisateur en base de données
    public function save() {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO user (email, password_hash, first_name, last_name) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->email, $this->passwordHash, $this->firstName, $this->lastName]);
    }

    // Autres méthodes statiques pour des opérations courantes comme la récupération d’un utilisateur
    public static function findByEmail($email) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
