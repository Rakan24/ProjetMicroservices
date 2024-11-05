-- Création de la table `statuts`
CREATE TABLE IF NOT EXISTS `statuts` (
  `id_statut` INT(11) NOT NULL AUTO_INCREMENT,
  `nom_statut` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertion des différents statuts
INSERT INTO `statuts` (`nom_statut`) VALUES 
  ('En attente'),
  ('En préparation'),
  ('Terminée'),
  ('En livraison'),
  ('Livrée');

-- Création de la table `commandes`
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` INT(11) NOT NULL AUTO_INCREMENT,
  `id_client` INT(11) NOT NULL,
  `id_restaurant` INT(11) NOT NULL,
  `date_livraison` DATETIME NOT NULL,
  `date_commande` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `id_statut` INT(11) DEFAULT NULL,  -- permet NULL pour la suppression de la référence
  PRIMARY KEY (`id_commande`),

  -- Clé étrangère pour lier `statut_id` à `id_statut` dans la table `statuts`
  CONSTRAINT `fk_statut`
    FOREIGN KEY (`id_statut`) REFERENCES `statuts`(`id_statut`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
