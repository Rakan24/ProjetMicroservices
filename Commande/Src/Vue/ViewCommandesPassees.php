<!DOCTYPE html>
<html>
<head>
    <title>Commandes Passées</title>
</head>
<body>
    <h1>Commandes Passées</h1>
    
    <?php if (empty($commandesPassees)): ?>
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
                <?php foreach ($commandesPassees as $commande): ?>
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
