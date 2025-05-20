<?php
require_once __DIR__ . '/../config/db_config.php';

class ShopModel {
    public function getData() {
        $pdo = getDBConnection();
        $stmt = $pdo->query('SELECT * FROM prodotti');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'products' => $products
        ];
    }
    
    public function searchProducts($searchTerm) {
        $pdo = getDBConnection();
        
        // Modifica: cerca solo nel campo nome
        if (empty($searchTerm)) {
            $stmt = $pdo->query('SELECT * FROM prodotti');
        } else {
            $searchTerm = "%$searchTerm%";
            $stmt = $pdo->prepare('SELECT * FROM prodotti WHERE nome LIKE ? LIMIT 100');
            $stmt->execute([$searchTerm]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>