<?php
class HomeView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Home - GameStart</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="GameStart - Il negozio di videogiochi dove gli altri fermano il gioco, noi lo facciamo iniziare">
    <meta name="keywords" content="videogiochi, console, gaming, shop online, giochi">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
    <link rel="preload" href="assets/img/pages/nesexploded_white.webp" as="image" fetchpriority="high">
</head>
<body id="top">
    <?php 
        $breadcrumb = $data['breadcrumb'];
        include 'includes/menu.php';
    ?>

    <main class="homepage">
        <div id="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        <span lang="en">GameStart</span>
                    </h1>
                    <h2 class="subtitle bright-title">
                        Dove gli altri fermano il gioco, noi lo facciamo iniziare
                    </h2>
                    <a href="#ads" aria-label="Scorri per scoprire le nostre offerte">
                        <img src="assets/img/pages/arrowdown_white.webp" class="arrow" alt="Scorri verso la sezione successiva" width="80" height="80" loading="lazy"/>
                        <img src="assets/img/pages/arrowdown_white.webp" class="arrow" alt="Scorri verso la sezione successiva" width="80" height="80"/>
                </div>
                <div aria-hidden="true">
                    <img src="assets/img/pages/nesexploded_white.webp" id="illustration" alt="Illustrazione piattaforma smontata" width="600" height="463.8" fetchpriority="high" decoding="async"/>
                    <img src="assets/img/pages/nesexploded_white.webp" id="illustration" alt="Illustrazione piattaforma smontata" width="600" height="463.8"/>
            </div>
            
        </div>

        <div class="gray-section" id="ads" aria-label="Le nostre offerte">
            <div class="row content">
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/img/pages/copertina_negozio.webp" alt="Illustrazione telefono e pulsantiera" width="346.43" height="272" loading="lazy"/>
                        <img src="assets/img/pages/copertina_negozio.webp" alt="Illustrazione telefono e pulsantiera" width="346.43" height="272"/>
                    <div class="ad-card-description">
                        <img src="assets/img/pages/arrowright_black.webp" class="arrow-small" alt="Vai allo shop" aria-hidden="true" width="48" height="48" loading="lazy"/>
                        <img src="assets/img/pages/arrowright_black.webp" class="arrow-small" alt="Vai allo shop" aria-hidden="true" width="48" height="48"/>
                    </div>
                </div>

                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/img/pages/copertina_permuta.webp" alt="Illustrazione piattaforma con doppio schermo" width="346.43" height="272" loading="lazy"/>
                        <img src="assets/img/pages/copertina_permuta.webp" alt="Illustrazione piattaforma con doppio schermo" width="346.43" height="272"/>
                    <div class="ad-card-description">
                        <img src="assets/img/pages/arrowright_black.webp" class="arrow-small" alt="Vai allo shop" aria-hidden="true" width="48" height="48" loading="lazy"/>
                        <img src="assets/img/pages/arrowright_black.webp" class="arrow-small" alt="Vai allo shop" aria-hidden="true" width="48" height="48"/>
                    </div>
                </div>

                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/img/pages/copertina_chisiamo.webp" alt="Illustrazione stretta di mano tra due persone" width="346.43" height="272" loading="lazy"/>
                        <img src="assets/img/pages/copertina_chisiamo.webp" alt="Illustrazione stretta di mano tra due persone" width="346.43" height="272"/>
                    <div class="ad-card-description">
                        <img src="assets/img/pages/arrowright_black.webp" class="arrow-small" alt="Vai allo shop" aria-hidden="true" width="48" height="48" loading="lazy"/>
                        <img src="assets/img/pages/arrowright_black.webp" class="arrow-small" alt="Vai allo shop" aria-hidden="true" width="48" height="48"/>
                    </div>
                </div>
            </div>
                
        </div>

        <div class="content">
            <div class="white-section title-section" role="region" aria-label="Citazione ispirazionale">
                <h3 class="quote">
                    "È giunto il momento di prendere a calci e masticare gomme... e io ho finito le gomme."
                </h3>
                <h3 class="subtitle quote">
                    - <span lang="en">Duke Nukem</span>
                </h3>
                <a href="#top" aria-label="Torna all'inizio della pagina">
                    <img src="assets/img/pages/arrowup_red.webp" class="arrow" alt="Scorri verso la sezione precedente" width="80" height="80" loading="lazy"/>
                    <img src="assets/img/pages/arrowup_red.webp" class="arrow" alt="Scorri verso la sezione precedente" width="80" height="80" />
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