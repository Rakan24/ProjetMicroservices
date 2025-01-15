document.addEventListener('DOMContentLoaded', () => {
    const livraisonTable = document.getElementById('livraisonsTable');
    const livreursTable = document.getElementById('livreursTable');

    // Charger les livraisons via une API
    if (livraisonTable) {
        fetch('/livraisons')
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    data.data.forEach(livraison => {
                        const row = `
                            <tr>
                                <td>${livraison.id_livraison}</td>
                                <td>${livraison.id_commande}</td>
                                <td>${livraison.id_livreur}</td>
                                <td>${livraison.statut_livraison}</td>
                                <td>${livraison.position_actuelle || 'N/A'}</td>
                                <td>${livraison.date_livraison_estimee || 'N/A'}</td>
                            </tr>
                        `;
                        livraisonTable.innerHTML += row;
                    });
                }
            })
            .catch(err => console.error('Erreur de chargement des livraisons :', err));
    }

    // Charger les livreurs disponibles
    if (livreursTable) {
        fetch('/livreurs/disponibles')
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    data.data.forEach(livreur => {
                        const row = `
                            <tr>
                                <td>${livreur.id_livreur}</td>
                                <td>${livreur.nom}</td>
                                <td>${livreur.telephone}</td>
                                <td>${livreur.statut}</td>
                            </tr>
                        `;
                        livreursTable.innerHTML += row;
                    });
                }
            })
            .catch(err => console.error('Erreur de chargement des livreurs :', err));
    }
});
