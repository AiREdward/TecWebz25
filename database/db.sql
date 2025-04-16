-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 08, 2025 at 12:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ordine_prodotti`
--

CREATE TABLE `ordine_prodotti` (
  `id` int(11) NOT NULL,
  `ordine_id` int(11) NOT NULL,
  `prodotto_id` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  `prezzo_unitario` decimal(10,2) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordini`
--

CREATE TABLE `ordini` (
  `id` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `totale` decimal(10,2) NOT NULL,
  `stato` enum('in attesa','completato','annullato') NOT NULL DEFAULT 'in attesa',
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_aggiornamento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagamenti`
--

CREATE TABLE `pagamenti` (
  `id` int(11) NOT NULL,
  `ordine_id` int(11) NOT NULL,
  `intestatario` varchar(255) NOT NULL,
  `numero_carta` varchar(19) NOT NULL,
  `data_scadenza` varchar(5) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `stato` enum('in attesa','completato','fallito') NOT NULL DEFAULT 'in attesa',
  `data_pagamento` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodotti`
--

CREATE TABLE `prodotti` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `prezzo_ritiro_usato` decimal(10,2) NOT NULL DEFAULT 0.00,
  `genere` varchar(50) NOT NULL,
  `immagine` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodotti`
--

INSERT INTO `prodotti` (`id`, `nome`, `prezzo`, `prezzo_ritiro_usato`, `genere`, `immagine`, `descrizione`, `data_creazione`) VALUES

-- OLD

-- (1, 'The Legend of Adventure', 59.99, 14.19, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/379430/header.jpg', 'Un gioco di avventura epico che ti porterà in un mondo fantastico pieno di misteri, enigmi e battaglie mozzafiato.', '2025-04-07 21:39:56'),
-- (2, 'Mystic Quest Chronicles', 49.99, 14.19, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/582010/header.jpg', 'Un gioco di ruolo mistico che combina una trama avvincente con un gameplay profondo e strategico. Esplora terre magiche e affronta creature leggendarie.', '2025-04-07 21:39:56'),
-- (3, 'Space Commander', 39.99, 14.19, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/281990/header.jpg', 'Un gioco di strategia spaziale che ti mette al comando di una flotta interstellare. Pianifica le tue mosse e conquista la galassia.', '2025-04-07 21:39:56'),
-- (4, 'Dragon Warrior Saga', 54.99, 14.19, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/39210/header.jpg', 'Una saga epica di guerrieri draghi che ti immergerà in un mondo di magia, battaglie e avventure senza fine.', '2025-04-07 21:39:56'),
-- (5, 'Ninja Combat', 29.99, 14.19, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1174180/header.jpg', 'Un gioco di combattimento ninja che ti farà vivere scontri rapidi e spettacolari. Diventa il maestro delle arti marziali.', '2025-04-07 21:39:56'),
-- (6, 'Empire Builder 2025', 44.99, 14.19, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/255710/header.jpg', 'Un gioco di costruzione di imperi che ti sfida a creare e gestire una civiltà prospera. Pianifica, costruisci e domina.', '2025-04-07 21:39:56'),
-- (7, 'Cyberpunk Chronicles', 69.99, 19.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1091500/header.jpg', 'Un gioco ambientato in un futuro distopico. Esplora una città cyberpunk piena di intrighi, missioni pericolose e personaggi memorabili.', '2025-04-07 21:39:56'),
-- (8, 'Fantasy Kingdoms', 49.99, 15.99, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/39210/header.jpg', 'Un gioco di ruolo ambientato in un regno fantastico. Crea il tuo eroe, esplora terre incantate e affronta nemici potenti in una storia epica.', '2025-04-07 21:39:56'),
-- (9, 'Galactic Wars', 59.99, 18.99, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/281990/header.jpg', 'Un gioco di strategia spaziale che ti permette di costruire il tuo impero galattico. Conquista pianeti, stringi alleanze e affronta battaglie epiche.', '2025-04-07 21:39:56'),
-- (10, 'Zombie Apocalypse', 39.99, 12.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/739630/header.jpg', 'Un gioco che ti immerge in un mondo post-apocalittico infestato da zombie. Sopravvivi, raccogli risorse e combatti per la tua vita.', '2025-04-07 21:39:56'),
-- (11, 'Racing Legends', 34.99, 10.99, 'sport', 'https://cdn.cloudflare.steamstatic.com/steam/apps/244210/header.jpg', 'Un gioco di corse ad alta velocità con auto realistiche e circuiti mozzafiato. Sfida i tuoi amici e diventa una leggenda delle corse.', '2025-04-07 21:39:56'),
-- (12, 'Medieval Conquest', 49.99, 14.99, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/48700/header.jpg', 'Un gioco di strategia medievale che ti permette di costruire il tuo regno, addestrare eserciti e conquistare territori nemici.', '2025-04-07 21:39:56'),
-- (13, 'Alien Invasion', 59.99, 17.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/582010/header.jpg', 'Un gioco che ti mette nei panni di un eroe che deve difendere la Terra da una terrificante invasione aliena. Preparati a combattere con armi futuristiche.', '2025-04-07 21:39:56'),
-- (14, 'Pirate Adventures', 44.99, 13.99, 'avventura', 'https://cdn.cloudflare.steamstatic.com/steam/apps/311340/header.jpg', 'Un gioco di avventura che ti trasporta nei mari caraibici. Diventa un pirata, esplora isole misteriose e cerca tesori nascosti.', '2025-04-07 21:39:56'),
-- (15, 'Super Soccer Stars', 29.99, 9.99, 'sport', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Un gioco di calcio arcade che combina azione veloce e divertimento. Sfida i tuoi amici e segna gol spettacolari.', '2025-04-07 21:39:56'),
-- (16, 'Stazione di Gioco 5', 229.99, 149.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente forte, ottime prestazioni e grafica mozzafiato.', '2025-04-07 21:39:56'),
-- (17, 'Stazione di Gioco 4', 199.99, 129.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente sensazionale, ottime prestazioni e grafica mozzafiato.', '2025-04-07 21:39:56'),
-- (18, 'Stazione di Gioco 3', 179.99, 119.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella', '2025-04-07 21:39:56'),
-- (19, 'Scatola ICS A', 349.99, 299.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella', '2025-04-07 21:39:56'),
-- (20, 'Scatola ICS B', 249.99, 199.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella', '2025-04-07 21:39:56'),
-- (21, 'Scatola ICS C', 149.99, 99.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Console veramente incredibile, boh bella', '2025-04-07 21:39:56'),
(22, 'Carta Regalo 10', 10.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 10 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.', '2025-04-07 21:39:56'),
(23, 'Carta Regalo 20', 20.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 20 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.', '2025-04-07 21:39:56'),
(24, 'Carta Regalo 50', 50.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 50 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.', '2025-04-07 21:39:56'),
(25, 'Carta Regalo 100', 100.00, 0.00, 'carta regalo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/1238860/header.jpg', 'Giftcard da 100 euro per acquistare giochi e contenuti ESCLUSIVAMENTE SUL NOSTRO NEGOZIO FISICO.', '2025-04-07 21:39:56'),
-- NUOVI PRODOTTI
(34, 'Arena dei Campioni', 49.99, 15.99, 'sport', 'https://cdn.cloudflare.steamstatic.com/steam/apps/arena_dei_campioni/header.jpg', 'Competi nell\'arena più prestigiosa con atleti di diverse discipline. Dimostra la tua abilità in calcio, basket e altri sport per diventare il campione assoluto.', CURRENT_TIMESTAMP),
(35, 'Assedio Imperiale', 54.99, 16.99, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/assedio_imperiale/header.jpg', 'Un gioco di strategia medievale dove dovrai difendere o conquistare castelli in epiche battaglie d\'assedio. Pianifica le tue tattiche e guida le tue truppe alla vittoria.', CURRENT_TIMESTAMP),
(36, 'Battaglia per Roma', 59.99, 17.99, 'strategia', 'https://cdn.cloudflare.steamstatic.com/steam/apps/battaglia_per_roma/header.jpg', 'Rivivi le epiche battaglie dell\'antica Roma in questo gioco di strategia storica. Comanda legioni, conquista territori e plasma il destino dell\'Impero Romano.', CURRENT_TIMESTAMP),
(37, 'Fuga dall\'Isola Proibita', 44.99, 13.99, 'avventura', 'https://cdn.cloudflare.steamstatic.com/steam/apps/fuga_isola_proibita/header.jpg', 'Un\'avventura mozzafiato su un\'isola misteriosa piena di pericoli e segreti. Esplora, risolvi enigmi e trova una via di fuga prima che sia troppo tardi.', CURRENT_TIMESTAMP),
(38, 'I Guardiani della Luce', 64.99, 19.99, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/guardiani_della_luce/header.jpg', 'Un epico gioco di ruolo fantasy dove un gruppo di eroi deve proteggere il mondo dall\'oscurità. Sviluppa i tuoi personaggi, padroneggia magie potenti e affronta nemici leggendari.', CURRENT_TIMESTAMP),
(39, 'Il Cavaliere del Destino', 59.99, 17.99, 'gioco di ruolo', 'https://cdn.cloudflare.steamstatic.com/steam/apps/cavaliere_destino/header.jpg', 'Un\'epica avventura medievale dove vestirai i panni di un cavaliere destinato a cambiare il corso della storia. Affronta pericolose missioni, combatti contro nemici leggendari e scopri il tuo vero destino.', CURRENT_TIMESTAMP),
(40, 'Lama d\'Ombra', 49.99, 14.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/lama_ombra/header.jpg', 'Un gioco stealth d\'azione dove interpreterai un assassino che si muove nell\'ombra. Utilizza armi letali e abilità sovrannaturali per eliminare i tuoi bersagli senza essere scoperto.', CURRENT_TIMESTAMP),
(41, 'Maestri del Pallone', 44.99, 13.99, 'sport', 'https://cdn.cloudflare.steamstatic.com/steam/apps/maestri_pallone/header.jpg', 'Il simulatore di calcio definitivo che ti permette di vivere l\'emozione del calcio professionistico. Crea la tua squadra, allena i giocatori e competi nei tornei più prestigiosi del mondo.', CURRENT_TIMESTAMP),
(42, 'Mistero a Venezia', 39.99, 12.99, 'avventura', 'https://cdn.cloudflare.steamstatic.com/steam/apps/mistero_venezia/header.jpg', 'Un\'avventura investigativa ambientata nella misteriosa Venezia del XVIII secolo. Risolvi enigmi, interroga sospetti e scopri i segreti nascosti tra i canali della città più affascinante del mondo.', CURRENT_TIMESTAMP),
(43, 'Operazione Drago Rosso', 54.99, 16.99, 'azione', 'https://cdn.cloudflare.steamstatic.com/steam/apps/operazione_drago_rosso/header.jpg', 'Un intenso sparatutto in prima persona che ti catapulta in una pericolosa missione militare. Infiltrati nelle linee nemiche, elimina i bersagli e completa gli obiettivi per salvare il mondo da una minaccia globale.', CURRENT_TIMESTAMP),

-- NUOVE CONSOLE
(44, 'Console Portatile Avventura', 199.99, 99.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/console_avventura/header.jpg', 'Console portatile di ultima generazione con schermo HD, controlli intuitivi e una vasta libreria di giochi. Perfetta per giocare ovunque tu sia.', CURRENT_TIMESTAMP),
(45, 'Console Retro Ludica', 89.99, 39.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/console_ludica/header.jpg', 'Console retro che riporta in vita i classici degli anni \'90. Design vintage, controller colorati e centinaia di giochi preinstallati per rivivere l\'epoca d\'oro del gaming.', CURRENT_TIMESTAMP),
(46, 'Console Potenza', 449.99, 249.99, 'piattaforma', 'https://cdn.cloudflare.steamstatic.com/steam/apps/console_potenza/header.jpg', 'La console più potente sul mercato con grafica 4K, tempi di caricamento istantanei e supporto per le tecnologie più avanzate. L\'esperienza di gioco definitiva per i veri appassionati.', CURRENT_TIMESTAMP);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` enum('user','admin') NOT NULL DEFAULT 'user',
  `stato` enum('attivo','bloccato') NOT NULL DEFAULT 'attivo',
  `ultimo_accesso` datetime DEFAULT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `email`, `password`, `ruolo`, `stato`, `ultimo_accesso`, `data_creazione`) VALUES
(1, 'admin', 'admin@test', '$2y$10$DtD/uFtUSUPSznqliAdVgeX7tflJ62PgUqVvR7tVf1cRkoeERuC3K', 'admin', 'attivo', NULL, '2025-04-07 21:39:56'),
(2, 'user', 'user@test', '$2y$10$qSb11LcmGJXjeDLafimZ1usUsGbs9qsJVxzpea/wi3THeDb0pICoa', 'user', 'attivo', NULL, '2025-04-07 21:39:56'),
(3, 'block', 'block@test', '$2y$10$nx0vjdmO/U8dPT0cWS6M5OydWpdwOcTpRUwlaWCphyF57uzjvUUsS', 'user', 'bloccato', NULL, '2025-04-07 21:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `valutazioni`
--

CREATE TABLE `valutazioni` (
  `nome` varchar(20) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `valore` float(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `valutazioni`
--

INSERT INTO `valutazioni` (`nome`, `categoria`, `valore`) VALUES
('buone', 'condizioni', 0.7),
('console', 'tipologia', 300.0),
('controller', 'tipologia', 50.0),
('gioco', 'tipologia', 40.0),
('microsoft', 'marca', 0.5),
('nintendo', 'marca', 0.9),
('ottime', 'condizioni', 1.0),
('scarse', 'condizioni', 0.4),
('sony', 'marca', 0.7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ordine_prodotti`
--
ALTER TABLE `ordine_prodotti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordine_id` (`ordine_id`),
  ADD KEY `prodotto_id` (`prodotto_id`);

--
-- Indexes for table `ordini`
--
ALTER TABLE `ordini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utente_id` (`utente_id`);

--
-- Indexes for table `pagamenti`
--
ALTER TABLE `pagamenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ordine_id` (`ordine_id`);

--
-- Indexes for table `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `valutazioni`
--
ALTER TABLE `valutazioni`
  ADD PRIMARY KEY (`nome`,`categoria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ordine_prodotti`
--
ALTER TABLE `ordine_prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordini`
--
ALTER TABLE `ordini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagamenti`
--
ALTER TABLE `pagamenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ordine_prodotti`
--
ALTER TABLE `ordine_prodotti`
  ADD CONSTRAINT `ordine_prodotti_ibfk_1` FOREIGN KEY (`ordine_id`) REFERENCES `ordini` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ordine_prodotti_ibfk_2` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ordini`
--
ALTER TABLE `ordini`
  ADD CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pagamenti`
--
ALTER TABLE `pagamenti`
  ADD CONSTRAINT `pagamenti_ibfk_1` FOREIGN KEY (`ordine_id`) REFERENCES `ordini` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
