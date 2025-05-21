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

<nav class="main-navigation" role="navigation" aria-label="Menu principale">
    <section class="navhead">
        <img src="assets/images/logo.webp" class="main-logo" alt="GameStart Logo"/>
        <button onclick="toggleMenu();" aria-label="Apri menu di navigazione" aria-expanded="false" aria-controls="main-menu" id="burgermenu-button">
            <img src="assets/images/burgermenu.webp" alt="" aria-hidden="true"/>
        </button>
    </section>
    <ul id="main-menu">
        <?php foreach ($menu_items as $name => $link): ?>
            <li><a href="<?= $link ?>" class="<?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'active' : '' ?> menu-item" <?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'aria-current="page"' : '' ?>><?= $name ?></a></li>
        <?php endforeach; ?>

        <?php if ($ruolo === 'admin'): ?>
            <li><a href="index.php?page=admin" target="_blank" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'active' : '' ?> menu-item" <?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'aria-current="page"' : '' ?>>Cruscotto</a></li>
        <?php endif; ?>
        
    </ul>
    <ul class="nomargin log-section" aria-label="Menu di autenticazione">
        <?php if ($loggedIn): ?>
            <li>
                <a href="index.php?page=auth&action=logout" class="menu-button" aria-label="Esci dal tuo account">
                    <img src="assets/images/logout.webp" class="icon-button" alt="" aria-hidden="true"/>
                    <span class="logout-text">Logout</span>
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="index.php?page=auth" class="menu-button" aria-label="Accedi al tuo account">
                    <img src="assets/images/account.webp" class="icon-button" alt="" aria-hidden="true"/>
                    <span class="logout-text">Accedi</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php include 'breadcrumb.php'; ?>