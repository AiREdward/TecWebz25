<?php
// Configurazione del database
define('DB_HOST', 'localhost');
define('DB_NAME', 'gs_db');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            header("Location: config/Errore.html");
            exit();
        }
    }
    
    return $pdo;
}
?>
