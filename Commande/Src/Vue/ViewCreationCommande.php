<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .container {
            text-align: center;
            margin-top: 40px;
        }
    </style>
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
