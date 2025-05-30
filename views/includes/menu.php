<?php
require_once 'controllers/includes/menuController.php';
$menuController = new MenuController();
$menuItems = $menuController->getPages();
$isLoggedIn = $menuController->isUserLoggedIn();
?>

<nav aria-label="Menu di navigazione">
<!-- <nav class="menu" aria-label="Menu di navigazione"> -->
    <!-- TODO: posso tenere questo div come container? ~Dipa -->
    <div class="menu"> 
       <ul id="menu-logo">
            <li>
                <img src="assets/img/logo.webp" class="main-logo" alt="GameStart Logo"/>
            </li>
       </ul>
        <div id="menu-overlay"></div>
        <ul id="menu-items">
            <?php foreach ($menuItems as $label => $url): ?>
                <?php if ($label != 'Logout' && $label != 'Accedi'): ?>
                    <li class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], $url) !== false) ? 'active' : ''; ?>">
                        <a href="<?php echo $url; ?>">
                            <?php echo $label; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <ul id="menu-actions">
            <?php if ($isLoggedIn): ?>
                <li>
                    <a href="#" class="menu-button" id="logoutBtn" onclick="event.preventDefault(); confirmLogout();">
                        <img src="assets/img/icons/logout.webp" class="icon-button" alt="Logout"/>
                        <span class="logout-text" lang="en">Logout</span>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="index.php?page=auth" class="menu-button">
                        <img src="assets/img/icons/account.webp" class="icon-button" alt="Profilo"/>
                        <span class="logout-text">Accedi</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <button id="hamburger-btn" aria-label="Menu di navigazione">
            <i class="fas fa-bars"></i>
            <!-- <img src="assets/img/icons/burgermenu.webp" class="icon-button-plain" alt="Menu di navigazione"/>
            <span class="sr-only">Menu di navigazione</span> -->
        </button>
    </div>
    
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