<!-- src/views/ViewCreationCommande.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Commande</title>
</head>
<body>
    <h1>Créer une nouvelle commande</h1>
    
    <form action="/ProjetMicroservices/index.php?url=Commande/handleCommandeCreation" method="POST">
        <label for="date_livraison">Date de Livraison :</label>
        <input type="datetime-local" id="date_livraison" name="date_livraison" required>
        
        <button type="submit" name="creer">Créer la commande</button>
    </form>
    
</body>
</html>
