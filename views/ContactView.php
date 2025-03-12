<?php
class ContactView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="contact-info">
            <div class="contact-container">
                <h2>I Nostri Contatti</h2>
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
</body>
</html>
        <?php
    }
}
?>