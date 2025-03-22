<?php include 'controllers/includes/popupController.php'; ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Registrazione</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>
<body>

<?php include 'includes/menu.php'; ?>

<?php showPopup(); ?>

<div class="main-container">
    <div class="welcome-container">
        <div class="welcome-text">
            <h1>Benvenuto</h1>
            <p>Registrati per iniziare il tuo viaggio con noi</p>
        </div>
    </div>

    <div class="register-container">
        <div class="register-box">
            <div class="brand-header">
                <h2>Registrazione del tuo account</h2>
                <p>Inserisci le tue informazioni per creare un account</p>
            </div>

            <form action="index.php?page=auth&action=doRegister" method="POST" class="register-form" aria-labelledby="register-form">
                
                <div class="form-group">
                    <label for="username" id="username-label">Username</label>
                    <div class="input-field">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <input type="text" id="username" name="username" required autocomplete="username" placeholder="Inserisci username" aria-labelledby="username-label" aria-required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" id="email-label">Email</label>
                    <div class="input-field">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <input type="email" id="email" name="email" required autocomplete="email" placeholder="Inserisci email" aria-labelledby="email-label" aria-required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" id="password-label">Password</label>
                    <div class="input-field">
                        <i class="fas fa-lock" aria-hidden="true"></i>
                        <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Inserisci password" aria-labelledby="password-label" aria-required="true">
                        <i class="fa fa-eye toggle-password" id="togglePassword" aria-label="Mostra/nascondi password"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Conferma Password</label>
                    <div class="input-field">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <div>
                    <button type="submit" class="submit-button" aria-label="Registrati">
                        Registrati
                        <div class="button-decoration"></div>
                    </button>
                </div>

                Hai già un account? <a href="index.php?page=auth&action=login">Accedi ora</a>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/script.js"></script>
<script src="assets/js/mostraPassword.js"></script>

</body>
</html>
