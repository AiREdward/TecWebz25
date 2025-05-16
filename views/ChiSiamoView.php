<?php
class ChiSiamoView {
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
    <?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Chi Siamo', 'url' => 'index.php?page=chi-siamo']
        ];
        include 'includes/menu.php'; 
    ?>
    <main class="homepage" id="top" role="main" aria-labelledby="page-title">
        <div id="red-section" role="region" aria-labelledby="page-title">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title" id="page-title">
                        Chi Siamo
                    </h1>
                    <h2 class="subtitle bright-title" id="page-subtitle">
                        Scopri la nostra storia e la passione che ci guida
                    </h2>
                    <a href="#ads" aria-label="Scorri verso il contenuto principale" class="scroll-link">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso per scorrere alla sezione successiva"/>
                    </a>
                </div>
                <div>
                    <img src="assets/images/steam_deck_blueprint.webp" id="illustration" alt="steamdeck blueprint"/>
                </div>
            </div>
        </div>
        
        <div class="content" id="ads">
            <section id="chi-siamo" class="white-section" aria-labelledby="chi-siamo-title">
                <div id="info-container">
                    <div id="info-details">
                        <div id="info-item">
                            <?php echo $data['content']; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="content">
            <div class="white-section title-section" role="region" aria-label="Citazione ispirazionale">
                <h3 class="quote">
                    "Non confondere la mia calma con debolezza"
                </h3>
                <h3 class="subtitle quote">
                    - Kratos (God of War)
                </h3>
                <a href="#top" aria-label="Torna all'inizio della pagina" class="scroll-link">
                    <img src="assets/images/arrowup_red.webp" class="arrow" alt="Torna all'inizio della pagina" />
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