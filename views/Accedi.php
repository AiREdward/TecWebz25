<?php
include 'controllers/includes/popupController.php';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Accedi</title>
    <meta name="author" content="TODO">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
/* Card di login con effetto split */
form {
    position: relative;
    max-width: 500px;
    margin: 3rem auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    /* Spazio a sinistra per il pannello decorativo */
    padding: 2rem;
    padding-left: 50%;
}

form::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    /* Gradiente basato sul colore del logo */
    background: linear-gradient(135deg, #e20000, #ff6f61);
}

/* Stili per i gruppi di input */
form > div {
    margin-bottom: 1.5rem;
}

form label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

form input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s, box-shadow 0.3s;
}

form input:focus {
    border-color: #e20000;
    box-shadow: 0 0 0 3px rgba(226, 0, 0, 0.2);
    outline: none;
}

/* Bottone di invio */
form button {
    background: #e20000;
    color: #fff;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s, transform 0.3s;
}

form button:hover,
form button:focus {
    background: #c10000;
    transform: translateY(-2px);
}

/* Titolo della pagina */
h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: #333;
}

/* Link per la registrazione */
p a {
    color: #e20000;
    text-decoration: none;
    font-weight: 600;
}

p a:hover,
p a:focus {
    text-decoration: underline;
}

/* Adattamento per schermi piccoli: rimuove il pannello decorativo */
@media (max-width: 480px) {
    form {
        padding-left: 2rem;
    }
    form::before {
        display: none;
    }
}


    </style>

</head>
<body>

    <?php include 'includes/menu.php'; ?>

    <?php showPopup(); ?>

    <?php include 'includes/menu.php'; ?>
    <main>
    <h2>Accedi</h2>
        <?php if(isset($error)) { ?>
            <p style="color:red;" role="alert" aria-live="polite"><?= htmlspecialchars($error) ?></p>
        <?php } ?>
        
        <form action="index.php?page=auth&action=doLogin" method="POST">
            <div>
                <label for="email">Email o Username:</label>
                <input type="text" id="email" name="email" placeholder="Inserisci email o username" required autocomplete="username">
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Inserisci password" required autocomplete="current-password">
            </div>
            <?php 
            $redirect = $_GET['redirect'] ?? ''; 
            ?>
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
            <div>
                <button type="submit" aria-label="Accedi al tuo account">Accedi</button>
            </div>

            <p>Non hai un account? <a href="index.php?page=auth&action=register">Registrati</a></p>
        </form>
        
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/script.js"></script>
</body>
</html>

