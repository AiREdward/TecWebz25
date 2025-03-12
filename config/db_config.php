<?php
// Configurazione del database
define('DB_HOST', 'localhost');
define('DB_NAME', 'gs_db');  // Sostituisci con il nome del tuo DB
define('DB_USER', 'root');                   // Modifica secondo la tua configurazione
define('DB_PASS', '');                        // Se hai una password, inseriscila qui

// Funzione per connettersi al database usando PDO
function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Errore di connessione al database: " . $e->getMessage());
        }
    }
    
    return $pdo;
}
?>
