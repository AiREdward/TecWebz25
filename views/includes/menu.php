<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Ottiene il nome del file attuale

$menu_items = [
    'Home' => 'index.php?page=home',
    'Shop' => 'index.php?page=shop',
    'Noleggio' => 'index.php?page=rental',
    'Torneo' => 'index.php?page=tournament',
    'Chi Siamo' => 'index.php?page=chi-siamo'
];

$ruolo = $_SESSION['ruolo'] ?? null; // Prendi il ruolo dell'utente se esiste
$loggedIn = isset($_SESSION['user']); // Controlla se l'utente è loggato
?>

<nav>
    <a href="<?= $link ?>"><img src="assets/images/logo.webp" class="main-logo"/></a>
    <ul>
        <!-- <li><a href="<?= $link ?>"><img src="assets/images/logo.webp" class="main-logo"/></a></li> -->
        <?php foreach ($menu_items as $name => $link): ?>
            <li><a href="<?= $link ?>" class="<?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'active' : '' ?> menu-item"><?= $name ?></a></li>
        <?php endforeach; ?>

        <?php if ($ruolo === 'admin'): ?>
            <li><a href="index.php?page=admin" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'active' : '' ?> menu-item">Admin Dashboard</a></li>
        <?php endif; ?>
    </ul>
    <?php if ($loggedIn): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="index.php?page=login"><img src="assets/images/account.webp" class="account-button"/></a>
        <!-- <a href="index.php?page=login" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=login') !== false ? 'active' : '' ?> menu-item">Login</a> -->
        <!-- <a href="index.php?page=register" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=register') !== false ? 'active' : '' ?> menu-item">Registrazione</a> -->
    <?php endif; ?>
</nav>
