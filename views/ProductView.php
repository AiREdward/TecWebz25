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
    <title>Prodotto</title>

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
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Negozio', 'url' => 'index.php?page=shop'],
            ['name' => 'Visualizza Prodotto', 'url' => 'index.php?page=product']
        ];
        include 'includes/menu.php'; 
    ?>

    <main>
        <section id="product-details" aria-labelledby="product-title">
            <article id="product-image" class="product-card <?php echo $isRecent ? 'recent-product' : ''; ?>" role="listitem" aria-label="Immagine del prodotto">
                <img src="<?php echo htmlspecialchars($data['immagine']); ?>" alt="Prodotto <?php echo htmlspecialchars($data['nome']); ?>" width="300" height="300">
                <?php if ($isRecent): ?>
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
                            <?php 

                            $mesiItaliani = [
                                'January' => 'Gennaio',
                                'February' => 'Febbraio',
                                'March' => 'Marzo',
                                'April' => 'Aprile',
                                'May' => 'Maggio',
                                'June' => 'Giugno',
                                'July' => 'Luglio',
                                'August' => 'Agosto',
                                'September' => 'Settembre',
                                'October' => 'Ottobre',
                                'November' => 'Novembre',
                                'December' => 'Dicembre'
                            ];

                            $dataInglese = date('d F Y', strtotime($data['data_creazione']));
                            $dataItaliana = str_replace(array_keys($mesiItaliani), array_values($mesiItaliani), $dataInglese);

                            echo htmlspecialchars($dataItaliana);
                            ?>
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