-- 1. Creazione del Database
CREATE DATABASE IF NOT EXISTS unibospotted;
USE unibospotted;

-- 2. Tabella Utenti (Gestisce sia Admin che Fruitori)
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    admin BOOLEAN DEFAULT FALSE, -- TRUE = Admin, FALSE = Utente
    data_registrazione DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabella Categorie (Per i filtri: Biblioteca, Mensa, ecc.)
CREATE TABLE categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- 4. Tabella Post (Gli "Spot")
CREATE TABLE post (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    categoria_id INT NOT NULL,
    testo TEXT NOT NULL,
    immagine_path VARCHAR(255) DEFAULT NULL,
    data_pubblicazione DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utenti(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorie(id)
);

-- 5. Tabella Commenti (Opzionale ma utile per interazione)
CREATE TABLE commenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    testo VARCHAR(500) NOT NULL,
    data_commento DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES utenti(id) ON DELETE CASCADE
);

-- ==========================================
-- DATI DI ESEMPIO (Per partire subito)
-- ==========================================

-- Inserimento Categorie Default
INSERT INTO categorie (nome) VALUES 
('Biblioteca'), 
('Mensa'), 
('Aule Studio'), 
('Feste e Eventi'), 
('Oggetti Smarriti'),
('Esami'),
('Affitti'),
('Altro');

/* CREDENZIALI ADMIN: Username: Admin Password: admin*/

/* CREDENZIALI USERS:
User: MarcoRossi / Pass: admin
User: GiuliaB / Pass: admin
User: LucaNerd / Pass: admin
**/