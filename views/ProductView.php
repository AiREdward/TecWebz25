<?php
class ProductView {
    public function render($data) {
        if ($data) {
            ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($data['nome']); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($data['nome']); ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="product-details">
            <img src="<?php echo htmlspecialchars($data['immagine']); ?>" alt="<?php echo htmlspecialchars($data['nome']); ?>" width="300" height="300">
            <p>Prezzo: $<?php echo htmlspecialchars(number_format($data['prezzo'], 2)); ?></p>
            <p>Descrizione: <?php echo htmlspecialchars($data['descrizione']); ?></p>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Shop. All rights reserved.</p>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
            <?php
        } else {
            echo '<p>Prodotto non trovato.</p>';
        }
    }
}
?>