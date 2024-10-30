-- Création de la table client avec quelques informations supplémentaires
CREATE TABLE client (
    id SERIAL PRIMARY KEY,                     -- Identifiant unique du client
    email VARCHAR(255) NOT NULL UNIQUE,        -- Adresse email unique du client
    password_hash VARCHAR(255) NOT NULL,       -- Hachage du mot de passe du client
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date de création du compte
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Date de dernière mise à jour
    first_name VARCHAR(100),                   -- Prénom du client
    last_name VARCHAR(100),                    -- Nom du client
    phone VARCHAR(20),                         -- Numéro de téléphone du client
    is_active BOOLEAN DEFAULT TRUE             -- Statut actif/inactif du compte
);

-- Création de la table refresh_token
CREATE TABLE refresh_token (
    id SERIAL PRIMARY KEY,                     -- Identifiant unique du token
    client_id INT REFERENCES client(id) ON DELETE CASCADE,  -- Référence vers le client
    token VARCHAR(255) NOT NULL,               -- Token (ou hachage du token pour sécurité)
    expires_at TIMESTAMP NOT NULL              -- Date d'expiration du token
);
