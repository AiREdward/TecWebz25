<?php
class ShopView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title']); ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <script defer src="/js/shop.js"></script>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($data['header']); ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="products" aria-labelledby="products-heading">
            <h2 id="products-heading">Products</h2>
            <div id="filters">
                <label for="filter">Filter by price:</label>
                <select id="filter">
                    <option value="all">All</option>
                    <option value="low">Low to High</option>
                    <option value="high">High to Low</option>
                </select>
            </div>
            <ul id="product-list">
                <?php foreach ($data['products'] as $product): ?>
                    <li data-price="<?php echo htmlspecialchars($product['price']); ?>">
                        <?php echo htmlspecialchars($product['name']) . ' - $' . htmlspecialchars($product['price']); ?>
                        <button class="add-to-cart" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">Add to Cart</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section id="cart" aria-labelledby="cart-heading">
            <h2 id="cart-heading">Cart</h2>
            <ul id="cart-items">
                <!-- Cart items will be dynamically added here -->
            </ul>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Shop. All rights reserved.</p>
    </footer>
</body>
</html>
        <?php
    }
}
?>
