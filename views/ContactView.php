<?php
class ContactView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>

    <meta name="author" content="TecWebz25">
    <meta name="description" content="Contattaci per qualsiasi informazione sui nostri prodotti e servizi">
    <meta name="keywords" content="contatti, supporto, assistenza, GameStart">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/menu.php'; ?>
    <main class="homepage">
        <div class="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Hai bisogno di aiuto?
                    </h1>
                    <h2 class="subtitle bright-title">
                        Per qualsiasi dubbio contattaci, e noi ti risponderemo il prima possibile.
                    </h2>
                </div>
                <div>
                    <img src="assets/images/iphone.webp" id="illustration" alt="iphone blueprint" />
                </div>
            </div>
        </div>
        
        <div class="content">
            <section id="contact-info" class="white-section">
                <div class="contact-container">
                    <div class="contact-details">
                        <div class="contact-item">
                            <h3>Telefono</h3>
                            <p><a href="tel:<?php echo $data['phone']; ?>" aria-label="Chiama il nostro numero di telefono"><?php echo $data['phone']; ?></a></p>
                        </div>
                        <div class="contact-item">
                            <h3>Email</h3>
                            <p><a href="mailto:<?php echo $data['email']; ?>" aria-label="Invia una email al nostro indirizzo"><?php echo $data['email']; ?></a></p>
                        </div>
                        <div class="contact-item">
                            <h3>Indirizzo</h3>
                            <p><?php echo str_replace('PD', '<abbr title="Padova">PD</abbr>', $data['address']); ?></p>
                        </div>
                    </div>
                    <div class="contact-message">
                        <p><?php echo $data['content']; ?></p>
                    </div>
                </div>
            </section>
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