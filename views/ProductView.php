<?php
class ProductView {
    public function render($data) {
        if ($data) {
            // Determina se il prodotto è "Nuovo"
            $recentThreshold = new DateTime('-7 days');
            $productDate = new DateTime($data['data_creazione']);
            $isRecent = $productDate >= $recentThreshold;
            ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- METTI GLI ARIA LABEL -->
    <!-- FIX BADGE -->

    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="product-details">
            <div id="product-image">
                <img src="<?php echo htmlspecialchars($data['immagine']); ?>" alt="<?php echo htmlspecialchars($data['nome']); ?>" width="300" height="300">
                <?php if ($isRecent): ?>
                    <span class="badge">Nuovo!</span>
                <?php endif; ?>
            </div>
            <div id="product-info">
                <h2><?php echo htmlspecialchars($data['nome']); ?></h2>
                <div>
                    <p><span class="label">Categoria:</span> <?php echo htmlspecialchars($data['genere']); ?></p>
                    <p><span class="label">Prezzo:</span> $<?php echo htmlspecialchars(number_format($data['prezzo'], 2)); ?></p>
                    <p><span class="label">Prezzo Ritiro Usato:</span> $<?php echo htmlspecialchars(number_format($data['prezzo_ritiro_usato'], 2)); ?></p>
                    <p><span class="label">Descrizione:</span> <?php echo htmlspecialchars($data['descrizione']); ?></p>
                    <p><span class="label">Data di Creazione:</span> <?php echo htmlspecialchars(date('d-m-Y H:i:s', strtotime($data['data_creazione']))); ?></p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Shop. All rights reserved.</p>
    </footer>
    <script src="assets/js/menu.js"></script>
</body>
</html>
            <?php
        } else {
            echo '<p>Prodotto non trovato.</p>';
        }
    }
}
?>