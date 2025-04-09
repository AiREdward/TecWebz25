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
    <main class="homepage" id="top">
        <div class="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Chi Siamo
                    </h1>
                    <h2 class="subtitle bright-title">
                        Scopri la nostra storia e la passione che ci guida
                    </h2>
                    <a href="#ads" aria-label="Vai alla sezione Chi Siamo">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                        <span class="sr-only">Scorri verso il basso per scoprire chi siamo</span>
                    </a>
                </div>
                <div>
                    <img src="assets/images/steam_deck_blueprint.webp" id="illustration" alt="steamdeck blueprint"/>
                </div>
            </div>
        </div>
        
        <div class="content" id="ads">
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
        <div class="content">
            <div class="white-section title-section">
                <h3 class="quote">
                    “Non confondere la mia calma con debolezza”
                </h3>
                <h3 class="subtitle quote">
                    - Kratos (God of War)
                </h3>
                <a href="#top" aria-label="Torna all'inizio della pagina">
                    <img src="assets/images/arrowup_red.webp" class="arrow" alt="Freccia verso l'alto" />
                    <span class="sr-only">Torna all'inizio della pagina</span>
                </a>
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