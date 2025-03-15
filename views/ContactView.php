<?php
class ContactView {
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
        <section id="contact-info">
            <div class="contact-container">
                <div class="contact-details">
                    <div class="contact-item">
                        <h3>Telefono</h3>
                        <p><?php echo $data['phone']; ?></p>
                    </div>
                    <div class="contact-item">
                        <h3>Email</h3>
                        <p><?php echo $data['email']; ?></p>
                    </div>
                    <div class="contact-item">
                        <h3>Indirizzo</h3>
                        <p><?php echo $data['address']; ?></p>
                    </div>
                </div>
                <div class="contact-message">
                    <p><?php echo $data['content']; ?></p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> TecWebz25. Tutti i diritti riservati.</p>
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
        <?php
    }
}
?>