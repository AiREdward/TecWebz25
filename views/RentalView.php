<?php
class RentalView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>

    <meta name="author" content="TODO">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- <header>
        <h1><?php echo $data['header']; ?></h1>
    </header> -->
    <?php include 'includes/menu.php'; ?>
    <!-- <main>
        <section id="rental">
            <p><?php echo $data['content']; ?></p>
        </section>
    </main> -->
    <main class="homepage">
        <!-- <section id="intro">
            <p><?php echo $data['content']; ?></p>
        </section> -->
        <div class="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Non serve comprare un'emozione <br>
                        per farla tua
                    </h1>
                    <h2 class="subtitle bright-title">
                        Scegli un gioco a noleggio dal nostro
                    </h2>
                    <a onclick="scrollToId('ads');">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div>
                    <img src="assets/images/luckyblock.webp" id="illustration" alt="Illustrazione mattoncino fortunato di Super Mario"/>
                </div>
            </div>
            
        </div>

        <div class="gray-section">
            <!-- <div class="row content" id="ads">
                <div class="ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp" alt="Foto Nintendo Switch 2"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra"/>
                        <a href="index.php?page=shop"> Scopri il nostro Shop! </a>
                    </div>
                </div>
            </div> -->
            <div class="shop-container content">
                <aside class="filters" role="complementary">
                    <h2>Filtra la tua ricerca</h2>
                    <form id="filter-form" aria-label="Product filters">
                        <div class="filter-group">
                            <h3>Genere:</h3>
                            <div class="checkbox-group" role="group" aria-labelledby="genre-heading">
                                <label class="checkbox-label">
                                    Azione
                                    <input type="checkbox" name="genere" value="azione" aria-label="Giochi d'azione" checked>
                                </label>
                                <label class="checkbox-label">
                                    RPG
                                    <input type="checkbox" name="genere" value="rpg" aria-label="Giochi RPG" checked>
                                </label>
                                <label class="checkbox-label">
                                    Strategia
                                    <input type="checkbox" name="genere" value="strategia" aria-label="Giochi di Strategia" checked>
                                </label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h3><span lang="en">Range</span> di prezzo:</h3>
                            <div class="range-group">
                                <label for="min-price">Prezzo minimo:</label>
                                <input type="number" id="min-price" name="min-price" min="0" max="200" step="5" value="0">
                                
                                <label for="max-price">Prezzo massimo:</label>
                                <input type="number" id="max-price" name="max-price" min="0" max="200" step="5" value="200">
                            </div>
                        </div>
                    </form>
                </aside>

                <section class="products" aria-label="Product list">
                    <h2>Giochi in vendita</h2>
                    <div class="products-box" role="list">
                        <?php foreach ($data['products'] as $product): ?>
                        <article class="product-card" role="listitem">
                            <img src="<?php echo htmlspecialchars($product['immagine']); ?>" 
                                alt="<?php echo htmlspecialchars($product['nome']); ?>" 
                                loading="lazy"
                                width="200" 
                                height="200">
                            <h3><?php echo htmlspecialchars($product['nome']); ?></h3>
                            <p class="prezzo">Prezzo: $<?php echo htmlspecialchars(number_format($product['prezzo'], 2)); ?></p>
                            <p class="genere">Genere: <?php echo htmlspecialchars($product['genere']); ?></p>
                            <button class="add-to-cart" 
                                    aria-label="Aggiungi <?php echo htmlspecialchars($product['nome']); ?> al carrello"
                                    data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                                Aggiungi al carrello
                            </button>
                            <a href="index.php?page=product&id=<?php echo htmlspecialchars($product['id']); ?>" class="view-product" aria-label="Visualizza il prodotto: <?php echo htmlspecialchars($product['nome']); ?>">
                                Visualizza prodotto
                            </a>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </section>

                <aside class="cart" role="complementary">
                    <h2>Carrello</h2>
                    <p id="cart-total">Totale: $0.00</p>
                    <button id="checkout-button" 
                            class="checkout-button" 
                            aria-label="Proceed to checkout"
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
                
        </div>

        <div class="content">
            <div class="white-section title-section">
                <h3 class="quote">
                    “È giunto il momento di prendere a calci e masticare gomme... <br>
                    e io ho finito le gomme.”
                </h3>
                <h3 class="subtitle quote">
                    - Duke Nukem
                </h3>
                <a onclick="scrollToTop();">
                    <img src="assets/images/arrowup_red.webp" class="arrow" alt="Freccia verso l'alto" />
                </a>
            </div>
            
        </div>
        
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Rental Services. All rights reserved.</p>
    </footer>
    <script src="assets/js/menu.js"></script>
</body>
</html>
        <?php
    }
}
?>