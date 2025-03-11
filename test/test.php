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
