CREATE DATABASE gs_db;

DROP TABLE IF EXISTS utenti;

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

