function closePopup(element) {
    let popup = element.closest('.popup');
    if (popup) {
        popup.style.opacity = '0';
        setTimeout(() => popup.remove(), 400);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    let popups = document.querySelectorAll(".popup");
    popups.forEach(popup => {
        setTimeout(() => {
            popup.classList.add("show");
        }, 100);
        
        setTimeout(() => {
            closePopup(popup);
        }, 5000);
    });
});


function showCustomPopup(message, type = "info") {
    const icons = {
        "info": '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        "success": '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"></path></svg>',
        "error": '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>'
    };
    const icon = icons[type] || icons["info"];

    const popupHtml = `
        <article class='popup ${type}' role='alert' aria-live='assertive' aria-labelledby='popup-message'>
            <section class='popup-icon'>${icon}</section>
            <section class='popup-content'>
                <span class='popup-message' id='popup-message'>${message}</span>
            </section>
            <button class='popup-close' onclick='closePopup(this)' aria-label='Chiudi notifica'>&times;</button>
        </article>
    `;

    const existingPopups = document.querySelectorAll('.popup');
    existingPopups.forEach(popup => popup.remove());

    document.body.insertAdjacentHTML('beforeend', popupHtml);

    const newPopup = document.querySelector('.popup:last-child');
    setTimeout(() => {
        newPopup.classList.add('show');
    }, 100);

    setTimeout(() => {
        closePopup(newPopup);
    }, 5000);
}

function showCustomConfirm(message, onConfirm, onCancel = null) {
    const confirmHtml = `
        <div id="confirmPopupOverlay" role="dialog" aria-labelledby="confirmPopupTitle" aria-modal="true">
          <div class="confirm-popup">
            <h3 id="confirmPopupTitle">Conferma</h3>
            <p>${message}</p>
            <div class="confirm-popup-buttons">
              <button id="confirmBtn" class="confirm-btn">Conferma</button>
              <button id="cancelBtn" class="cancel-btn">Annulla</button>
            </div>
          </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', confirmHtml);

    const overlay = document.getElementById('confirmPopupOverlay');
    const confirmBtn = document.getElementById('confirmBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    confirmBtn.addEventListener('click', () => {
        overlay.remove();
        if (onConfirm) onConfirm();
    });

    cancelBtn.addEventListener('click', () => {
        overlay.remove();
        if (onCancel) onCancel();
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.remove();
            if (onCancel) onCancel();
        }
    });
}