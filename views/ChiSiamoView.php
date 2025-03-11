<?php
class ChiSiamoView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <!-- <h1><?php echo $data['header']; ?></h1> -->
        <!-- <img src="assets/images/logo.webp" class="main-logo"/> -->
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="chi-siamo">
            <div class="container">
                <?php echo $data['content']; ?>
            </div>
        </section>
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