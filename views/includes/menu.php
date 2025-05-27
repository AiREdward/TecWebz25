<?php
require_once 'controllers/includes/menuController.php';
$menuController = new MenuController();
$menuItems = $menuController->getPages();
$isLoggedIn = $menuController->isUserLoggedIn();
?>

<nav id="menu" class="menu">
    <button id="hamburger-btn" class="hamburger-btn" aria-label="Menu di navigazione">
        <i class="fas fa-bars"></i>
    </button>
    <div id="menu-overlay" class="menu-overlay"></div>
    <ul id="menu-items" class="menu-items">
        <?php foreach ($menuItems as $label => $url): ?>
            <li>
                <?php if ($label === 'Logout'): ?>
                    <a href="#" id="logoutBtn" onclick="event.preventDefault(); confirmLogout();"><?php echo $label; ?></a>
                <?php else: ?>
                    <a href="<?php echo $url; ?>"><?php echo $label; ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php if ($isLoggedIn): ?>
    <div id="logoutPopupOverlay" role="dialog" aria-labelledby="logoutPopupTitle" aria-modal="true">
        <div class="logout-popup">
            <h3 id="logoutPopupTitle">Conferma Uscita</h3>
            <p>Sei sicuro di voler uscire?</p>
            <div class="logout-popup-buttons">
                <button id="confirmLogoutPopupBtn" class="confirm-btn">Esci</button>
                <button id="cancelLogoutPopupBtn" class="cancel-btn">Annulla</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'breadcrumb.php'; ?>