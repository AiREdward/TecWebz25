<?php
class ChiSiamoView {
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
    <main class="homepage">
        <div class="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Chi Siamo
                    </h1>
                    <h2 class="subtitle bright-title">
                        Scopri la nostra storia e la passione che ci guida
                    </h2>
                </div>
                <div>
                    <img src="assets/images/steam_deck_blueprint.webp" id="illustration" />
                </div>
            </div>
        </div>
        
        <div class="content">
            <section id="chi-siamo" class="white-section">
                <div class="contact-container">
                    <div class="contact-details">
                        <div class="contact-item">
                            <?php echo $data['content']; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/script.js"></script>
</body>
</html>
        <?php
    }
}
?>