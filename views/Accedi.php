<?php
include 'controllers/includes/popupController.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Accedi</title>
    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php showPopup(); ?>

    <?php include 'includes/menu.php'; ?>
    <div class="main-container">
        <div class="welcome-container">
            <div class="welcome-text">
                <h1>Bentornato</h1>
                <p>Accedi per continuare il tuo viaggio con noi</p>
            </div>
        </div>

        <div class="login-container">
            <div class="login-box">
                <div class="brand-header">
                    <h2>Accedi al tuo account</h2>
                    <p>Inserisci le tue credenziali per continuare</p>
                </div>

                <form action="index.php?page=auth&action=doLogin" method="POST" class="login-form" aria-labelledby="login-form">
                    <div class="form-group">
                        <label for="email" id="email-label">Email o Username</label>
                        <div class="input-field">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input type="text" id="email" name="email" required autocomplete="username" aria-labelledby="email-label" aria-required="true" placeholder="Inserisci la tua email o username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" id="password-label">Password</label>
                        <div class="input-field">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input type="password" id="password" name="password" required autocomplete="current-password" aria-labelledby="password-label" aria-required="true" placeholder="Inserisci la tua password">
                            <i class="fa fa-eye toggle-password" id="togglePassword" aria-label="Mostra/nascondi password"></i>
                        </div>
                    </div>

                    <input type="hidden" name="redirect" value="">
                    
                    <button type="submit" class="submit-button">
                        <span>Accedi</span>
                        <div class="button-decoration"></div>
                    </button>

                    Non hai un account? <a href="index.php?page=auth&action=register">Registrati ora</a>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="assets/js/script.js"></script>
    <script src="assets/js/mostraPassword.js"></script>
</body>
</html>
