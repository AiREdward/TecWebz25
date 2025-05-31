<?php

class PaymentSuccessView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Pagamaneto Eseguito</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Conferma del pagamento avvenuto con successo. Grazie per il tuo acquisto su GameStart">
    <meta name="keywords" content=""> 
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
        <div id="success-container">
        <header>
            <h1><?php echo $data['header']; ?></h1>
        </header>
            <div id="success-message">
                <h2>Pagamento Completato con Successo</h2>
                <p><?php echo htmlspecialchars($data['message']); ?></p>
                <p>Numero Ordine: <strong><?php echo htmlspecialchars($data['order_id']); ?></strong></p>
                <div id="success-actions">
                    <a href="index.php?page=home" class="btn">Torna alla <span lang="en">Home</span></a>
                    <a href="index.php?page=shop" class="btn">Continua lo <span lang="en">Shopping</span></a>
                </div>
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