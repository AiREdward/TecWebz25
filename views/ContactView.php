<?php
class ContactView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Contattaci</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Contattaci per qualsiasi informazione sui nostri prodotti e servizi">
    <meta name="keywords" content="contatti, supporto, assistenza, GameStart">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>
    <?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Contattaci', 'url' => 'index.php?page=contact']
        ];
        include 'includes/menu.php'; 
    ?>

    <main class="homepage" id="top">
        <div id="red-section">
            <div class="content illustrated-title">
                <div class="title-section">
                    <h1 class="big-title bright-title">
                        Hai bisogno di aiuto?
                    </h1>
                    <h2 class="subtitle bright-title">
                        Per qualsiasi dubbio , contattaci e noi ti risponderemo al più presto.
                    </h2>
                    <a href="#ads" aria-label="Scorri verso il basso per visualizzare le informazioni di contatto">
                        <img src="assets/images/arrowdown_white.webp" class="arrow" alt="Freccia verso il basso"/>
                    </a>
                </div>
                <div aria-hidden="true">
                    <img src="assets/images/iphone.webp" id="illustration" alt="iphone blueprint" />
                </div>
            </div>
        </div>
        
        <div class="content">
            <section id="contact-info" class="white-section" aria-label="Informazioni di contatto">
                <div class="contact-container">
                    <div class="contact-details">
                        <div class="contact-item">
                            <h3 class="contact-title">
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="margin-right: 8px;" aria-hidden="true" focusable="false"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                                Telefono
                            </h3>
                            <p><a href="tel:<?php echo $data['phone']; ?>" aria-label="Chiama il nostro numero di telefono"><?php echo $data['phone']; ?></a></p>
                        </div>
                        <div class="contact-item" id="ads">
                            <h3 class="contact-title">
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="margin-right: 8px;" aria-hidden="true" focusable="false"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                                    Email
                            </h3>
                            <p><a href="mailto:<?php echo $data['email']; ?>" aria-label="Invia una email al nostro indirizzo"><?php echo $data['email']; ?></a></p>
                        </div>
                        <div class="contact-item">
                            <h3 class="contact-title">
                                <svg width="25" height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="margin-right: 8px;" aria-hidden="true" focusable="false"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                                    Indirizzo
                            </h3>
                            <p><?php echo str_replace('PD', '<abbr title="Padova">PD</abbr>', $data['address']); ?></p>
                        </div>
                    </div>
                    <div id="contact-message" role="region" aria-label="Messaggio di benvenuto">
                        <p><?php echo $data['content']; ?></p>
                    </div>                
                </div>
            </section>
        </div>
        <div class="content">
            <div class="white-section title-section" role="region" aria-label="Citazione ispirazionale">
                <h3 class="quote">
                    "Smettila di pensare... Ti viene male."
                </h3>
                <h3 class="subtitle quote">
                    - Trevor (GTA V)
                </h3>
                <a href="#top" aria-label="Torna all'inizio della pagina">
                    <img src="assets/images/arrowup_red.webp" class="arrow" alt="Freccia verso l'alto" />
                </a>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/menu.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
    <script src="assets/js/map.js"></script>
</body>
</html>
        <?php
    }
}
?>