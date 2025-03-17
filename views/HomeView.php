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
<body>
    <!-- <header>
        <h1><?php echo $data['header']; ?></h1>
    </header> -->
    <?php include 'includes/menu.php'; ?>
    <main class="homepage">
        <!-- <section id="intro">
            <p><?php echo $data['content']; ?></p>
        </section> -->
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
                    <a onclick="scrollToId('ads');">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" />
                    </a>
                </div>
                <div>
                    <img src="assets/images/nesexploded_white.webp" id="illustration" />
                </div>
            </div>
            
        </div>

        <div class="gray-section">
            <div class="row content" id="ads">
                <div class="ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" />
                        <a href="index.php?page=shop"> Scopri il nostro Shop! </a>
                    </div>
                </div>

                <!-- DUMMY DA RIMUOVERE -->
                <div class="ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" />
                        <a href="index.php?page=shop"> Scopri il nostro Shop! </a>
                    </div>
                </div>

                <!-- DUMMY DA RIMUOVERE -->
                <div class="ad-card">
                    <div class="crt-image">
                        <img src="assets/images/nintendoswitch.webp"/>
                    </div>
                    <div class="ad-card-description">
                        <img src="assets/images/arrowright_black.webp" class="arrow-small" />
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
                <a onclick="scrollToTop();">
                    <img src="assets/images/arrowup_red.webp" class="arrow" />
                </a>
            </div>
            
        </div>
        
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/script.js"></script>
</body>
</html>
        <?php
    }
}
?>