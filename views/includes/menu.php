<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Ottiene il nome del file attuale

$menu_items = [
    'Home' => 'index.php?page=home',
    'Shop' => 'index.php?page=shop',
    'Permuta' => 'index.php?page=trade',
    'Chi Siamo' => 'index.php?page=chi-siamo',
    'Contattaci' => 'index.php?page=contact'
];

$ruolo = $_SESSION['ruolo'] ?? null; // Prendi il ruolo dell'utente se esiste
$loggedIn = isset($_SESSION['user']); // Controlla se l'utente è loggato
?>

<nav class="main-navigation">
    <div class="navhead">
        <img src="assets/images/logo.webp" class="main-logo" alt="GameStart Logo"/>
        <a onclick="toggleMenu();"><img src="assets/images/burgermenu.webp" id="burgermenu-button" alt="Apri menu"/></a>
    </div>
    <ul>
        <?php foreach ($menu_items as $name => $link): ?>
            <li><a href="<?= $link ?>" class="<?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'active' : '' ?> menu-item"><?= $name ?></a></li>
        <?php endforeach; ?>

        <?php if ($ruolo === 'admin'): ?>
            <li><a href="index.php?page=admin" target="_blank" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'active' : '' ?> menu-item">Cruscotto</a></li>
        <?php endif; ?>
        
    </ul>
    <!-- <div class="nomargin log-section"> -->
    <ul class="nomargin log-section">
        <?php if ($loggedIn): ?>
            <li>
                <a href="index.php?page=auth&action=logout" class="menu-button">
                    <img src="assets/images/logout.webp" class="icon-button" alt="Logout"/>
                        <!-- <i class="fas fa-logout" class="icon-button" aria-hidden="true"></i> -->
                    <span class="logout-text">Logout</span>
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="index.php?page=auth" class="menu-button">
                    <img src="assets/images/account.webp" class="icon-button" alt="Profilo"/>
                    <!-- <i class="fas fa-user" class="icon-button" aria-hidden="true"></i> -->
                    <span class="logout-text">Accedi</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <!-- </div> -->
</nav>

<div class="breadcrumb-container">
    <?php include 'breadcrumb.php'; ?>
</div>