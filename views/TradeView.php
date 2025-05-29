<?php
class TradeView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Permuta - GameStart</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Valuta e vendi i tuoi videogiochi usati con il nostro servizio di permuta. Ottieni il massimo valore per i tuoi dispositivi e giochi">
    <meta name="keywords" content="permuta videogiochi, ritiro usato, valutazione giochi, vendere console usate, scambio videogiochi">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body id="top">
    <?php
        $breadcrumb = $data['breadcrumb'];
        include 'includes/menu.php'; 
    ?>
    <main class="homepage">
        <div id="red-section">
            <!-- TEST -->

            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Permuta
                    </h1>
                    <h2 class="subtitle bright-title">
                        Ogni storia ha un valore, raccontaci la tua... Scopri quanto vale il tuo usato
                    </h2>
                    <a href="#valuation">
                        <img src="assets/img/pages/arrowdown_white.webp" class="arrow" alt="Scorri verso la sezione successiva" width="80" height="80"/>
                    </a>
                </div>
                <div id="illustration-section">
                    <img src="assets/img/pages/luckyblock.webp" id="illustration-medium" alt="Illustrazione mattoncino fortunato di 'Super Mario'" width="320"/>
                </div>
            </div>
        </div>

        <div class="gray-section" id="valuation">
            <div class="row content">
                <div class="main-card trade-card">
                        <div id="left-trade">
                            <h3>Parlaci del tuo dispositivo</h3>
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
                            <h3> Valutazione </h3>
                            <div class="row value">
                                <img src="assets/img/pages/eurocoin.webp" class="img-medium" alt="Illustrazione Euro" width="80"/>
                                <h4 class="subtitle" aria-hidden="true">X</h4>
                                <h4 id="final-rating">€0,00</h4>
                            </div>
                            
                        </div>
                    <div id="lower-trade">
                        <button id="get-rating-button">Aggiorna Valutazione</button>
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
                    - <span lang="en">Crash Bandicoot</span>
                </h3>
                <a href="#top">
                    <img src="assets/img/pages/arrowup_red.webp" class="arrow" alt="Scorri verso la sezione precedente" width="80" height="80" />
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