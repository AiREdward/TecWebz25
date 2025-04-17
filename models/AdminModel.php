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
    
    public function searchProducts($query) {
        try {
            $pdo = getDBConnection();
            
            $searchTerm = "%$query%";
            $stmt = $pdo->prepare('SELECT * FROM prodotti WHERE nome LIKE :query ORDER BY nome');
            $stmt->bindParam(':query', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }
    
    public function updateProduct($id, $nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione) {
        try {
            $pdo = getDBConnection();
            
            // If a new image was uploaded, update with the new path
            if (!empty($immagine)) {
                $stmt = $pdo->prepare('UPDATE prodotti SET 
                                      nome = :nome, 
                                      prezzo = :prezzo, 
                                      prezzo_ritiro_usato = :prezzo_ritiro_usato, 
                                      genere = :genere, 
                                      immagine = :immagine, 
                                      descrizione = :descrizione 
                                      WHERE id = :id');
                
                $stmt->bindParam(':immagine', $immagine);
            } else {
                // If no new image, don't update the image field
                $stmt = $pdo->prepare('UPDATE prodotti SET 
                                      nome = :nome, 
                                      prezzo = :prezzo, 
                                      prezzo_ritiro_usato = :prezzo_ritiro_usato, 
                                      genere = :genere, 
                                      descrizione = :descrizione 
                                      WHERE id = :id');
            }
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':prezzo', $prezzo);
            $stmt->bindParam(':prezzo_ritiro_usato', $prezzo_ritiro_usato);
            $stmt->bindParam(':genere', $genere);
            $stmt->bindParam(':descrizione', $descrizione);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function deleteProducts($ids) {
        try {
            $pdo = getDBConnection();
            
            // Convert array of IDs to comma-separated string for the IN clause
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            
            $stmt = $pdo->prepare("DELETE FROM prodotti WHERE id IN ($placeholders)");
            
            // Bind each ID as a parameter
            foreach ($ids as $index => $id) {
                $stmt->bindValue($index + 1, $id);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
?>