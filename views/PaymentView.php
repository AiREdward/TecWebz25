<?php
require_once __DIR__ . '/../controllers/includes/popupController.php';

class PaymentView {
    public function render($data) {
        // Carica il template HTML come stringa
        $templatePath = __DIR__ . '/../template/PaymentTemplate.html';
        $html = file_get_contents($templatePath);

        // Genera la lista carrello come HTML
        $cartItemsHtml = $this->renderCartItems($data['cartItems']);
        $errorHtml = isset($data['error']) ? '<div id="error-message"><p>' . htmlspecialchars($data['error']) . '</p></div>' : '';

        // Prepara i sostituti per i segnaposto
        $replacements = [
            '{{menu}}' => $this->getMenu($data),
            '{{footer}}' => $this->getFooter(),
            '{{header}}' => htmlspecialchars($data['header']),
            '{{cart_items}}' => $cartItemsHtml,
            '{{total}}' => number_format($data['total'], 2),
            '{{cart_data}}' => htmlspecialchars($_SESSION["cartData"] ?? ""),
            '{{error}}' => $errorHtml,
        ];

        // Sostituisci i segnaposto nel template
        $output = str_replace(array_keys($replacements), array_values($replacements), $html);

        showPopup();

        // Stampa l'output finale
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

    private function renderCartItems($cartItems) {
        ob_start();
        foreach ($cartItems as $item): ?>
            <div class="payment-item">
                <div class="payment-item-image">
                    <?php if(isset($item['immagine'])): ?>
                        <img src="<?php echo htmlspecialchars($item['immagine']); ?>" 
                             alt="Prodotto <?php echo htmlspecialchars($item['nome']); ?>" 
                             width="150" 
                             height="150">
                    <?php endif; ?>
                </div>
                <div class="payment-item-details">
                    <div class="payment-item-name">
                        <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                    </div>
                    <div class="payment-item-price">
                        <span class="label">Prezzo:</span>
                        <span class="value">€<?php echo number_format($item['prezzo'], 2); ?></span>
                    </div>
                    <div class="payment-item-info">
                        <div class="payment-item-quantity">
                            <span class="label">Quantità:</span>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn decrease" data-product-id="<?php echo htmlspecialchars($item['id']); ?>" aria-label="Diminuisci quantità">-</button>
                                <span class="value quantity-value" data-product-id="<?php echo htmlspecialchars($item['id']); ?>" data-price="<?php echo htmlspecialchars($item['prezzo']); ?>"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                <button type="button" class="quantity-btn increase" data-product-id="<?php echo htmlspecialchars($item['id']); ?>" aria-label="Aumenta quantità">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payment-item-total">
                    <span class="label">Totale:</span>
                    <span class="value">€<?php echo number_format($item['prezzo'] * $item['quantity'], 2); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
        <div id="payment-total">
            <span class="label"><strong>Totale Ordine</strong></span>
            <span class="value"><strong>€{{total}}</strong></span>
        </div>
        <?php
        return ob_get_clean();
    }
}
?>