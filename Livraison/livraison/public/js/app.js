function affecterLivraison() {
    const idLivraison = document.getElementById('id_livraison').value; 
    fetch('routes/api.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_livraison: idLivraison }),
    })
    .then(response => response.json()) 
    .then(data => {
        document.getElementById('message').innerText = data.message; 
    })
    .catch((error) => {
        console.error('Erreur:', error); 
    });
}
