<?php
class ShopModel {
    public function getData() {
        return [
            'title' => 'Shop',
            'header' => 'Benvenuti in GameStart',
            'products' => [
<<<<<<< HEAD
                ['name' => 'Product 1', 'price' => 10.00],
                ['name' => 'Product 2', 'price' => 20.00],
                // Add more products as needed
=======
                [
                    'id' => '1',
                    'name' => 'The Legend of Adventure',
                    'price' => 59.99,
                    'genre' => 'action',
                    'image' => 'https://placehold.co/200x200/png?text=Game+1',
                ],
                [
                    'id' => '2',
                    'name' => 'Mystic Quest Chronicles',
                    'price' => 49.99,
                    'genre' => 'rpg',
                    'image' => 'https://placehold.co/200x200/png?text=Game+2',
                ],
                [
                    'id' => '3',
                    'name' => 'Space Commander',
                    'price' => 39.99,
                    'genre' => 'strategy',
                    'image' => 'https://placehold.co/200x200/png?text=Game+3',
                ],
                [
                    'id' => '4',
                    'name' => 'Dragon Warrior Saga',
                    'price' => 54.99,
                    'genre' => 'rpg',
                    'image' => 'https://placehold.co/200x200/png?text=Game+4',
                ],
                [
                    'id' => '5',
                    'name' => 'Ninja Combat',
                    'price' => 29.99,
                    'genre' => 'action',
                    'image' => 'https://placehold.co/200x200/png?text=Game+5',
                ],
                [
                    'id' => '6',
                    'name' => 'Empire Builder 2025',
                    'price' => 44.99,
                    'genre' => 'strategy',
                    'image' => 'https://placehold.co/200x200/png?text=Game+6',
                ]
>>>>>>> 6f42b9a492c33754fc9cc44233621f72a600412b
            ]
        ];
    }
}
?>