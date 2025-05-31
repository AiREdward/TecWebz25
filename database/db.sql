CREATE DATABASE gs_db;
USE gs_db;

DROP TABLE IF EXISTS ordine_prodotti;
DROP TABLE IF EXISTS dettaglio_ordine;
DROP TABLE IF EXISTS pagamenti;
DROP TABLE IF EXISTS ordini;
DROP TABLE IF EXISTS valutazioni;
DROP TABLE IF EXISTS prodotti;
DROP TABLE IF EXISTS utenti;

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

-- CARDS

('Carta Regalo 10', 10.00, 0.00, 'carta regalo', 'assets\\img\\products_images\\cards\\CartaRegalo10.svg', 'Carta regalo da 10 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),
('Carta Regalo 20', 20.00, 0.00, 'carta regalo', 'assets\\img\\products_images\\cards\\CartaRegalo20.svg', 'Carta regalo da 20 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),
('Carta Regalo 50', 50.00, 0.00, 'carta regalo', 'assets\\img\\products_images\\cards\\CartaRegalo50.svg', 'Carta regalo da 50 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),
('Carta Regalo 100', 100.00, 0.00, 'carta regalo', 'assets\\img\\products_images\\cards\\CartaRegalo100.svg', 'Carta regalo da 100 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.'),

-- GIOCHI

('Arena dei Campioni', 49.99, 15.99, 'sport', 'assets\\img\\products_images\\games\\Arena_dei_Campioni.png', 'Competi nell\'arena più prestigiosa con atleti di diverse discipline. Dimostra la tua abilità in calcio, pallacanestro e altri sport per diventare il campione assoluto.'),
('Assedio Imperiale', 54.99, 16.99, 'strategia', 'assets\\img\\products_images\\games\\Assedio_Imperiale.png', 'Un gioco di strategia medievale dove dovrai difendere o conquistare castelli in epiche battaglie d\'assedio. Pianifica le tue tattiche e guida le tue truppe alla vittoria.'),
('Battaglia per Roma', 59.99, 17.99, 'strategia', 'assets\\img\\products_images\\games\\Battaglia_per_Roma.png', 'Rivivi le epiche battaglie dell\'antica Roma in questo gioco di strategia storica. Comanda legioni, conquista territori e plasma il destino dell\'Impero Romano.'),
('Fuga dall\'Isola Proibita', 44.99, 13.99, 'avventura', 'assets\\img\\products_images\\games\\Fuga_dall_Isola_Proibita.png', 'Un\'avventura mozzafiato su un\'isola misteriosa piena di pericoli e segreti. Esplora, risolvi enigmi e trova una via di fuga prima che sia troppo tardi.'),
('I Guardiani della Luce', 64.99, 19.99, 'gioco di ruolo', 'assets\\img\\products_images\\games\\I_Guardiani_della_Luce.png', 'Un epico gioco di ruolo fantastico dove un gruppo di eroi deve proteggere il mondo dall\'oscurità. Sviluppa i tuoi personaggi, padroneggia magie potenti e affronta nemici leggendari.'),
('Il Cavaliere del Destino', 59.99, 17.99, 'gioco di ruolo', 'assets\\img\\products_images\\games\\Il_Cavaliere_del_Destino.png', 'Un\'epica avventura medievale dove vestirai i panni di un cavaliere destinato a cambiare il corso della storia. Affronta pericolose missioni, combatti contro nemici leggendari e scopri il tuo vero destino.'),
('Lama d\'Ombra', 49.99, 14.99, 'azione', 'assets\\img\\products_images\\games\\Lama_dOmbra.png', 'Un gioco d\'azione dove interpreterai un assassino che si muove nell\'ombra. Utilizza armi letali e abilità sovrannaturali per eliminare i tuoi bersagli senza essere scoperto.'),
('Maestri del Pallone', 44.99, 13.99, 'sport', 'assets\\img\\products_images\\games\\Maestri_del_Pallone.png', 'Il simulatore di calcio definitivo che ti permette di vivere l\'emozione del calcio professionistico. Crea la tua squadra, allena i giocatori e competi nei tornei più prestigiosi del mondo.'),
('Mistero a Venezia', 39.99, 12.99, 'mistero', 'assets\\img\\products_images\\games\\Mistero_a_Venezia.png', 'Un\'avventura investigativa ambientata nella misteriosa Venezia del XVIII secolo. Risolvi enigmi, interroga sospetti e scopri i segreti nascosti tra i canali della città più affascinante del mondo.'),
('Operazione Drago Rosso', 54.99, 16.99, 'azione', 'assets\\img\\products_images\\games\\Operazione_Drago_Rosso.png', 'Un intenso sparatutto in prima persona che ti catapulta in una pericolosa missione militare. Infiltrati nelle linee nemiche, elimina i bersagli e completa gli obiettivi per salvare il mondo da una minaccia globale.'),

-- CONSOLE
('Piattaforma Portatile Avventura', 199.99, 99.99, 'piattaforma', 'assets\\img\\products_images\\console\\Avventura.png', 'Piattaforma portatile di ultima generazione con schermo ad alta definizione, controlli intuitivi e una vasta libreria di giochi. Perfetta per giocare ovunque tu sia.'),
('Piattaforma Retro Ludica', 89.99, 39.99, 'piattaforma', 'assets\\img\\products_images\\console\\Ludica.png', 'Piattaforma che riporta in vita i classici giochi antecedenti all\'anno 2000. Pulsantiera colorata e centinaia di giochi preinstallati per rivivere l\'epoca d\'oro dei giochi più antichi.'),
('Piattaforma Potenza', 449.99, 249.99, 'piattaforma', 'assets\\img\\products_images\\console\\Potenza.png', 'La piattaforma più potente sul mercato con una nuova grafica interattiva, tempi di caricamento istantanei e supporto per le tecnologie più avanzate. L\'esperienza di gioco definitiva per i veri appassionati.');


CREATE TABLE IF NOT EXISTS ordini (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT NOT NULL,
    totale DECIMAL(10, 2) NOT NULL,
    stato ENUM('in attesa', 'completato', 'annullato') NOT NULL DEFAULT 'in attesa',
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_aggiornamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE
);

INSERT INTO ordini (utente_id, totale, stato) VALUES
(2, 149.97, 'completato'),
(2, 54.99, 'in attesa'),
(3, 299.98, 'annullato'),
(2, 449.99, 'completato'),
(3, 199.99, 'in attesa'),
(2, 89.99, 'completato'),
(2, 159.98, 'completato'),
(3, 64.99, 'annullato'),
(2, 399.98, 'in attesa'),
(3, 129.98, 'completato');

CREATE TABLE IF NOT EXISTS dettaglio_ordine (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordine_id INT NOT NULL,
    prodotto_id INT NOT NULL,
    quantita INT NOT NULL,
    prezzo_unitario DECIMAL(10, 2) NOT NULL,
    data_creazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE,
    FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE CASCADE
);

INSERT INTO dettaglio_ordine (ordine_id, prodotto_id, quantita, prezzo_unitario) VALUES
(1, 5, 2, 64.99),
(1, 10, 1, 54.99),
(2, 6, 1, 54.99),
(3, 12, 2, 149.99),
(4, 13, 1, 449.99),
(5, 11, 1, 199.99),
(6, 12, 1, 89.99),
(7, 7, 2, 79.99),
(8, 9, 1, 64.99),
(9, 8, 2, 199.99);

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

INSERT INTO pagamenti (ordine_id, intestatario, numero_carta, data_scadenza, cvv, stato) VALUES
(1, 'Stephan El Shaarawy', '4532123456789012', '12/25', '123', 'completato'),
(2, 'Lele Adani', '4532123456789012', '12/25', '123', 'completato'),
(3, 'Mario Gotze', '5412345678901234', '03/24', '456', 'completato'),
(4, 'Robert Lewandowski', '4532123456789012', '12/25', '123', 'completato'),
(5, 'Lionel Messi', '4556789012345678', '06/24', '789', 'completato'),
(6, 'Giuseppe Bergomi', '5167890123456789', '09/25', '234', 'completato'),
(7, 'Fabio Caressa', '4532123456789012', '12/25', '123', 'completato'),
(8, 'Raffaele Palladino', '5412345678901234', '03/24', '456', 'completato'),
(9, 'Vincenzo Italiano', '4123456789012345', '04/26', '567', 'completato'),
(10, 'Antonio Conte', '5234567890123456', '08/25', '890', 'completato');

CREATE TABLE IF NOT EXISTS valutazioni (
  nome varchar(20) NOT NULL PRIMARY KEY,
  categoria varchar(20) NOT NULL,
  valore float(6,2) NOT NULL
);

INSERT INTO valutazioni (nome, categoria, valore) VALUES
('piattaforma', 'tipologia', 300.0),
('pulsantiera', 'tipologia', 50.0),
('gioco', 'tipologia', 40.0),
('ottime', 'condizioni', 0.9),
('buone', 'condizioni', 0.7),
('scarse', 'condizioni', 0.4),
('ludica', 'marca', 0.5),
('potenza', 'marca', 0.9),
('avventura', 'marca', 0.7);