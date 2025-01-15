<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Service Commandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #333;
        }
        .buttons {
            margin: 20px auto;
            display: flex;
            flex-direction: column; /* Ajoute des sauts de ligne naturels */
            align-items: center;
        }
        .button {
            display: block;
            margin: 10px 0; /* Ajoute un espacement entre les boutons */
            padding: 15px 30px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">

    <?php
    // Démarrer la session pour accéder aux variables
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier si les variables sont bien définies
    echo "ID Client : " . ($_SESSION['id_client'] ?? 'Aucun') . "<br>";
    echo "ID Livreur : " . ($_SESSION['id_livreur'] ?? 'Aucun') . "<br>";
    echo "ID Restaurant : " . ($_SESSION['id_restaurant'] ?? 'Aucun') . "<br>";
    ?>

    <h1>Bienvenue dans le Service Commandes</h1>
    
    <!-- Boutons pour affecter les valeurs aux variables de session -->
    <div class="buttons">
        <!-- Bouton pour affecter l'ID Client -->
        <form action="/ProjetMicroservices/index.php?url=Commande/handleSetSession" method="POST">
            <button type="submit" class="button" name="role" value="client">Définir ID Client</button>
        </form>

        <!-- Bouton pour affecter l'ID Livreur -->
        <form action="/ProjetMicroservices/index.php?url=Commande/handleSetSession" method="POST">
            <button type="submit" class="button" name="role" value="livreur">Définir ID Livreur</button>
        </form>

        <!-- Bouton pour affecter l'ID Restaurant -->
        <form action="/ProjetMicroservices/index.php?url=Commande/handleSetSession" method="POST">
            <button type="submit" class="button" name="role" value="restaurant">Définir ID Restaurant</button>
        </form>

        <!-- Bouton pour affecter l'ID Restaurant -->
        <form action="/ProjetMicroservices/index.php?url=Commande/handleDeleteSession" method="POST">
            <button type="submit" class="button" name="role" value="handleDeleteSession">Détruire session</button>
        </form>
    </div>

    <div class="buttons">
    <!-- Bouton Historique Commandes Passées (visible si id_client existe) -->
    <?php if (isset($_SESSION['id_client']) && $_SESSION['id_client']): ?>
        <a href="http://localhost/ProjetMicroservices/index.php?url=Commande/handleShowCommandesPassees" class="button">Historique Commandes Passées</a>
    <?php endif; ?>

    <!-- Bouton Commandes en Cours (visible si id_client existe) -->
    <?php if (isset($_SESSION['id_client']) && $_SESSION['id_client']): ?>
        <a href="http://localhost/ProjetMicroservices/index.php?url=Commande/handleShowCommandesEnCours" class="button">Commandes en Cours</a>
    <?php endif; ?>

    <!-- Bouton Passer une Commande (visible si id_client existe) -->
    <?php if (isset($_SESSION['id_client']) && $_SESSION['id_client']): ?>
        <a href="http://localhost/ProjetMicroservices/index.php?url=Commande/handleShowFormulaireCommande" class="button">Passer une Commande</a>
    <?php endif; ?>

    <!-- Bouton Commandes à Préparer (visible si id_restaurant existe) -->
    <?php if (isset($_SESSION['id_restaurant']) && $_SESSION['id_restaurant']): ?>
        <a href="http://localhost/ProjetMicroservices/index.php?url=Commande/handleShowCommandesAPreparer" class="button">Commandes à Préparer</a>
    <?php endif; ?>

    <!-- Bouton Commandes à Livrer (visible si id_livreur existe) -->
    <?php if (isset($_SESSION['id_livreur']) && $_SESSION['id_livreur']): ?>
        <a href="http://localhost/ProjetMicroservices/index.php?url=Commande/handleShowCommandesALivrer" class="button">Commandes à Livrer</a>
    <?php endif; ?>
</div>
    
    </div>
</body>
</html>
