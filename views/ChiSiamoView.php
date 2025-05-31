<?php
class ChiSiamoView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Chi Siamo - GameStart</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Scopri la storia di GameStart, la nostra missione e i valori che ci guidano nel fornire i migliori prodotti e servizi per i videogiocatori">
    <meta name="keywords" content="chi siamo, storia GameStart, missione, valori, team GameStart, negozio videogiochi">
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
                        <img src="assets/img/pages/arrowdown_white.svg" class="arrow" alt="Scorri verso la sezione successiva" width="80" height="80"/>
                    </a>
                </div>
                <div>
                    <img src="assets/img/pages/steam_deck_blueprint.webp" id="illustration" alt="Illustrazione piattaforma" width="800"/>
                </div>
            </div>
        </div>
        
        <div class="content" id="ads">
            <section id="chi-siamo" class="white-section" aria-labelledby="chi-siamo-title">
                <div id="info-container">
                    <div class="info-box intro-box">
                        <?php echo $data['content1']; ?>
                    </div>
                    
                    <div class="mission-why-container">
                        <div class="info-box mission-box">
                            <?php echo $data['content6']; ?>
                        </div>
                        
                        <div class="info-box why-us-box">
                            <?php echo $data['content7']; ?>
                        </div>
                    </div>
                    
                    <div class="info-box intro-box">
                        <?php echo $data['content2']; ?>
                    </div>
                    
                    <div class="services-container">
                        <div class="info-box service-box">
                            <?php echo $data['content3']; ?>
                        </div>
                        
                        <div class="info-box service-box">
                            <?php echo $data['content5']; ?>
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
                    - Kratos (<span lang="en">God of War</span>)
                </h3>
                <a href="#top" aria-label="Torna all'inizio della pagina" class="scroll-link">
                    <img src="assets/img/pages/arrowup_red.svg" class="arrow" alt="Scorri verso la sezione precedente" width="80" height="80" />
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