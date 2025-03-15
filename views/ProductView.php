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
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="product-details">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($data['immagine']); ?>" alt="<?php echo htmlspecialchars($data['nome']); ?>" width="300" height="300">
            </div>
            <div class="product-info">
                <h2><?php echo htmlspecialchars($data['nome']); ?></h2>
                <div>
                    <p><span class="label">Categoria:</span> <?php echo htmlspecialchars($data['genere']); ?></p>
                    <p><span class="label">Prezzo:</span> $<?php echo htmlspecialchars(number_format($data['prezzo'], 2)); ?></p>
                    <p><span class="label">Descrizione:</span> <?php echo htmlspecialchars($data['descrizione']); ?></p>
                </div>
            </div>
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