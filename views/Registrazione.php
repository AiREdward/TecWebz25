<?php include 'controllers/includes/popupController.php'; ?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Registrazione - GameStart</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Registrati su GameStart e accedi a offerte esclusive sui migliori videogiochi per PC, PlayStation, Xbox e Nintendo. Unisciti alla community e acquista in sicurezza!">
    <meta name="keywords" content="registrazione GameStart, creare account GameStart, store giochi, offerte gaming, nuovo account GameStart">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaQuery.css">
</head>

<body>
    <?php
        include 'includes/menu.php'; 
        showPopup(); 
    ?>

    <main id="main-container">
        <section id="welcome-container">
            <article id="welcome-text">
                <h1>Registrati</h1>
                <p>Benvenuto, registrati per entrare a far parte del nostro gruppo</p>
            </article>
        </section>

        <section id="register-container">
            <article id="register-box">
                <section id="brand-header">
                    <h2 id="register-heading">Registrazione del tuo <span lang="en">account</span></h2>
                    <p>Inserisci le tue informazioni per creare un <span lang="en">account</span></p>
                </section>

                <form action="index.php?page=auth&action=doRegister" method="POST" class="register-form"
                    aria-labelledby="register-heading">

                    <section class="auth-group">
                        <label for="username" id="username-label"><span lang="en">Username</span></label>
                        <section class="input-field">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <input type="text" id="username" name="username" required autocomplete="username"
                                placeholder="Inserisci username" aria-labelledby="username-label" aria-required="true">
                        </section>
                    </section>

                    <section class="auth-group">
                        <label for="email" id="email-label"><span lang="en">Email</span></label>
                        <section class="input-field">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <input type="email" id="email" name="email" required autocomplete="email"
                                placeholder="Inserisci email" aria-labelledby="email-label" aria-required="true">
                        </section>
                    </section>

                    <section class="auth-group">
                        <label for="password" id="password-label"><span lang="en">Password</span></label>
                        <section class="input-field">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                placeholder="Inserisci password" aria-labelledby="password-label" aria-required="true">
                            <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                        </section>
                    </section>

                    <section class="auth-group">
                        <label for="confirm_password">Conferma <span lang="en">Password</span></label>
                        <section class="input-field">
                            <i class="fa" id="passwordMatchIcon" aria-hidden="true"></i>
                            <input type="password" id="confirm_password" name="confirm_password"
                                placeholder="Conferma la password inserita" required>
                            <i class="fa-solid fa-eye toggle-password" id="togglePassworConfirm"></i>
                        </section>
                    </section>

                    <section>
                        <button type="submit" id="submit-button" aria-label="Registrati">
                            Registrati
                            <section id="button-decoration"></section>
                        </button>
                    </section>

                    <p>Hai già un <span lang="en">account</span>? <a href="index.php?page=auth&action=login">Accedi ora</a></p>
                </form>
            </article>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/menu.js"></script>
    <script src="assets/js/mostraPassword.js"></script>
    <script src="assets/js/confermaPassword.js"></script>

</body>
</html>