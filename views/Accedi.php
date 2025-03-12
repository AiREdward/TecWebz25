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
</head>
<body>

    <?php showPopup(); ?>

    <?php include 'includes/menu.php'; ?>
    <main>
    <h2>Accedi</h2>
        <?php if(isset($error)) { ?>
            <p style="color:red;" role="alert" aria-live="polite"><?= htmlspecialchars($error) ?></p>
        <?php } ?>
        
        <form action="index.php?page=auth&action=doLogin" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Inserisci email" required autocomplete="email">
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
        </form>
        <p>Non hai un account? <a href="index.php?page=auth&action=register">Registrati</a></p>
    </main>
    
    <?php include 'includes/footer.php'; ?>

</body>
</html>

