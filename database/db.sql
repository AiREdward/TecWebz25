CREATE DATABASE gs_db;

DROP TABLE IF EXISTS prodotti;
DROP TABLE IF EXISTS utenti;
DROP TABLE IF EXISTS ordini;
DROP TABLE IF EXISTS ordine_prodotti;
DROP TABLE IF EXISTS pagamenti;

CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ruolo ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    stato ENUM('attivo', 'bloccato') NOT NULL DEFAULT 'attivo',
    ultimo_accesso DATETIME NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO utenti (username, email, password, ruolo, stato) 
VALUES 
    ('admin', 'admin@test', '$2y$10$DtD/uFtUSUPSznqliAdVgeX7tflJ62PgUqVvR7tVf1cRkoeERuC3K', 'admin', 'attivo'),
    ('user', 'user@test', '$2y$10$qSb11LcmGJXjeDLafimZ1usUsGbs9qsJVxzpea/wi3THeDb0pICoa', 'user', 'attivo'),
    ('block', 'block@test', '$2y$10$nx0vjdmO/U8dPT0cWS6M5OydWpdwOcTpRUwlaWCphyF57uzjvUUsS', 'user', 'bloccato');

CREATE TABLE IF NOT EXISTS prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
    prezzo_ritiro_usato DECIMAL(10, 2) NOT NULL,
    genere VARCHAR(50) NOT NULL,
    immagine VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL
);

INSERT INTO prodotti (nome, prezzo, genere, immagine, descrizione) VALUES
('The Legend of Adventure', 59.99, 'azione', 'https://i.ytimg.com/vi/KL9oYw5tRVs/maxresdefault.jpg', 'Un gioco di avventura epico.'),
('Mystic Quest Chronicles', 49.99, 'rpg', 'https://i.ytimg.com/vi/KL9oYw5tRVs/maxresdefault.jpg', 'Un gioco di ruolo mistico.'),
('Space Commander', 39.99, 'strategia', 'https://i.ytimg.com/vi/KL9oYw5tRVs/maxresdefault.jpg', 'Un gioco di strategia spaziale.'),
('Dragon Warrior Saga', 54.99, 'rpg', 'https://i.ytimg.com/vi/KL9oYw5tRVs/maxresdefault.jpg', 'Una saga di guerrieri draghi.'),
('Ninja Combat', 29.99, 'azione', 'https://i.ytimg.com/vi/KL9oYw5tRVs/maxresdefault.jpg', 'Un gioco di combattimento ninja.'),
('Empire Builder 2025', 44.99, 'strategia', 'https://i.ytimg.com/vi/KL9oYw5tRVs/maxresdefault.jpg', 'Un gioco di costruzione di imperi.');

CREATE TABLE IF NOT EXISTS ordini (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT NOT NULL,
    totale DECIMAL(10, 2) NOT NULL,
    stato ENUM('in attesa', 'completato', 'annullato') NOT NULL DEFAULT 'in attesa',
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_aggiornamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ordine_prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordine_id INT NOT NULL,
    prodotto_id INT NOT NULL,
    quantita INT NOT NULL,
    prezzo_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS pagamenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordine_id INT NOT NULL,
    intestatario VARCHAR(255) NOT NULL,
    numero_carta VARCHAR(19) NOT NULL, 
    data_scadenza VARCHAR(5) NOT NULL, 
    cvv VARCHAR(4) NOT NULL, 
    stato ENUM('in attesa', 'completato', 'fallito') NOT NULL DEFAULT 'in attesa',
    data_pagamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE
);
