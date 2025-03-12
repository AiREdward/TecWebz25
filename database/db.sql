CREATE DATABASE gs_db;

DROP TABLE IF EXISTS utenti;
DROP TABLE IF EXISTS prodotti;

CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ruolo ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    stato ENUM('attivo', 'bloccato') NOT NULL DEFAULT 'attivo',
    ultimo_accesso DATETIME NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS prodotti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    prezzo DECIMAL(10, 2) NOT NULL,
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