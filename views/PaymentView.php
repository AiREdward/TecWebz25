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
</head>
<body>
    <?php include 'includes/menu.php'; ?>
    <main>
        <h1><?php echo $data['header']; ?></h1>
        <?php if (isset($data['error'])): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($data['error']); ?></p>
            </div>
        <?php endif; ?>
        

        
        <div class="payment-container">
            <div class="cart-summary">
                <h2>Riepilogo Carrello</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Prodotto</th>
                            <th>Quantità</th>
                            <th>Prezzo</th>
                            <th>Totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['cartItems'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>€<?php echo number_format($item['prezzo'], 2); ?></td>
                                <td>€<?php echo number_format($item['prezzo'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Totale</strong></td>
                            <td><strong>€<?php echo number_format($data['total'], 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="payment-form">
                <h2>Dati di Pagamento</h2>
                <form id="payment-form" method="post" action="index.php?page=payment&action=process">
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
                
                // Format card number as user types (add spaces every 4 digits)
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
                
                // Format expiry date as MM/YY
                expiryDate.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^0-9]/gi, '');
                    
                    if (value.length > 2) {
                        e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    } else {
                        e.target.value = value;
                    }
                });
                
                // Allow only numbers for CVV
                cvv.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/[^0-9]/gi, '');
                });
                
                // Form validation on submit
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    
                    // Reset errors
                    document.querySelectorAll('.error').forEach(el => {
                        el.style.display = 'none';
                    });
                    
                    // Validate card holder
                    if (!cardHolder.value.trim()) {
                        document.getElementById('card-holder-error').style.display = 'block';
                        isValid = false;
                    }
                    
                    // Validate card number
                    const cardNumberValue = cardNumber.value.replace(/\s+/g, '');
                    if (cardNumberValue.length !== 16 || !/^\d+$/.test(cardNumberValue)) {
                        document.getElementById('card-number-error').style.display = 'block';
                        isValid = false;
                    }
                    
                    // Validate expiry date
                    const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
                    if (!expiryPattern.test(expiryDate.value)) {
                        document.getElementById('expiry-date-error').style.display = 'block';
                        isValid = false;
                    }
                    
                    // Validate CVV
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
</body>
</html>
        <?php
    }
    
    public function renderSuccess($data) {
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
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>

        
        <div class="success-container">
            <div class="success-message">
                <h2>Pagamento Completato con Successo</h2>
                <p><?php echo htmlspecialchars($data['message']); ?></p>
                <p>Numero Ordine: <strong><?php echo htmlspecialchars($data['order_id']); ?></strong></p>
                <div class="success-actions">
                    <a href="index.php?page=home" class="btn">Torna alla Home</a>
                    <a href="index.php?page=shop" class="btn">Continua lo Shopping</a>
                </div>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/menu.js"></script>
</body>
</html>
        <?php
    }
}
?>