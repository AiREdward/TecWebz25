<?php
include 'controllers/includes/popupController.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Accedi</title>
    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Accedi a GameStart e scopri le migliori offerte su videogiochi per PC, PlayStation, Xbox e Nintendo. Acquista i tuoi titoli preferiti in modo facile e sicuro!">
    <meta name="keywords" content="GameStart login, accesso GameStart, store giochi, offerte videogiochi">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>
    <?php showPopup(); ?>

    <?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Accedi', 'url' => 'index.php?page=accedi']
        ];
        include 'includes/menu.php'; 
    ?>

    <div id="main-container" role="main">
        <selection id="welcome-container">
            <div id="welcome-text">
                <h1>Bentornato</h1>
                <p>Accedi per continuare la tua visita al nostro sito</p>
            </div>
        </selection>

        <selection id="login-container">
            <div id="login-box" role="region" aria-labelledby="login-heading">
                <div id="brand-header">
                    <h2 id="login-heading">Accedi al tuo account</h2>
                    <p>Inserisci le tue credenziali per continuare</p>
                </div>

                <form id="login-form" action="index.php?page=auth&action=doLogin" method="POST" aria-labelledby="login-form">
                    <div class="auth-group">
                        <label for="email" id="email-label">Email o Username</label>
                        <div class="input-field">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input type="text" id="email" name="email" required autocomplete="username" aria-labelledby="email-label" aria-required="true" placeholder="Inserisci la tua email o username">
                        </div>
                    </div>

                    <div class="auth-group">
                        <label for="password" id="password-label">Password</label>
                        <div class="input-field">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input type="password" id="password" name="password" required autocomplete="current-password" aria-labelledby="password-label" aria-required="true" placeholder="Inserisci la tua password">
                            <i class="fa fa-eye toggle-password" id="togglePassword" aria-label="Mostra/nascondi password"></i>
                        </div>
                    </div>

                    <?php
                    // Imposta il valore di redirect se presente nella sessione
                    $redirectValue = isset($_SESSION['redirect_after_login']) ? htmlspecialchars($_SESSION['redirect_after_login']) : '';
                    ?>
                    <input type="hidden" name="redirect" value="<?php echo $redirectValue; ?>">
                    
                    <button type="submit" id="submit-button">
                        <span>Accedi</span>
                        <div id="button-decoration" aria-hidden="true"></div>
                    </button>

                    <p>Non hai un account? <a href="index.php?page=auth&action=register">Registrati ora</a></p>
                </form>
            </div>
        </selection>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/mostraPassword.js"></script>
</body>
</html>
