<?php
class ShopView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GameStart - Your premier destination for video games">
    <title><?php echo htmlspecialchars($data['title']); ?> - GameStart</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header role="banner">
        <h1><?php echo htmlspecialchars($data['header']); ?></h1>
        <nav role="navigation" aria-label="Main navigation">
            <?php include 'includes/menu.php'; ?>
        </nav>
    </header>

    <main role="main">
        <div class="shop-container">
            <aside class="filters" role="complementary">
                <h2>Filter Games</h2>
                <form id="filter-form" aria-label="Product filters">
                    <div class="filter-group">
                        <h3>Genre</h3>
                        <div class="checkbox-group" role="group" aria-labelledby="genre-heading">
                            <label class="checkbox-label">
                                <input type="checkbox" name="genre" value="action" aria-label="Action games">
                                Action
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genre" value="rpg" aria-label="RPG games">
                                RPG
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genre" value="strategy" aria-label="Strategy games">
                                Strategy
                            </label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h3>Price Range</h3>
                        <div class="range-group">
                            <label for="min-price">Min Price:</label>
                            <input type="number" id="min-price" name="min-price" min="0" max="200" step="5" value="0">
                            
                            <label for="max-price">Max Price:</label>
                            <input type="number" id="max-price" name="max-price" min="0" max="200" step="5" value="200">
                        </div>
                    </div>

                    <button type="submit" class="apply-filters">Apply Filters</button>
                </form>
            </aside>

            <section class="products" aria-label="Product list">
                <h2>Available Games</h2>
                <div class="products-grid" role="list">
                    <?php foreach ($data['products'] as $product): ?>
                    <article class="product-card" role="listitem">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             loading="lazy"
                             width="200" 
                             height="200">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="price">$<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></p>
                        <p class="genre"><?php echo htmlspecialchars($product['genre']); ?></p>
                        <button class="add-to-cart" 
                                aria-label="Add <?php echo htmlspecialchars($product['name']); ?> to cart"
                                data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                            Add to Cart
                        </button>
                        <a href="index.php?page=product&id=<?php echo htmlspecialchars($product['id']); ?>" class="view-product" aria-label="View details of <?php echo htmlspecialchars($product['name']); ?>">
                            View Product
                        </a>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <aside class="cart" role="complementary">
                <h2>Shopping Cart</h2>
                <p id="cart-total">Total: $0.00</p>
                <button id="checkout-button" 
                        class="checkout-button" 
                        aria-label="Proceed to checkout"
                        disabled>
                    Checkout
                </button>
                <div id="cart-contents" aria-live="polite">
                    <ul id="cart-items" role="list">
                        <!-- Cart items will be dynamically inserted here -->
                    </ul>
                </div>
            </aside>
        </div>
    </main>

    <footer role="contentinfo">
        <p>&copy; <?php echo date('Y'); ?> GameStart. All rights reserved.</p>
    </footer>

    <script src="assets/js/shop.js"></script>
</body>
</html>
        <?php
    }
}
?>