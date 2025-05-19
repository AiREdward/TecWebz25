<?php
class HomeView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="GameStart - Il negozio di videogiochi dove gli altri fermano il gioco, noi lo facciamo iniziare">
    <meta name="keywords" content="videogiochi, console, gaming, shop online, giochi">
    <meta name="viewport" content="width=device-width>

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body id="top">
    <?php 
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home']
        ];

        include 'includes/menu.php';
    ?>

    <main class="homepage">
        <div id="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Dove gli altri fermano il gioco, <br>
                        noi lo facciamo iniziare
                    </h1>
                    <h2 class="subtitle bright-title">
                        Partecipa subito alla nostra rivoluzione
                    </h2>
                    <a href="#ads" aria-label="Scorri per scoprire le nostre offerte">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div aria-hidden="true">
                    <img src="assets/images/nesexploded_white.webp" id="illustration" alt="Illustrazione gamepad smontato"/>
                </div>
            </div>
            
        </div>

        <div class="gray-section" id="ads" aria-label="Le nostre offerte">
            <div id="row content">
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/images/copertina_negozio.webp" alt="Copertina Pagina Negozio, ritrae un telefono ed un telecomando"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra" aria-hidden="true"/>
                        <a href="index.php?page=shop" aria-label="Visita il nostro negozio online"> Scopri il nostro Shop! </a>
                    </div>
                </div>

                <!-- DUMMY DA RIMUOVERE -->
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/images/copertina_permuta.webp" alt="Copertina Pagina Permuta, ritrae un vecchio videogioco"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra" aria-hidden="true"/>
                        <a href="index.php?page=trade" aria-label="Scopri come valutare i tuoi videogiochi usati"> Valuta subito il tuo usato! </a>
                    </div>
                </div>

                <!-- DUMMY DA RIMUOVERE -->
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/images/copertina_chisiamo.webp" alt="Copertina pagina Chi Siamo, ritrae una stretta di mano"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra" aria-hidden="true"/>
                        <a href="index.php?page=chi-siamo" aria-label="Scopri chi siamo e la nostra visione"> Conosci la nostra visione! </a>
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
                    - Duke Nukem
                </h3>
                <a href="#top" aria-label="Torna all'inizio della pagina">
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