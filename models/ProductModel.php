<?php
class ProductModel {
    public function getProduct($id) {
        // Fetch product details from the database
        // This is a placeholder for the actual database fetching logic
        $products = [
            1 => ['name' => 'Product 1', 'price' => 10.00, 'description' => 'Description of Product 1', 'image' => 'https://placehold.co/300x300/png?text=Product+1'],
            2 => ['name' => 'Product 2', 'price' => 20.00, 'description' => 'Description of Product 2', 'image' => 'https://placehold.co/300x300/png?text=Product+2'],
            // Add more products as needed
        ];

        return $products[$id] ?? null;
    }
}
?>