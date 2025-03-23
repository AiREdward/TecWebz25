<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Ottiene il nome del file attuale

$menu_items = [
    'Home' => 'index.php?page=home',
    'Shop' => 'index.php?page=shop',
    'Permuta' => 'index.php?page=trade',
    'Torneo' => 'index.php?page=tournament',
    'Chi Siamo' => 'index.php?page=chi-siamo',
    'Contattaci' => 'index.php?page=contact'
];

$ruolo = $_SESSION['ruolo'] ?? null; // Prendi il ruolo dell'utente se esiste
$loggedIn = isset($_SESSION['user']); // Controlla se l'utente è loggato
?>

<nav>
    <div class="navhead">
        <a href="<?= $link ?>"><img src="assets/images/logo.webp" class="main-logo"/></a>
        <a onclick="toggleMenu();"><img src="assets/images/burgermenu.webp" id="burgermenu-button" alt="Apri menu"/></a>
    </div>
    <ul>
        <?php foreach ($menu_items as $name => $link): ?>
            <li><a href="<?= $link ?>" class="<?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'active' : '' ?> menu-item"><?= $name ?></a></li>
        <?php endforeach; ?>

        <?php if ($ruolo === 'admin'): ?>
            <li><a href="index.php?page=admin" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'active' : '' ?> menu-item">Admin Dashboard</a></li>
        <?php endif; ?>
    </ul>
    <div class="nomargin">
        <?php if ($loggedIn): ?>
            <a href="index.php?page=auth&action=logout">Logout</a>
        <?php else: ?>
            <a href="index.php?page=auth"><img src="assets/images/account.webp" class="icon-account-button" alt="Profilo"/></a>
        <?php endif; ?>
    </div>
</nav>
