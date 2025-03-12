<?php
class ProductView {
    public function render($data) {
        if ($data) {
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($data['name']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($data['name']); ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="product-details">
<<<<<<< HEAD
            <p>Price: $<?php echo htmlspecialchars($data['price']); ?></p>
=======
            <img src="<?php echo htmlspecialchars($data['image']); ?>" alt="<?php echo htmlspecialchars($data['name']); ?>" width="300" height="300">
            <p>Price: $<?php echo htmlspecialchars(number_format($data['price'], 2)); ?></p>
>>>>>>> 6f42b9a492c33754fc9cc44233621f72a600412b
            <p>Description: <?php echo htmlspecialchars($data['description']); ?></p>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Shop. All rights reserved.</p>
    </footer>
</body>
</html>
            <?php
        } else {
            echo '<p>Product not found.</p>';
        }
    }
}
?>