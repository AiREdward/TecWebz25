<?php
class ShopModel {
    public function getData() {
        return [
            'title' => 'Shop',
            'header' => 'Benvenuti in GameStart',
            'products' => [
                ['name' => 'Product 1', 'price' => 10.00],
                ['name' => 'Product 2', 'price' => 20.00],
                // Add more products as needed
            ]
        ];
    }
}
?>