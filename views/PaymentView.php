<?php

class PaymentView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Pagamento</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Completa il tuo acquisto in modo sicuro. Inserisci i dati di pagamento per finalizzare l'ordine dei tuoi prodotti">
    <meta name="keywords" content=""> <!-- non inseriamo kewyowrds perchè questa pagina non può essere accessibile tramite navigazione -->
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
            ['name' => 'Pagamento', 'url' => 'index.php?page=payment']
        ];
        include 'includes/menu.php'; 
    ?>
    <main>
        <h1><?php echo $data['header']; ?></h1>
        <?php if (isset($data['error'])): ?>
            <div id="error-message">
                <p><?php echo htmlspecialchars($data['error']); ?></p>
            </div>
        <?php endif; ?>
        

        
        <div id="payment-container">
            <div id="payment-summary">
                <h2>Riepilogo Carrello</h2>
                <div id="payment-items-list">
                    <?php foreach ($data['cartItems'] as $item): ?>
                        <div id="payment-item">
                            <div id="payment-item-image">
                                <?php if(isset($item['immagine'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['immagine']); ?>" 
                                         alt="Prodotto <?php echo htmlspecialchars($item['nome']); ?>" 
                                         width="150" 
                                         height="150">
                                <?php endif; ?>
                            </div>
                            <div id="payment-item-details">
                                <div id="payment-item-name">
                                    <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                                </div>
                                <div id="payment-item-price">
                                        <span class="label">Prezzo:</span>
                                        <span class="value">€<?php echo number_format($item['prezzo'], 2); ?></span>
                                    </div>
                                <div id="payment-item-info">
                                    <div id="payment-item-quantity">
                                        <span class="label">Quantità:</span>
                                        <div id="quantity-controls">
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
                        <span class="value"><strong>€<?php echo number_format($data['total'], 2); ?></strong></span>
                    </div>
                </div>
            </div>
            
            <div id="payment-form-container">
                <h2>Dati di Pagamento</h2>
                <form id="payment-form" method="post" action="index.php?page=payment&action=process">
                    <input type="hidden" id="cart-data-input" name="cartData" value='<?php echo htmlspecialchars($_SESSION["cartData"] ?? ""); ?>'>
                    <div class="form-group">
                        <label for="card-holder">Intestatario Carta</label>
                        <input type="text" id="card-holder" name="card-holder" required>
                        <div id="card-holder-error" class="error">Inserisci il nome dell'intestatario della carta</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="card-number">Numero Carta</label>
                        <input type="text" id="card-number" name="card-number" required maxlength="19" placeholder="XXXX XXXX XXXX XXXX">
                        <div id="card-number-error" class="error">Inserisci un numero di carta valido (16 cifre)</div>
                    </div>
                    
                    <div id="expiry-cvv">
                        <div class="form-group">
                            <label for="expiry-date">Data di Scadenza</label>
                            <input type="text" id="expiry-date" name="expiry-date" required placeholder="MM/AA" maxlength="5">
                            <div id="expiry-date-error" class="error">Inserisci una data di scadenza valida (MM/AA)</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" required maxlength="4">
                            <div id="cvv-error" class="error">Inserisci un CVV valido (3 o 4 cifre)</div>
                        </div>
                    </div>
                    
                    <button type="submit" id="btn-pay">Procedi al Pagamento</button>
                </form>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/payment.js"></script>
</body>
</html>
        <?php
    }
}
?>