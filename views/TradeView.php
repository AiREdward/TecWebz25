<?php
class TradeView {
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
<body id="top">
    <?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Permuta', 'url' => 'index.php?page=trade']
        ];
        include 'includes/menu.php'; 
    ?>
    <main class="homepage">
        <div id="red-section">
            <!-- TEST -->

            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Ogni storia ha un valore, <br>
                        raccontaci la tua
                    </h1>
                    <h2 class="subtitle bright-title">
                        Scopri quanto vale il tuo usato
                    </h2>
                    <a href="#valuation">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div id="illustration-section">
                    <img src="assets/images/luckyblock.webp" id="illustration-medium" alt="Illustrazione mattoncino fortunato di Super Mario"/>
                </div>
            </div>
        </div>

        <div class="gray-section" id="valuation">
            <div id="row content">
                <div class="main-card trade-card">
                        <div id="left-trade">
                            <h2>Parlaci del tuo dispositivo</h2>
                            <!-- Creazione dinamica del form -->
                            <?php foreach ($data['categories'] as $category): ?>
                            <fieldset id="nes-radio-group">
                                <legend id="form-legend"><?php echo ucfirst(htmlspecialchars($category[0])); ?></legend>
                                <!-- <form class="radio-group-wrapper" role="radiogroup"> -->
                                <div id="radio-group-wrapper" role="radiogroup">
                                    <?php foreach ($data['ratings'] as $item): ?>
                                    <?php if ($item['categoria'] == $category[0]): ?>
                                    <label id="nes-radio">
                                        <input type="radio" 
                                                name="<?php echo htmlspecialchars($item['categoria']); ?>" 
                                                value="<?php echo htmlspecialchars($item['nome']); ?>" 
                                                class="sr-only"
                                                required>
                                        <span id="nes-btn" role="presentation">
                                            <span id="nes-led" aria-hidden="true"></span>
                                            <?php echo ucfirst(htmlspecialchars($item['nome'])); ?>
                                        </span>
                                    </label>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </fieldset>
                            <?php endforeach; ?>
                        </div>
                        <div id="vertical-line" aria-hidden="true"></div>
                        <div id="right-trade">
                            <h2> Valutazione </h2>
                            <div class="row value">
                                <img src="assets/images/eurocoin.webp" class="img-medium" alt="Euro" />
                                <h2 class="subtitle" aria-hidden="true">X</h2>
                                <h1 id="final-rating">0,00</h1>
                            </div>
                            
                        </div>
                    <div id="lower-trade">
                        <button id="get-rating-button"> Invia Proposta </button>
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
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/trade.js"></script>
</body>
</html>
        <?php
    }
}
?>