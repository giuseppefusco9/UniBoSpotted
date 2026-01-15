-- 1. Creazione del Database
CREATE DATABASE IF NOT EXISTS unibospotted;
USE unibospotted;

-- 2. Tabella Utenti (Gestisce sia Admin che Fruitori)
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Qui salveremo l'hash, non la password in chiaro!
    ruolo ENUM('user', 'admin') DEFAULT 'user',
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
    immagine_path VARCHAR(255) DEFAULT NULL, -- Per l'upload foto (Effetto WOW)
    is_anonymous BOOLEAN DEFAULT FALSE, -- Se TRUE, nel frontend mostri "Anonimo" invece del nome
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
('Affitti');

-- Inserimento Utenti di prova
INSERT INTO utenti (username, email, password, ruolo) VALUES 
('admin_spot', 'admin@unibo.it', 'pass1234', 'admin'),
('studente_curioso', 'mario@studio.unibo.it', 'pass1234', 'user');

-- Inserimento di uno Spot di prova
INSERT INTO post (user_id, categoria_id, testo, is_anonymous) VALUES 
(2, 1, 'Qualcuno ha visto la mia borraccia verde in Sala Studio A?', 0),
(2, 2, 'Spotted ragazzo con la felpa rossa a Ingegneria: sei bellissimo!', 1); -- Questo è anonimo