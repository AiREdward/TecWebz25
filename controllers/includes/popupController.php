<?php
include 'views/includes/popupView.php';

// Init popup nella sessione
function setPopupMessage($message, $type = "info") {
    $_SESSION['popup_message'] = $message;
    $_SESSION['popup_type'] = $type;
}

// Mostrare il popup (richiamata nella vista)
function showPopup() {
    if (!empty($_SESSION['popup_message'])) {
        echo getPopupHtml($_SESSION['popup_message'], $_SESSION['popup_type']);
        unset($_SESSION['popup_message'], $_SESSION['popup_type']); // Pulizia della sessione dopo la visualizzazione
    }
}
?>
