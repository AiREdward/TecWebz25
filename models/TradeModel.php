<?php
require_once __DIR__ . '/../config/db_config.php';

class TradeModel {
    public function getData() {
        $pdo = getDBConnection();
        $stmt = $pdo->query('SELECT * FROM valutazioni');
        $valutazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'title' => 'Trade',
            'header' => 'Trade Services',
            'content' => 'This is the trade page content.',
            'valutazioni' => $valutazioni
        ];
    }
}
?>