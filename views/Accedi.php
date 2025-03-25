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
    <link rel="stylesheet" href="assets/css/mediaQuery.css">

    <style>
        /* Login Section */
.login-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: calc(var(--spacing-base) * 2.5);
}

.login-box {
    width: 100%;
    max-width: 31.25rem;
    padding: calc(var(--spacing-base) * 2.5);
}

.brand-header {
    text-align: center;
    margin-bottom: calc(var(--spacing-base) * 2.5);
}

.brand-header h2 {
    font-size: clamp(1.5rem, 3vw, 2rem);
    color: var(--text-dark);
    margin-bottom: calc(var(--spacing-base) * 0.625);
}

.brand-header p {
    color: var(--text-light);
}

/* Form Styles */
.login-form {
    margin-top: calc(var(--spacing-base) * 2.5);
}

.form-group {
    margin-bottom: calc(var(--spacing-base) * 1.5625);
}

.form-group label {
    display: block;
    margin-bottom: calc(var(--spacing-base) * 0.5);
    color: var(--text-dark);
    font-weight: 500;
}

.input-field {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--white);
    border: 0.125rem solid #e1e1e1;
    border-radius: var(--border-radius);
    padding: calc(var(--spacing-base) * 0.75) calc(var(--spacing-base) * 1);
    transition: var(--transition);
}

.input-field:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(226, 0, 0, 0.1);
}

.input-field i {
    color: var(--text-light);
    font-size: 1.1em;
    margin-right: calc(var(--spacing-base) * 0.75);
}

.input-field input {
    width: 100%;
    border: none;
    background: none;
    outline: none;
    color: var(--text-dark);
    font-size: 1em;
    padding: calc(var(--spacing-base) * 0.25) 0;
}

.input-field input::placeholder {
    color: #999;
}

.toggle-password {
    cursor: pointer;
    margin-left: auto;
    transition: var(--transition);
}

.toggle-password:hover {
    color: var(--primary-color);
}

/* Button Styles */
.submit-button {
    width: 100%;
    padding: calc(var(--spacing-base) * 1);
    background: var(--primary-color);
    color: var(--white);
    border: none;
    border-radius: var(--border-radius);
    font-size: 1.1em;
    font-weight: 600;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: var(--transition);
    margin-top: calc(var(--spacing-base) * 1.25);
}

.submit-button:hover {
    background: var(--primary-dark);
    transform: translateY(-0.125rem);
}

.button-decoration {
    position: absolute;
    top: 50%;
    right: -100%;
    transform: translateY(-50%);
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: var(--transition);
}

.submit-button:hover .button-decoration {
    right: 100%;
}

/* Error Message */
.error-message {
    background: #fff2f2;
    color: var(--primary-color);
    padding: calc(var(--spacing-base) * 1);
    border-radius: var(--border-radius);
    margin-bottom: calc(var(--spacing-base) * 1.5625);
    font-size: 0.95em;
    display: flex;
    align-items: center;
    gap: calc(var(--spacing-base) * 0.75);
    border: 0.0625rem solid rgba(226, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 64rem) {
    .container {
        grid-template-columns: 1fr;
    }

    .welcome-container {
        display: none;
    }

    .login-container {
        padding: calc(var(--spacing-base) * 1.25);
    }

    .login-box {
        padding: calc(var(--spacing-base) * 1.875) calc(var(--spacing-base) * 1.25);
    }
}

@media (max-width: 30rem) {
    .login-box {
        padding: calc(var(--spacing-base) * 1.25) calc(var(--spacing-base) * 0.9375);
    }

    .brand-header h2 {
        font-size: 1.8rem;
    }
}
    </style>
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
    
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/mostraPassword.js"></script>
</body>
</html>
