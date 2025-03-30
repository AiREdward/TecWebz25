<?php
class ShopView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Nel nostro negozio troverete giochi, piattaforme e carte regalo per ogni esigenza.">
    <meta name="keywords" content="giochi, piattaforme, carte regalo, negozio online, videogiochi">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/latest/css/all.min.css" crossorigin="anonymous">

</head>
<body>
    <header role="banner">
        <nav role="navigation" aria-label="Navigatore principale">
            <?php include 'includes/menu.php'; ?>
        </nav>
    </header>

    <!-- cambia il firltro sburra -->
    <!-- media query per i filtri 768px -->
    <!-- CAMBIA IMMAGINI PRODOTTI -->
    <!-- SISTEMA NAVIGAZIONE DA TASTIERA COL WRAP-REVERSE -->

    <main role="main" class="content">
        <div id="shop-container">

            <aside id="filters" role="complementary">
                <h2>Filtra la tua ricerca</h2>
                <form id="filter-form" aria-label="Filtri di ricerca">

                    <div class="filter-group">
                        <h3>Genere:</h3>
                        <div id="checkbox-group" role="group" aria-labelledby="Seleziona i generi di gioco">
                            <label class="checkbox-label">
                                <input type="checkbox" id="select-all-genres" aria-label="Seleziona tutti i generi">
                                Seleziona tutti
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="azione" aria-label="Giochi d'azione" checked>
                                Azione
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="gioco di ruolo" aria-label="Giochi di ruolo" checked>
                                Giochi di Ruolo
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="strategia" aria-label="Giochi di Strategia" checked>
                                Strategia
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="sport" aria-label="Giochi di Sport" checked>
                                Sport
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="avventura" aria-label="Giochi di Avventura" checked>
                                Avventura
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="piattaforma" aria-label="Piattaforme" checked>
                                Piattaforme
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="carta regalo" aria-label="Carte Regalo" checked>
                                Carte Regalo
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genere" value="Sburra" aria-label="Sburra" checked>
                                Sburra
                            </label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h3>Filtra per prezzo:</h3>
                        <div id="range-group">
                            <div class="range-inputs">
                                <label for="min-price">Prezzo minimo:</label>
                                <input type="number" id="min-price" name="min-price" min="0" max="1000" step="5" value="0">
                            </div>
                            <div class="range-inputs"> 
                                <label for="max-price">Prezzo massimo:</label>
                                <input type="number" id="max-price" name="max-price" min="5" max="1000" step="5" value="1000">
                            </div>
                        </div>
                    </div>
                </form>
            </aside>

            <section id="products" aria-label="Lista dei prodotti">
                
                <div id="products-header">
                    <h2>Giochi in vendita</h2>
                    <button id="cart-hamburger-menu" aria-label="Apri il carrello">
                        <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                    </button>
                </div>

                <div id="products-box" role="list">
                    <?php 
                    $recentThreshold = new DateTime('-7 days'); // Prodotti aggiunti negli ultimi 7 giorni
                    // Reverse the order of products
                    $reversedProducts = array_reverse($data['products']);
                    foreach ($reversedProducts as $product): 
                        $productDate = new DateTime($product['data_creazione']);
                        $isRecent = $productDate >= $recentThreshold;
                    ?>
                    <article class="product-card <?php echo $isRecent ? 'recent-product' : ''; ?>" role="listitem">
                        <img src="<?php echo htmlspecialchars($product['immagine']); ?>" 
                             alt="<?php echo htmlspecialchars($product['nome']); ?>" 
                             loading="lazy"
                             width="200" 
                             height="200">
                        <h3><?php echo htmlspecialchars($product['nome']); ?></h3>
                        <p class="prezzo">Prezzo: $<?php echo htmlspecialchars(number_format($product['prezzo'], 2)); ?></p>
                        <p class="genere">Genere: <?php echo htmlspecialchars($product['genere']); ?></p>
                        <?php if ($isRecent): ?>
                            <span class="badge">Nuovo!</span>
                        <?php endif; ?>
                        <div class="product-actions">
                            <button class="add-to-cart" 
                                    aria-label="Aggiungi <?php echo htmlspecialchars($product['nome']); ?> al carrello"
                                    data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                                Aggiungi al carrello
                            </button>
                            <a href="index.php?page=product&id=<?php echo htmlspecialchars($product['id']); ?>" class="view-product" aria-label="Visualizza il prodotto: <?php echo htmlspecialchars($product['nome']); ?>">
                                Visualizza prodotto
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <aside id="cart" role="complementary">
                <div id="cart-header">
                    <h2>Carrello</h2>
                    <button id="close-cart" aria-label="Chiudi il carrello">
                        Chiudi
                    </button>
                </div>
                <p id="cart-total">Totale: $0.00</p>
                <button id="checkout-button" 
                        aria-label="Procedi al pagamento"
                        disabled>
                    Procedi al pagamento
                </button>
                <div id="cart-contents" aria-live="polite">
                    <ul id="cart-items" role="list">
                        <!-- Cart items will be dynamically inserted here -->
                    </ul>
                </div>
            </aside>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/shop.js"></script>
    <script src="assets/js/menu.js"></script>
</body>
</html>
        <?php
    }
}
?>