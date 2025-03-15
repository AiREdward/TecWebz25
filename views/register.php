<!DOCTYPE html>
<html lang="it">
<head>
    <title>Registrazione</title>

    <meta name="author" content="TODO">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
    <h2>Registrazione</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="index.php?page=auth&action=doRegister" method="POST">
        <div>
            <label>Username:</label>
            <input type="text" name="username" placeholder="Inserisci username" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" placeholder="Inserisci email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" placeholder="Inserisci password" required>
        </div>
        <div>
            <button type="submit">Registrati</button>
        </div>
    </form>
    <p>Hai già un account? <a href="index.php?page=auth&action=login">Accedi</a></p>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>
