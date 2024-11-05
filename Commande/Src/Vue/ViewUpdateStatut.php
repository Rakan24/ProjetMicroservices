<!-- src/views/ViewUpdateStatut.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mettre à jour le Statut de la Commande</title>
</head>
<body>
    <h1>Mettre à jour le statut d'une commande</h1>

    <form action="?url=Commande/handleUpdateStatut" method="POST">
        <label for="id_commande">ID de la Commande :</label>
        <input type="number" id="id_commande" name="id_commande" required>

        <label for="nouveau_statut">Nouveau Statut :</label>
        <select id="nouveau_statut" name="nouveau_statut" required>
            <option value="1">En attente</option>
            <option value="2">En préparation</option>
            <option value="3">Terminée</option>
            <option value="4">En livraison</option>
            <option value="5">Livrée</option>
        </select>

        <button type="submit">Mettre à jour le statut</button>
    </form>
</body>
</html>
