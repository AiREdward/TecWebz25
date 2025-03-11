<?php
class LoginView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>

    <meta name="author" content="TODO">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <div class="container">
            <form action="/user/login" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="/user/register">Register here</a></p>
        </div>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Website. All rights reserved.</p>
    </footer>
</body>
</html>
        <?php
    }
}
?>