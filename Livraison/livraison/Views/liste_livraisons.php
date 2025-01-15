<!DOCTYPE html>
<html>
<head>
    <title>Liste des Livraisons</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des Livraisons</h1>
    <table>
        <thead>
            <tr>
                <th>ID Livraison</th>
                <th>ID Commande</th>
                <th>ID Livreur</th>
                <th>Statut</th>
                <th>Position Actuelle</th>
                <th>Date Estimée</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../controllers/LivraisonController.php';
            $controller = new LivraisonController();
            $livraisons = json_decode($controller->getAllLivraisons(), true)['data'];

            foreach ($livraisons as $livraison) {
                echo "<tr>
                    <td>{$livraison['id_livraison']}</td>
                    <td>{$livraison['id_commande']}</td>
                    <td>{$livraison['id_livreur']}</td>
                    <td>{$livraison['statut_livraison']}</td>
                    <td>{$livraison['position_actuelle']}</td>
                    <td>{$livraison['date_livraison_estimee']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
