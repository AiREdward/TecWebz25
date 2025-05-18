<?php include 'controllers/includes/popupController.php'; ?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>Registrazione</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description"
        content="Registrati su GameStart e accedi a offerte esclusive sui migliori videogiochi per PC, PlayStation, Xbox e Nintendo. Unisciti alla community e acquista in sicurezza!">
    <meta name="keywords"
        content="registrazione GameStart, creare account GameStart, store giochi, offerte gaming, nuovo account GameStart">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>

<body>

<?php
        $breadcrumb = [
            ['name' => 'Home', 'url' => 'index.php?page=home'],
            ['name' => 'Registrazione', 'url' => 'index.php?page=registrazione']
        ];
        include 'includes/menu.php'; 
    ?>

    <?php showPopup(); ?>

    <div id="main-container">
        <selection id="welcome-container">
            <div id="welcome-text">
                <h1>Benvenuto</h1>
                <p>Registrati per entrare a far parte del nostro gruppo</p>
            </div>
        </selection>

        <selection id="register-container">
            <div id="register-box">
                <div id="brand-header">
                    <h2>Registrazione del tuo account</h2>
                    <p>Inserisci le tue informazioni per creare un account</p>
                </div>

                <form action="index.php?page=auth&action=doRegister" method="POST" class="register-form"
                    aria-labelledby="register-form">

                    <div class="auth-group">
                        <label for="username" id="username-label">Username</label>
                        <div class="input-field">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input type="text" id="username" name="username" required autocomplete="username"
                                placeholder="Inserisci username" aria-labelledby="username-label" aria-required="true">
                        </div>
                    </div>

                    <div class="auth-group">
                        <label for="email" id="email-label">Email</label>
                        <div class="input-field">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <input type="email" id="email" name="email" required autocomplete="email"
                                placeholder="Inserisci email" aria-labelledby="email-label" aria-required="true">
                        </div>
                    </div>

                    <div class="auth-group">
                        <label for="password" id="password-label">Password</label>
                        <div class="input-field">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                placeholder="Inserisci password" aria-labelledby="password-label" aria-required="true">
                            <i class="fa fa-eye toggle-password" id="togglePassword"
                                aria-label="Mostra/nascondi password"></i>
                        </div>
                    </div>

                    <div class="auth-group">
                        <label for="confirm_password">Conferma Password</label>
                        <div class="input-field">
                            <i class="fa" id="passwordMatchIcon" aria-hidden="true"></i>
                            <input type="password" id="confirm_password" name="confirm_password"
                                placeholder="Conferma la password inserita" required>
                            <i class="fa-solid fa-eye toggle-password" id="togglePassworConfirm"
                                aria-label="Mostra/nascondi password"></i>
                        </div>
                    </div>

                    <div>
                        <button type="submit" id="submit-button" aria-label="Registrati">
                            Registrati
                            <div id="button-decoration"></div>
                        </button>
                    </div>

                    <p>Hai già un account? <a href="index.php?page=auth&action=login">Accedi ora</a></p>
                </form>
            </div>
        </selection>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/menu.js"></script>
    <script src="assets/js/mostraPassword.js"></script>
    <script src="assets/js/confermaPassword.js"></script>

</body>
</html>