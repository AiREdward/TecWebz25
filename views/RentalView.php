<?php
class RentalView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="rental">
            <p><?php echo $data['content']; ?></p>
        </section>
    </main>
    <footer>
        <p>© <?php echo date('Y'); ?> Our Rental Services. All rights reserved.</p>
    </footer>
</body>
</html>
        <?php
    }
}
?>