<?php
class HomeView {
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
                        Dove gli altri fermano il gioco, <br>
                        noi lo facciamo iniziare
                    </h1>
                    <h2 class="subtitle bright-title">
                        Partecipa subito alla nostra rivoluzione
                    </h2>
                    <a href="#ads">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div>
                    <img src="assets/images/nesexploded_white.webp" id="illustration" alt="Illustrazione gamepad smontato"/>
                </div>
            </div>
            
        </div>

        <div class="gray-section" id="ads">
            <div class="row content">
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp" alt="Foto Nintendo Switch 2"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra"/>
                        <a href="index.php?page=shop"> Scopri il nostro Shop! </a>
                    </div>
                </div>

                <!-- DUMMY DA RIMUOVERE -->
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp" alt="Foto Nintendo Switch 2"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra"/>
                        <a href="index.php?page=shop"> Scopri il nostro Shop! </a>
                    </div>
                </div>

                <!-- DUMMY DA RIMUOVERE -->
                <div class="main-card ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp" alt="Foto Nintendo Switch 2"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" alt="Freccia verso destra"/>
                        <a href="index.php?page=shop"> Scopri il nostro Shop! </a>
                    </div>
                </div>
            </div>
                
        </div>

        <div class="content">
            <div class="white-section title-section">
                <h3 class="quote">
                    “È giunto il momento di prendere a calci e masticare gomme... <br>
                    e io ho finito le gomme.”
                </h3>
                <h3 class="subtitle quote">
                    - Duke Nukem
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