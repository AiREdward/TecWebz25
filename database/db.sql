CREATE DATABASE gs_db;

DROP TABLE IF EXISTS prodotti;
DROP TABLE IF EXISTS ordini;
DROP TABLE IF EXISTS ordine_prodotti;
DROP TABLE IF EXISTS pagamenti;
DROP TABLE IF EXISTS utenti;
DROP TABLE IF EXISTS valutazioni;

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
    prezzo_ritiro_usato DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    genere VARCHAR(50) NOT NULL,
    immagine VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO prodotti (nome, prezzo, prezzo_ritiro_usato, genere, immagine, descrizione) VALUES
('The Legend of Adventure', 59.99, 14.19, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/379430/header.jpg', 'Un gioco di avventura epico che ti porterà in un mondo fantastico pieno di misteri, enigmi e battaglie mozzafiato.'),
('Mystic Quest Chronicles', 49.99, 14.19, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/582010/header.jpg', 'Un gioco di ruolo mistico che combina una trama avvincente con un gameplay profondo e strategico. Esplora terre magiche e affronta creature leggendarie.'),
('Space Commander', 39.99, 14.19, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/281990/header.jpg', 'Un gioco di strategia spaziale che ti mette al comando di una flotta interstellare. Pianifica le tue mosse e conquista la galassia.'),
('Dragon Warrior Saga', 54.99, 14.19, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/39210/header.jpg', 'Una saga epica di guerrieri draghi che ti immergerà in un mondo di magia, battaglie e avventure senza fine.'),
('Ninja Combat', 29.99, 14.19, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1174180/header.jpg', 'Un gioco di combattimento ninja che ti farà vivere scontri rapidi e spettacolari. Diventa il maestro delle arti marziali.'),
('Empire Builder 2025', 44.99, 14.19, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/255710/header.jpg', 'Un gioco di costruzione di imperi che ti sfida a creare e gestire una civiltà prospera. Pianifica, costruisci e domina.'),
('Cyberpunk Chronicles', 69.99, 19.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/header.jpg', 'Un gioco ambientato in un futuro distopico. Esplora una città cyberpunk piena di intrighi, missioni pericolose e personaggi memorabili.'),
('Fantasy Kingdoms', 49.99, 15.99, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/39210/header.jpg', 'Un gioco di ruolo ambientato in un regno fantastico. Crea il tuo eroe, esplora terre incantate e affronta nemici potenti in una storia epica.'),
('Galactic Wars', 59.99, 18.99, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/281990/header.jpg', 'Un gioco di strategia spaziale che ti permette di costruire il tuo impero galattico. Conquista pianeti, stringi alleanze e affronta battaglie epiche.'),
('Zombie Apocalypse', 39.99, 12.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/739630/header.jpg', 'Un gioco che ti immerge in un mondo post-apocalittico infestato da zombie. Sopravvivi, raccogli risorse e combatti per la tua vita.'),
('Racing Legends', 34.99, 10.99, 'sport', 'https://cdn.cloudflare.steamstatic.com/steam/apps/244210/header.jpg', 'Un gioco di corse ad alta velocità con auto realistiche e circuiti mozzafiato. Sfida i tuoi amici e diventa una leggenda delle corse.'),
('Medieval Conquest', 49.99, 14.99, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/48700/header.jpg', 'Un gioco di strategia medievale che ti permette di costruire il tuo regno, addestrare eserciti e conquistare territori nemici.'),
('Alien Invasion', 59.99, 17.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/582010/header.jpg', 'Un gioco che ti mette nei panni di un eroe che deve difendere la Terra da una terrificante invasione aliena. Preparati a combattere con armi futuristiche.'),
('Pirate Adventures', 44.99, 13.99, 'avventura', 'https://cdn.cloudflare.steamstatic.com/steam/apps/311340/header.jpg', 'Un gioco di avventura che ti trasporta nei mari caraibici. Diventa un pirata, esplora isole misteriose e cerca tesori nascosti.'),
('Super Soccer Stars', 29.99, 9.99, 'sport', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Un gioco di calcio arcade che combina azione veloce e divertimento. Sfida i tuoi amici e segna gol spettacolari.'),

('Stazione di Gioco 5', 229.99, 149.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente forte, ottime prestazioni e grafica mozzafiato.'),
('Stazione di Gioco 4', 199.99, 129.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente sensazionale, ottime prestazioni e grafica mozzafiato.'),
('Stazione di Gioco 3', 179.99, 119.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella'),
('Scatola ICS A', 349.99, 299.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella'),
('Scatola ICS B', 249.99, 199.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella'),
('Scatola ICS C', 149.99, 99.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella'),

('Carta Regalo 10', 10.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 10 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),
('Carta Regalo 20', 20.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 20 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),
('Carta Regalo 50', 50.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 50 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),
('Carta Regalo 100', 100.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 100 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.');

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
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE CASCADE
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
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS valutazioni (
  nome varchar(20) NOT NULL,
  categoria varchar(20) NOT NULL,
  valore float(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO valutazioni (nome, categoria, valore) VALUES
('buone', 'condizioni', 0.7),
('console', 'tipologia', 300.0),
('controller', 'tipologia', 50.0),
('gioco', 'tipologia', 40.0),
('microsoft', 'marca', 0.5),
('nintendo', 'marca', 0.9),
('ottime', 'condizioni', 1.0),
('scarse', 'condizioni', 0.4),
('sony', 'marca', 0.7);