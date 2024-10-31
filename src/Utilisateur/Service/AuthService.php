<?php
require_once 'models/User.php';
require_once 'database.php';

class AuthService {
    public function register($email, $password, $role, $firstName, $lastName) {
        // Vérifier si l'utilisateur existe déjà
        if (User::findByEmail($email)) {
            return ['error' => "L'utilisateur existe déjà."];
        }

        // Hacher le mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        // Créer et sauvegarder l'utilisateur
        $user = new User($email, $passwordHash, $role, $firstName, $lastName);
        $user->save();

        return ['success' => 'Utilisateur créé avec succès'];
    }

    public function login($email, $password) {
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return ['error' => 'Identifiants incorrects'];
        }

        // Générer un token JWT (token d'accès)
        $accessToken = $this->generateJWT($user['id']);

        // Générer et enregistrer un refresh token
        $refreshToken = $this->generateAndStoreRefreshToken($user['id']);

        // Retourner le token d'accès et le refresh token
        return [
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken
        ];
    }

    private function generateJWT($userId) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'userId' => $userId,
            'iat' => time(),
            'exp' => time() + (15 * 60) // Expire dans 15 minutes
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET_KEY, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    private function generateAndStoreRefreshToken($userId) {
        $refreshToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        try {
            $db = Database::getInstance();

            $stmt = $db->prepare("INSERT INTO refresh_token (user_id, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $refreshToken, $expiresAt]);

            return $refreshToken;

        } catch (PDOException $e) {
            // Gestion d'erreur en cas de problème d'insertion
            error_log("Erreur lors de l'insertion du refresh token : " . $e->getMessage());
            return null;
        }
    }
}
