function confirmLogout() {
    document.getElementById('logoutPopupOverlay').style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', function() {
    // Gestione popup logout
    const overlay = document.getElementById('logoutPopupOverlay');
    const confirmBtn = document.getElementById('confirmLogoutPopupBtn');
    const cancelBtn = document.getElementById('cancelLogoutPopupBtn');

    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            window.location.href = "index.php?page=auth&action=logout";
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            if (overlay) overlay.style.display = 'none';
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function(event) {
            if (event.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    }
    
    // Gestione menu hamburger
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const menuItems = document.getElementById('menu-items');
    const menuActions = document.getElementById('menu-actions');
    const menuOverlay = document.getElementById('menu-overlay');
    
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', function() {
            // Cambia l'icona da hamburger a X e viceversa
            // const icon = hamburgerBtn.querySelector('i');
            // Sostituisci l'immagine con un'immagine diversa (assets/img/icons/closeburgermenu.svg)
            const icon = hamburgerBtn.querySelector('img');
            if (icon.src.includes('/burgermenu.svg')) {
                icon.src = 'assets/img/icons/closeburgermenu.svg';
                menuItems.classList.add('active');
                menuActions.classList.add('active');
                menuOverlay.classList.add('active');
                document.body.classList.add('menu-open');
            } else {
                icon.src = 'assets/img/icons/burgermenu.svg';
                menuItems.classList.remove('active');
                menuActions.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    }
    
    if (menuOverlay) {
        menuOverlay.addEventListener('click', function() {
            // Chiudi il menu quando si clicca sull'overlay
            const icon = hamburgerBtn.querySelector('img');
            icon.src = 'assets/img/icons/burgermenu.svg';
            menuItems.classList.remove('active');
            menuActions.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.classList.remove('menu-open');
        });
    }
    
    // Chiudi il menu quando si clicca su un link (solo in modalità mobile)
    const menuLinks = menuItems.querySelectorAll('a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 1200 && !this.id === 'logoutBtn') {
                const icon = hamburgerBtn.querySelector('img');
                icon.src = 'assets/img/icons/burgermenu.svg';
                menuItems.classList.remove('active');
                menuActions.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    });
});