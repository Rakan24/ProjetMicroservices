<?php

class CommandeControleur
{
    private $db;
    private $commande;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->commande = new CommandeModele($this->db);
    }

    #-------------------------------------------------------------------------#
    #                        INSERT / UPDATE / DELETE                         #
    #-------------------------------------------------------------------------#

    // Créer une nouvelle commande
    public function creerCommande($data)
    {
        $this->commande->id_client = $data['id_client'];
        $this->commande->date_livraison = $data['date_livraison'] ?? date('Y-m-d H:i:s');

        if ($this->commande->passerCommande()) {
            echo json_encode(["message" => "Commande créée avec succès."]);
        } else {
            echo json_encode(["message" => "Impossible de créer la commande."]);
        }
    }

    // Mettre à jour le statut d'une commande
    public function mettreAJourStatut($data)
    {
        $this->commande->id_commande = $data['id_commande'];
        $this->commande->nouveau_statut = $data['nouveau_statut'];

        if ($this->commande->mettreAJourStatut()) {
            echo json_encode(["message" => "Statut mis à jour avec succès."]);
        } else {
            echo json_encode(["message" => "Impossible de mettre à jour le statut."]);
        }
    }

    // Annuler une commande
    public function annulerCommande($id_commande)
    {
        $this->commande->id_commande = $id_commande;

        if ($this->commande->annulerCommande()) {
            echo json_encode(["message" => "Commande annulée avec succès."]);
        } else {
            echo json_encode(["message" => "Impossible d'annuler la commande."]);
        }
    }

    #-------------------------------------------------------------------------#
    #                           FONCTIONS DE VUES                             #
    #-------------------------------------------------------------------------#

    // Afficher les commandes passées
    public function afficherCommandesPassees($id_client)
    {
        $this->commande->id_client = $id_client;
        $stmt = $this->commande->afficherCommandesPassees();

        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = $row;
        }

        echo json_encode($commandes);
    }

    // Afficher les commandes en cours
    public function afficherCommandesEnCours($id_client)
    {
        $this->commande->id_client = $id_client;
        $stmt = $this->commande->afficherCommandesEnCours();

        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = $row;
        }

        echo json_encode($commandes);
    }

    // Afficher les commandes à préparer
    public function afficherCommandesAPreparer($id_restaurant)
    {
        $this->commande->id_restaurant = $id_restaurant;
        $stmt = $this->commande->afficherCommandesAPreparer();

        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = $row;
        }

        echo json_encode($commandes);
    }

    // Afficher les commandes à livrer
    public function afficherCommandesALivrer($id_livreur)
    {
        $this->commande->id_livreur = $id_livreur;
        $stmt = $this->commande->afficherCommandesALivrer();

        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = $row;
        }

        echo json_encode($commandes);
    }
}


