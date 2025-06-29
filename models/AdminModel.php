<?php
require_once __DIR__ . '/../config/db_config.php';

class AdminModel {
    public function getData() {
        return [
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
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }
    
    public function searchUsers($query) {
        try {
            $pdo = getDBConnection();
            
            $searchTerm = "%$query%";
            $stmt = $pdo->prepare('SELECT * FROM utenti WHERE username LIKE :query OR email LIKE :query ORDER BY username');
            $stmt->bindParam(':query', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getUsers() {
        try {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare('SELECT * FROM utenti ORDER BY username');
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }
    
    public function updateProduct($id, $nome, $prezzo, $prezzo_ritiro_usato, $genere, $immagine, $descrizione) {
        try {
            $pdo = getDBConnection();
            
            // Se è stata caricata una nuova immagine, aggiorna con il nuovo percorso
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
                // Se non c'è una nuova immagine, non aggiornare il campo immagine
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
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function deleteProducts($ids) {
        try {
            $pdo = getDBConnection();
            
            // Otteniamo i percorsi delle immagini dei prodotti da eliminare
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmtImages = $pdo->prepare("SELECT id, immagine FROM prodotti WHERE id IN ($placeholders)");
            
            foreach ($ids as $index => $id) {
                $stmtImages->bindValue($index + 1, $id);
            }
            
            $stmtImages->execute();
            $products = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
            
            // Eliminiamo le immagini
            foreach ($products as $product) {
                if (!empty($product['immagine']) && file_exists($product['immagine'])) {
                    unlink($product['immagine']);
                    error_log('Immagine eliminata: ' . $product['immagine']);
                }
            }
            
            // Eliminiamo i prodotti dal database
            $stmt = $pdo->prepare("DELETE FROM prodotti WHERE id IN ($placeholders)");
            
            foreach ($ids as $index => $id) {
                $stmt->bindValue($index + 1, $id);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getStatistics() {
        try {
            $pdo = getDBConnection();
            $stats = [];
            
            // Conteggio utenti totali
            $stmt = $pdo->query('SELECT COUNT(*) as total FROM utenti');
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Conteggio utenti attivi
            $stmt = $pdo->query('SELECT COUNT(*) as active FROM utenti WHERE stato = "attivo"');
            $stats['active_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['active'];
            
            // Conteggio prodotti totali
            $stmt = $pdo->query('SELECT COUNT(*) as total FROM prodotti');
            $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Conteggio vendite totali (ordini)
            $stmt = $pdo->query('SELECT COUNT(*) as total FROM ordini');
            $stats['total_sales'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Conteggio prodotti venduti
            $stmt = $pdo->query('SELECT SUM(quantita) as total FROM dettaglio_ordine');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_products_sold'] = $result['total'] ? $result['total'] : 0;
            
            // Calcolo incasso totale
            $stmt = $pdo->query('SELECT SUM(o.totale) as total_revenue FROM ordini o WHERE o.stato = "completato"');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_revenue'] = $result['total_revenue'] ? number_format($result['total_revenue'], 2) : '0.00';
            
            return $stats;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [
                'total_users' => 0,
                'active_users' => 0,
                'total_products' => 0,
                'total_sales' => 0,
                'total_products_sold' => 0,
                'total_revenue' => '0.00'
            ];
        }
    }
    
    public function updateUser($id, $ruolo, $stato) {
        try {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare('UPDATE utenti SET 
                                  ruolo = :ruolo, 
                                  stato = :stato 
                                  WHERE id = :id');
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':ruolo', $ruolo);
            $stmt->bindParam(':stato', $stato);
            
            return $stmt->execute();
        } catch (PDOException $e) {

            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getUserById($id) {
        try {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare('SELECT * FROM utenti WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            error_log('Database error: ' . $e->getMessage());
            return null;
        }
    }
    
    public function deleteUser($id) {
        try {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare('DELETE FROM utenti WHERE id = :id');
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {

            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
    
    // Metodo per ottenere tutte le valutazioni
    public function getValuations() {
        try {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare('SELECT * FROM valutazioni ORDER BY categoria, nome');
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }
    
    // Metodo per aggiornare una valutazione
    public function updateValuation($originalName, $nome, $categoria, $valore) {
        try {
            $pdo = getDBConnection();
            
            // Se il nome è cambiato, dobbiamo eliminare il vecchio record e crearne uno nuovo
            // poiché il nome è la chiave primaria
            if ($originalName !== $nome) {
                $pdo->beginTransaction();
                
                // Elimina il vecchio record
                $stmtDelete = $pdo->prepare('DELETE FROM valutazioni WHERE nome = :nome');
                $stmtDelete->bindParam(':nome', $originalName);
                $stmtDelete->execute();
                
                // Inserisci il nuovo record
                $stmtInsert = $pdo->prepare('INSERT INTO valutazioni (nome, categoria, valore) VALUES (:nome, :categoria, :valore)');
                $stmtInsert->bindParam(':nome', $nome);
                $stmtInsert->bindParam(':categoria', $categoria);
                $stmtInsert->bindParam(':valore', $valore);
                $stmtInsert->execute();
                
                $pdo->commit();
                return true;
            } else {
                // Aggiorna il record esistente
                $stmt = $pdo->prepare('UPDATE valutazioni SET categoria = :categoria, valore = :valore WHERE nome = :nome');
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':valore', $valore);
                
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
?>