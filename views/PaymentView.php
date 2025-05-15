<?php

class PaymentView {
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
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>
    <?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Shop', 'url' => 'index.php?page=shop'],
            ['name' => 'Pagamento', 'url' => 'index.php?page=payment']
        ];
        include 'includes/menu.php'; 
    ?>
    <main>
        <h1><?php echo $data['header']; ?></h1>
        <?php if (isset($data['error'])): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($data['error']); ?></p>
            </div>
        <?php endif; ?>
        

        
        <div class="payment-container">
            <div class="payment-summary">
                <h2>Riepilogo Carrello</h2>
                <div class="payment-items-list">
                    <?php foreach ($data['cartItems'] as $item): ?>
                        <div class="payment-item">
                            <div class="payment-item-image">
                                <?php if(isset($item['immagine'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['immagine']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['nome']); ?>" 
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
                            <div class="payment-item-total">
                                <span class="label">Totale:</span>
                                <span class="value">€<?php echo number_format($item['prezzo'] * $item['quantity'], 2); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="payment-total">
                        <span class="label"><strong>Totale Ordine</strong></span>
                        <span class="value"><strong>€<?php echo number_format($data['total'], 2); ?></strong></span>
                    </div>
                </div>
            </div>
            
            <div class="payment-form">
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
                    
                    <div class="expiry-cvv">
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
                    
                    <button type="submit" class="btn-pay">Procedi al Pagamento</button>
                </form>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('payment-form');
                const cardNumber = document.getElementById('card-number');
                const expiryDate = document.getElementById('expiry-date');
                const cvv = document.getElementById('cvv');
                const cardHolder = document.getElementById('card-holder');
                

                cardNumber.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = '';
                    
                    for (let i = 0; i < value.length; i++) {
                        if (i > 0 && i % 4 === 0) {
                            formattedValue += ' ';
                        }
                        formattedValue += value[i];
                    }
                    
                    e.target.value = formattedValue;
                });
                
                expiryDate.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^0-9]/gi, '');
                    
                    if (value.length > 2) {
                        e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    } else {
                        e.target.value = value;
                    }
                });
                
                cvv.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/[^0-9]/gi, '');
                });
                
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    
                    document.querySelectorAll('.error').forEach(el => {
                        el.style.display = 'none';
                    });
                    
                    if (!cardHolder.value.trim()) {
                        document.getElementById('card-holder-error').style.display = 'block';
                        isValid = false;
                    }
                    
                    const cardNumberValue = cardNumber.value.replace(/\s+/g, '');
                    if (cardNumberValue.length !== 16 || !/^\d+$/.test(cardNumberValue)) {
                        document.getElementById('card-number-error').style.display = 'block';
                        isValid = false;
                    }
                    
                    const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
                    const expiryValue = expiryDate.value;
                    let expiryValid = expiryPattern.test(expiryValue);
                    let cardExpired = false;

                    if (expiryValid) {
                        const [expiryMonth, expiryYearShort] = expiryValue.split('/');
                        const expiryYear = parseInt('20' + expiryYearShort, 10);
                        const currentYear = new Date().getFullYear();
                        const currentMonth = new Date().getMonth() + 1;

                        if (expiryYear < currentYear || (expiryYear === currentYear && parseInt(expiryMonth, 10) < currentMonth)) {
                            cardExpired = true;
                            expiryValid = false; 
                        }
                    }

                    if (!expiryValid) {
                        const expiryErrorElement = document.getElementById('expiry-date-error');
                        expiryErrorElement.textContent = cardExpired ? 'La carta è scaduta' : 'Inserisci una data di scadenza valida (MM/AA)';
                        expiryErrorElement.style.display = 'block';
                        isValid = false;
                    }
                    
                    if (!/^\d{3,4}$/.test(cvv.value)) {
                        document.getElementById('cvv-error').style.display = 'block';
                        isValid = false;
                    }
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    </main>
    
    <footer>
        <p>© <?php echo date('Y'); ?> GameStart. Tutti i diritti riservati.</p>
    </footer>
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/payment.js"></script>
</body>
</html>
        <?php
    }
}
?>