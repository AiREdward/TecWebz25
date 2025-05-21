<?php
require_once __DIR__ . '/../config/db_config.php';

class TradeModel {
    public function getData() {
        $pdo = getDBConnection();
        $stmt = $pdo->query('SELECT * FROM valutazioni');
        $categories = $pdo->query('SELECT DISTINCT(categoria) FROM valutazioni as categories');
        $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'ratings' => $ratings,
            'categories' => $categories
        ];
    }

    public function calcRating($type, $conditions, $brand) {
        $score = 0;
        $data = $this->getData();
        $multiplicative = [];
        $additive = [];

        foreach ($data['ratings'] as $item):
            if ($item['nome'] == $type) {
                $additive[] = $item['valore'];
            }
            if ($item['nome'] == $conditions || $item['nome'] == $brand) {
                $multiplicative[] = $item['valore'];
            }
        endforeach;

        // calculate the score
        foreach ($additive as $value) {
            $score += $value;
        }
        foreach ($multiplicative as $value) {
            $score *= $value;
        }

        $score = round($score, 2);
        if ($score < 0) {
            $score = 0;
        }

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