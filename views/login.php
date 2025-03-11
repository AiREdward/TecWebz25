<?php
include 'controllers/includes/popupController.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="author" content="TODO">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php showPopup(); ?>

    <h2>Login</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="index.php?page=auth&action=doLogin" method="POST">
        <div>
            <label>Email:</label>
            <input type="email" name="email" placeholder="Inserisci email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Inserisci password" required>
        </div>
        <?php 
        $redirect = $_GET['redirect'] ?? ''; 
        ?>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <div>
            <button type="submit">Accedi</button>
        </div>
    </form>
    <p>Non hai un account? <a href="index.php?page=auth&action=register">Registrati</a></p>

</body>
</html>
