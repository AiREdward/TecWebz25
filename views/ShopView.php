<?php
class ShopView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="products">
            <h2>Products</h2>
            <ul>
                <?php foreach ($data['products'] as $product): ?>
                    <li><?php echo htmlspecialchars($product['name']) . ' - $' . htmlspecialchars($product['price']); ?></li>
                <?php endforeach; ?>
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