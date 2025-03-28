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
            <div class="row content">
                <div class="main-card trade-card">
                    <div class="left-trade">
                        <h2> Parlaci del tuo dispositivo </h2>
                        <!-- Radios -->
                        <h4> Tipologia </h4>
                        <div class="nes-radio-group">
                            <label class="nes-radio">
                                <input type="radio" name="tipologia" value="console" class="sr-only">
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Console
                                </span>
                            </label>

                            <label class="nes-radio">
                                <input type="radio" name="tipologia" value="controller" class="sr-only">
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Controller
                                </span>
                            </label>

                            <label class="nes-radio">
                                <input type="radio" name="tipologia" value="gioco" class="sr-only" checked>
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Gioco
                                </span>
                            </label>
                        </div>

                        <h4> Marca </h4>
                        <div class="nes-radio-group">
                            <label class="nes-radio">
                                <input type="radio" name="marca" value="sony" class="sr-only">
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Sony
                                </span>
                            </label>

                            <label class="nes-radio">
                                <input type="radio" name="marca" value="microsoft" class="sr-only" checked>
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Microsoft
                                </span>
                            </label>

                            <label class="nes-radio">
                                <input type="radio" name="marca" value="nintendo" class="sr-only">
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Nintendo
                                </span>
                            </label>
                        </div>

                        <h4> Condizioni </h4>
                        <div class="nes-radio-group">
                            <label class="nes-radio">
                                <input type="radio" name="condizioni" value="ottime" class="sr-only" checked>
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Ottime
                                </span>
                            </label>

                            <label class="nes-radio">
                                <input type="radio" name="condizioni" value="buone" class="sr-only">
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Buone
                                </span>
                            </label>

                            <label class="nes-radio">
                                <input type="radio" name="condizioni" value="scarse" class="sr-only">
                                <span class="nes-btn">
                                    <span class="nes-led"></span>
                                    Scarse
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="vertical-line" aria-hidden="true"></div>
                    <div class="">
                        <h2> Valutazione </h2>
                    </div>
                </div>
            </div>
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