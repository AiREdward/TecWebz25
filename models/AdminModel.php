<?php
require_once __DIR__ . '/../config/db_config.php';

class AdminModel {
    public function getData() {
        return [
            'title' => 'Admin Dashboard',
            'header' => 'Admin Dashboard',
            'content' => 'This is the admin dashboard content.'
        ];
    }
    
    public function addProduct($nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione) {
        try {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare('INSERT INTO prodotti (nome, prezzo, prezzo_ritiro_usato, genere, immagine, descrizione, data_creazione) 
                                  VALUES (:nome, :prezzo, :prezzo_ritiro_usato, :genere, :immagine, :descrizione, CURRENT_TIMESTAMP)');
            
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':prezzo', $prezzo);
            $stmt->bindParam(':prezzo_ritiro_usato', $prezzo_ritiro_usato);
            $stmt->bindParam(':genere', $genere);
            $stmt->bindParam(':immagine', $immagine);
            $stmt->bindParam(':descrizione', $descrizione);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
?>