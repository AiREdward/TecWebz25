<?php
require_once __DIR__ . '/../config/db_config.php';

class TradeModel {
    public function getData() {
        $pdo = getDBConnection();
        $stmt = $pdo->query('SELECT * FROM valutazioni');
        $categories = $pdo->query('SELECT DISTINCT(categoria) FROM valutazioni as categories');
        $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'title' => 'Trade',
            'header' => 'Trade Services',
            'content' => 'This is the trade page content.',
            'ratings' => $ratings,
            'categories' => $categories
        ];
    }

    public function calcRating($type, $conditions, $brand) {
        $score = 0;
        $data = $this->getData();

        foreach ($data['ratings'] as $item):
            if ($item['nome'] == $type) {
                $score += $item['valore'];
            }
            if ($item['nome'] == $conditions || $item['nome'] == $brand) {
                $score *= $item['valore'];
            }
        endforeach;

        $result = [
            'status' => 'success',
            'rating' => $score,
            'inputs' => compact('type', 'conditions', 'brand')
        ];

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
?>