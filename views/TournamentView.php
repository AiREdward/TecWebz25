<?php
class TournamentView {
    public function render($data) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $data['title']; ?></title>
<<<<<<< HEAD
    <link rel="stylesheet" href="assets/css/style.css">
=======
    <link rel="stylesheet" href="/css/style.css">
>>>>>>> 6f42b9a492c33754fc9cc44233621f72a600412b
</head>
<body>
    <header>
        <h1><?php echo $data['header']; ?></h1>
    </header>
    <?php include 'includes/menu.php'; ?>
    <main>
        <section id="tournament">
            <p>Data: <?php echo $data['date']; ?></p>
            <p>Luogo: <?php echo $data['location']; ?></p>
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