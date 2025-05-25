<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Ottiene il nome del file attuale

$menu_items = [
    'Home' => 'index.php?page=home',
    'Negozio' => 'index.php?page=shop',
    'Permuta' => 'index.php?page=trade',
    'Chi Siamo' => 'index.php?page=chi-siamo',
    'Contattaci' => 'index.php?page=contact'
];

$ruolo = $_SESSION['ruolo'] ?? null; // Prendi il ruolo dell'utente se esiste
$loggedIn = isset($_SESSION['user']); // Controlla se l'utente è loggato
?>

<nav class="main-navigation" role="navigation" aria-label="Menu principale">
    <section class="navhead">
        <img src="assets/img/logo.webp" class="main-logo" alt="'GameStart' Logo" height="48"/>
        <button onclick="toggleMenu();" aria-label="Apri menu di navigazione" aria-expanded="false" aria-controls="main-menu" id="burgermenu-button">
            <img src="assets/img/icons/burgermenu.webp" alt="Logo menu ad hamburger" aria-hidden="true"/>
        </button>
    </section>
    <ul id="main-menu">
        <?php foreach ($menu_items as $name => $link): ?>
            <li><a href="<?= $link ?>" class="<?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'active' : '' ?> menu-item" <?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'aria-current="page"' : '' ?>><?= $name ?></a></li>
        <?php endforeach; ?>

        <?php if ($ruolo === 'admin'): ?>
            <li><a href="index.php?page=admin" target="_blank" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'active' : '' ?> menu-item" <?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'aria-current="page"' : '' ?>><span lang="en">Admin</span></a></li>
        <?php endif; ?>
        
    </ul>
    <ul class="nomargin log-section" aria-label="Menu di autenticazione">
        <?php if ($loggedIn): ?>
            <li>
                <a href="javascript:void(0);" onclick="confirmLogout()" class="menu-button" aria-label="Esci dal tuo account">
                    <img src="assets/img/icons/logout.webp" class="icon-button" alt="Logo logout" aria-hidden="true"/>
                    <span class="logout-text">Esci</span>
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="index.php?page=auth" class="menu-button" aria-label="Accedi al tuo account">
                    <img src="assets/img/icons/account.webp" class="icon-button" alt="Logo account utente" aria-hidden="true"/>
                    <span class="logout-text">Accedi</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div id="logoutPopupOverlay" role="dialog" aria-labelledby="logoutPopupTitle" aria-modal="true">
    <div class="logout-popup">
        <h3>Conferma Uscita</h3>
        <p>Sei sicuro di voler uscire?</p>
        <div class="logout-popup-buttons">
            <button id="confirmLogoutPopupBtn" class="confirm-btn">Esci</button>
            <button id="cancelLogoutPopupBtn" class="cancel-btn">Annulla</button>
        </div>
    </div>
</div>

<?php include 'breadcrumb.php'; ?>