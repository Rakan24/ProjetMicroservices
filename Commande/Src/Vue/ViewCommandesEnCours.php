<!DOCTYPE html>
<html>
<head>
    <title>Commandes en cours</title>
</head>
<body>
    <h1>Commandes en cours</h1>
    
    <?php if (empty($commandesEnCours)): ?>
        <p>Aucune commande en cours trouvée.</p>
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
                <?php foreach ($commandesEnCours as $commande): ?>
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
