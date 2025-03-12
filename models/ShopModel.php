<?php
require_once __DIR__ . '/../config/db_config.php';

class ShopModel {
    public function getData() {
        $pdo = getDBConnection();
        $stmt = $pdo->query('SELECT * FROM prodotti');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'title' => 'Shop',
            'header' => 'Benvenuti in GameStart',
            'products' => $products
        ];
    }
}
?>