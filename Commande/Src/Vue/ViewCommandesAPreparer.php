<?php
// src/Vue/ViewCommandesPassees.php
// Vous pouvez ajouter un var_dump pour voir ce qui est passé à la vue.
var_dump($commandesAPreparer); // Pour déboguer
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commandes a préparer par votre retaurant</title>
</head>
<body>
    <h1>Commandes a préparer par votre retaurant</h1>
    
    <?php if (empty($commandesAPreparer)): ?>
        <p>Aucune commande trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>ID Client</th>
                    <th>Date de Livraison</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandesAPreparer as $commande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($commande['id_commande']); ?></td>
                        <td><?php echo htmlspecialchars($commande['id_client']); ?></td>
                        <td><?php echo htmlspecialchars($commande['date_livraison']); ?></td>
                        <td><?php echo htmlspecialchars($commande['id_statut']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
