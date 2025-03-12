<?php
require_once __DIR__ . '/../config/db_config.php';

class ProductModel {
    public function getProduct($id) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare('SELECT * FROM prodotti WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    }
}
?>