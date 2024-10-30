CREATE TABLE users (
    id SERIAL PRIMARY KEY,    
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
);

CREATE TABLE refresh_token (
    id SERIAL PRIMARY KEY,
    client_id INT REFERENCES client(id) ON DELETE CASCADE,
    token VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL
);

CREATE TABLE role (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR (100)
)