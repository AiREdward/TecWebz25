<?php
class ShopView {
    public function render($data) {
        // Carica il template HTML come stringa
        $templatePath = __DIR__ . '/../template/ShopTemplate.html';
        $html = file_get_contents($templatePath);

        // Genera la lista prodotti come HTML
        $productsHtml = $this->renderProducts($data['products']);

        // Prepara i sostituti per i segnaposto
        $replacements = [
            '{{menu}}' => $this->getMenu($data),
            '{{footer}}' => $this->getFooter(),
            '{{products}}' => $productsHtml,
        ];

        // Sostituisci i segnaposto nel template
        $output = str_replace(array_keys($replacements), array_values($replacements), $html);
        echo $output;
    }

    private function getMenu($data) {
        ob_start();
        $breadcrumb = $data['breadcrumb'];
        include __DIR__ . '/includes/menu.php';
        return ob_get_clean();
    }

    private function getFooter() {
        ob_start();
        include __DIR__ . '/includes/footer.php';
        return ob_get_clean();
    }

    private function renderProducts($products) {
        ob_start();
        $recentThreshold = new DateTime('-7 days');
        $reversedProducts = array_reverse($products);
        ?>
        <ol id="products-list">
        <?php foreach ($reversedProducts as $product): 
            $productDate = new DateTime($product['data_creazione']);
            $isRecent = $productDate >= $recentThreshold;
        ?>
            <li class="product-card <?php echo $isRecent ? 'recent-product' : ''; ?>">
                <article>
                    <h3 id="product-title-<?php echo htmlspecialchars($product['id']); ?>"><?php echo htmlspecialchars($product['nome']); ?></h3>
                    <img src="<?php echo htmlspecialchars(str_replace('\\', '/', $product['immagine'])); ?>" 
                        alt="<?php echo htmlspecialchars($product['nome']); ?>" 
                        loading="lazy"
                        width="200" 
                        height="200"
                        aria-labelledby="product-title-<?php echo htmlspecialchars($product['id']); ?>">
                    <p class="prezzo">Prezzo: <abbr title="Euro">&#8364;</abbr><?php echo htmlspecialchars(number_format($product['prezzo'], 2)); ?></p>
                    <p class="genere">Genere: <?php echo htmlspecialchars($product['genere']); ?></p>
                    <?php if ($isRecent): ?>
                        <span class="badge">Nuovo!</span>
                    <?php endif; ?>
                    <div class="product-actions">
                        <button class="add-to-cart" 
                                data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                            Aggiungi <?php echo htmlspecialchars($product['nome']); ?> al carrello
                        </button>
                        <a href="index.php?page=product&id=<?php echo htmlspecialchars($product['id']); ?>" 
                           class="view-product">
                            Visualizza <?php echo htmlspecialchars($product['nome']); ?>
                        </a>
                    </div>
                </article>
            </li>
        <?php endforeach; ?>
        </ol>
        <?php
        return ob_get_clean();
    }
}
?>