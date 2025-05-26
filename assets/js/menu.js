function confirmLogout() {
    document.getElementById('logoutPopupOverlay').style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', function() {
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
});