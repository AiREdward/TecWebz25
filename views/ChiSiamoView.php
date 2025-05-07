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
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>
    <?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'HomeView.php'],
            ['name' => 'Chi Siamo', 'url' => 'ChiSiamoView.php']
        ];
        include 'includes/menu.php'; 
    ?>
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
                    <a href="#ads">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div>
                    <img src="assets/images/steam_deck_blueprint.webp" id="illustration" alt="steamdeck blueprint"/>
                </div>
            </div>
        </div>
        
        <div class="content" id="ads">
            <section id="chi-siamo" class="white-section">
                <div class="info-container">
                    <div class="info-details">
                        <div class="info-item">
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
                <a href="#top">
                    <img src="assets/images/arrowup_red.webp" class="arrow" alt="Freccia verso l'alto" />
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