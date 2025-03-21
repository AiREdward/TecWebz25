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

    <style>
        :root {
            --primary-color: #e20000;
            --primary-dark: #cc0000;
            --text-dark: #2d3436;
            --text-light: #636e72;
            --background-light: #f8f9fa;
            --white: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --spacing-base: 1rem;
            --border-radius: 0.75rem;
        }

        .main-container  {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 45% 55%;
        }

        .welcome-container {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: calc(var(--spacing-base) * 3.75);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-text {
            color: var(--white);
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .welcome-text h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            margin-bottom: calc(var(--spacing-base) * 1.25);
            letter-spacing: -0.03em;
        }

        .welcome-text p {
            font-size: clamp(1rem, 2vw, 1.2rem);
            opacity: 0.9;
        }

        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: calc(var(--spacing-base) * 2.5);
        }

        .register-box {
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

        .form-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: calc(var(--spacing-base) * 1.25);
        }

        .register-form {
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

        @media (max-width: 64rem) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .welcome-container {
                display: none;
            }

            .register-container {
                padding: calc(var(--spacing-base) * 1.25);
            }

            .register-box {
                padding: calc(var(--spacing-base) * 1.875) calc(var(--spacing-base) * 1.25);
            }
        }

        @media (max-width: 30rem) {
            .register-box {
                padding: calc(var(--spacing-base) * 1.25) calc(var(--spacing-base) * 0.9375);
            }

            .brand-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
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
