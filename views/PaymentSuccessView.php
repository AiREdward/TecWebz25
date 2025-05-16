<?php

class PaymentSuccessView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>
    <?php include 'includes/menu.php'; ?>
    <main>
        <div id="success-container">
        <header>
            <h1><?php echo $data['header']; ?></h1>
        </header>
            <div id="success-message">
                <h2>Pagamento Completato con Successo</h2>
                <p><?php echo htmlspecialchars($data['message']); ?></p>
                <p>Numero Ordine: <strong><?php echo htmlspecialchars($data['order_id']); ?></strong></p>
                <div id="success-actions">
                    <a href="index.php?page=home" class="btn">Torna alla Home</a>
                    <a href="index.php?page=shop" class="btn">Continua lo Shopping</a>
                </div>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/payment.js"></script>
    <script src="assets/js/cleanCart.js"></script>
</body>
</html>
        <?php
    }
}
?>