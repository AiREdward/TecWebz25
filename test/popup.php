<style>
/* Stile base del popup */
.popup {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 400px;
    background: #fff;
    border-left: 5px solid #3498db; /* Colore di default per info */
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s ease, transform 0.4s ease;
    transform: translate(-50%, -20px);
    font-family: Arial, sans-serif;
}

/* Mostra il popup con effetto fade-in */
.popup.show {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, 0);
}

/* Border sinistro personalizzato in base al tipo di messaggio */
.popup.info {
    border-left-color: #3498db;
}

.popup.success {
    border-left-color: #2ecc71;
}

.popup.error {
    border-left-color: #e74c3c;
}

/* Stile per l'icona */
.popup-icon {
    margin-right: 15px;
    flex-shrink: 0;
}

.popup-icon .icon {
    width: 24px;
    height: 24px;
    color: inherit;
}

/* Stile del contenuto del popup */
.popup-content {
    flex-grow: 1;
}

.popup-message {
    font-size: 16px;
    color: #333;
}

/* Bottone di chiusura */
.popup-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #aaa;
    cursor: pointer;
    transition: color 0.3s ease;
}

.popup-close:hover {
    color: #000;
}

/* Responsive per dispositivi mobili */
@media (max-width: 480px) {
    .popup {
        width: 95%;
        max-width: none;
    }
}


</style>

<script>
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

// Funzione per aprire il modale
function openModal() {
    document.getElementById("confirmationModal").style.display = "flex";
}

// Funzione per chiudere il modale e mostrare il popup corrispondente
function confirmAction(isConfirmed) {
    document.getElementById("confirmationModal").style.display = "none";

    // Ricarica la pagina con il parametro GET per mostrare il popup
    if (isConfirmed) {
        window.location.href = "index.php?action=success";
    } else {
        window.location.href = "index.php?action=error";
    }
}

</script>

<?php
function showPopup($message, $type = "info") {
    // Definizione delle icone inline con SVG
    $icons = [
         "info" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>',
         "success" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                           <path d="M20 6L9 17l-5-5"></path>
                       </svg>',
         "error" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                         <circle cx="12" cy="12" r="10"></circle>
                         <line x1="15" y1="9" x2="9" y2="15"></line>
                         <line x1="9" y1="9" x2="15" y2="15"></line>
                     </svg>'
    ];
    $icon = isset($icons[$type]) ? $icons[$type] : $icons["info"];

    echo "<div class='popup $type'>
            <div class='popup-icon'>$icon</div>
            <div class='popup-content'>
                <span class='popup-message'>$message</span>
            </div>
            <button class='popup-close' onclick='closePopup(this)'>&times;</button>
          </div>";
}
?>

<!-- Esempio di utilizzo -->

<?php include 'includes/popup.php'; ?>

<body>

    <!-- Pulsante per aprire il modale -->
    <button class="open-modal-btn" onclick="openModal()">Apri Modale</button>

    <!-- Modale di conferma -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <h2>Conferma Azione</h2>
            <p>Sei sicuro di voler procedere?</p>
            <div class="modal-buttons">
                <button onclick="confirmAction(true)">Sì</button>
                <button onclick="confirmAction(false)">No</button>
            </div>
        </div>
    </div>

    <?php
    // Controllo se viene passato un parametro in GET per mostrare il popup
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "success") {
            showPopup("Operazione completata con successo!", "success");
        } elseif ($_GET['action'] == "error") {
            showPopup("Errore: operazione fallita.", "error");
        }
    }
    ?>

</body>
