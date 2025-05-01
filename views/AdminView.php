<?php
class AdminView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>

    <meta name="author" content="TODO">
    <meta name="description" content="TODO">
    <meta name="keywords" content="TODO">
    <meta name="viewport" content="width=device-width">

    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    
    <button class="hamburger-btn">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="overlay"></div>
    
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="admin-dashboard">
            <p><?php echo $data['content']; ?></p>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Il Nostro Sito Web. Tutti i diritti riservati.</p>
    </footer>
    <script src="assets/js/menu.js"></script>
</body>
</html>
        <?php
    }
}
?>