<?php
class ProductView {
    public function render($data) {
        if ($data) {
            ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Prodotto - GameStart</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Dettagli completi del prodotto, specifiche tecniche, prezzo e disponibilità. Acquista subito o valuta il ritiro dell'usato">
    <meta name="keywords" content="dettagli prodotto, specifiche videogiochi, prezzo giochi, console gaming, accessori videogiochi">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>

    <?php
        $breadcrumb = $data['breadcrumb'];
        include 'includes/menu.php'; 
    ?>

    <main>
        <div id="back-button-container">
            <a href="index.php?page=shop" id="back-button" aria-label="Torna alla pagina shop">
                Torna al Negozio
            </a>
        </div>

        <section id="product-details" aria-labelledby="product-title">
            <article id="product-image" class="product-card <?php echo $data['isRecent'] ? 'recent-product' : ''; ?>" role="listitem" aria-label="Immagine del prodotto">
                <img src="<?php echo htmlspecialchars($data['immagine']); ?>" alt="Prodotto <?php echo htmlspecialchars($data['nome']); ?>" width="300" height="300">
                <?php if ($data['isRecent']): ?>
                    <span class="badge" aria-label="Prodotto nuovo">Nuovo!</span>
                <?php endif; ?>
            </article>
            <article id="product-info" aria-labelledby="product-title">
                <h1 id="product-title"><?php echo htmlspecialchars($data['nome']); ?></h1>
                <div>
                    <p><span class="label" aria-hidden="true">Categoria:</span> <span aria-label="Categoria del prodotto"><?php echo htmlspecialchars($data['genere']); ?></span></p>
                    <p><span class="label" aria-hidden="true">Prezzo:</span> <span aria-label="Prezzo del prodotto">$<?php echo htmlspecialchars(number_format($data['prezzo'], 2)); ?></span></p>
                    <p>
                        <span class="label" aria-hidden="true">Prezzo Ritiro Usato:</span> 
                        <span aria-label="Prezzo per il ritiro usato">
                            <?php 
                            if ($data['prezzo_ritiro_usato'] == 0) {
                                echo 'Non è possibile effettuare il ritiro per questo prodotto.';
                            } else {
                                echo '$' . htmlspecialchars(number_format($data['prezzo_ritiro_usato'], 2));
                            }
                            ?>
                        </span>
                    </p>
                    <p><span class="label" aria-hidden="true">Descrizione:</span> <span aria-label="Descrizione del prodotto"><?php echo htmlspecialchars($data['descrizione']); ?></span></p>
                    <p><span class="label" aria-hidden="true">Data di Rilascio:</span> 
                        <span aria-label="Data di rilascio del prodotto">
                            <?php echo htmlspecialchars($data['dataItaliana']); ?>
                        </span>
                    </p>
                </div>
            </article>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/menu.js"></script>
</body>
</html>
            <?php
        } else {
            echo '<p aria-label="Messaggio di errore">Prodotto non trovato.</p>';
        }
    }
}
?>