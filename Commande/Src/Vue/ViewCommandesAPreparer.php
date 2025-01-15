<!DOCTYPE html>
<html>
<head>
    <title>Commandes à préparer</title>
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #007bff;
            color: #fff;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #e9f7ff;
        }

        .no-commands {
            text-align: center;
            color: #666;
            margin: 20px 0;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Commandes à préparer par votre restaurant</h1>
    
    <?php if (empty($commandesAPreparer)): ?>
        <p class="no-commands">Aucune commande trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Commande</th>
                    <th>ID Client</th>
                    <th>Date de Livraison</th>
                    <th>Statut</th>
                    <th>Action</th> <!-- Nouvelle colonne pour les actions -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandesAPreparer as $commande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($commande['id_commande']); ?></td>
                        <td><?php echo htmlspecialchars($commande['id_client']); ?></td>
                        <td><?php echo htmlspecialchars($commande['date_livraison']); ?></td>
                        <td>
                            <?php 
                                // Mapping des statuts
                                switch ($commande['id_statut']) {
                                    case 1:
                                        echo "En attente";
                                        break;
                                    case 2:
                                        echo "En préparation";
                                        break;
                                    case 3:
                                        echo "Terminée, en attente de livraison";
                                        break;
                                    default:
                                        echo "Statut inconnu";
                                }
                            ?>
                        </td>
                        <td>
                            <?php if ($commande['id_statut'] == 1): ?>
                                <!-- Bouton Lancer la préparation -->
                                <form method="POST" action="index.php?url=Commande/handleUpdateStatut">
                                    <input type="hidden" name="id_commande" value="<?php echo htmlspecialchars($commande['id_commande']); ?>">
                                    <input type="hidden" name="nouveau_statut" value="2">
                                    <button type="submit">Lancer la préparation</button>
                                </form>
                            <?php elseif ($commande['id_statut'] == 2): ?>
                                <!-- Bouton Terminer la préparation -->
                                <form method="POST" action="index.php?url=Commande/handleUpdateStatut">
                                    <input type="hidden" name="id_commande" value="<?php echo htmlspecialchars($commande['id_commande']); ?>">
                                    <input type="hidden" name="nouveau_statut" value="3">
                                    <button type="submit">Terminer la préparation</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
