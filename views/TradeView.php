<?php
class TradeView {
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
<body id="top">
    <?php include 'includes/menu.php'; ?>
    <main class="homepage">
        <div class="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Ogni storia ha un valore, <br>
                        raccontaci la tua
                    </h1>
                    <h2 class="subtitle bright-title">
                        Scopri quanto vale il tuo usato
                    </h2>
                    <a href="">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div class="illustration-section">
                    <img src="assets/images/luckyblock.webp" id="illustration-medium" alt="Illustrazione mattoncino fortunato di Super Mario"/>
                </div>
            </div>
            
        </div>

        <div class="gray-section">
            
                
        </div>

        <div class="content">
            <div class="white-section title-section">
                <h3 class="quote">
                    “Waaaaa - aaaaaaaaaa”
                </h3>
                <h3 class="subtitle quote">
                    - Crash Bandicoot
                </h3>
                <a href="#top">
                    <img src="assets/images/arrowup_red.webp" class="arrow" alt="Freccia verso l'alto" />
                </a>
            </div>
            
        </div>
        
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Trade Services. All rights reserved.</p>
    </footer>
    <script src="assets/js/menu.js"></script>
</body>
</html>
        <?php
    }
}
?>