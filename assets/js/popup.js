function closePopup(element) {
    let popup = element.closest('.popup');
    if (popup) {
        popup.style.opacity = '0';
        setTimeout(() => popup.remove(), 400); // Rimuove il popup dopo l'animazione
    }
}

// Funzione per mostrare il popup con animazione
document.addEventListener("DOMContentLoaded", () => {
    let popups = document.querySelectorAll(".popup");
    popups.forEach(popup => {
        setTimeout(() => {
            popup.classList.add("show");
        }, 100);
        
        // Chiusura automatica dopo 5 secondi
        setTimeout(() => {
            closePopup(popup);
        }, 5000);
    });
});