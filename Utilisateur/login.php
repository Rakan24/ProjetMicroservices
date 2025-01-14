<?php
// Vérification si la requête est POST (soumission du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'controllers/AuthController.php';

    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Appel au contrôleur pour effectuer la connexion
    $authController = new AuthController();
    $response = $authController->login([
        'email' => $email,
        'password' => $password,
    ]);

    // Gestion de la réponse
    if ($response['success']) {
        echo "<script>alert('Connexion réussie !');</script>";
        // Redirection ou autre logique après connexion réussie
    } else {
        echo "<script>alert('Erreur : " . $response['message'] . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }
        .login-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 1em;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="email"],
        input[type="password"] {
            margin-bottom: 1em;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
