<?php
include 'views/includes/popupView.php';

// Init popup nella sessione
function setPopupMessage($message, $type = "info") {
    // Validazione del messaggio
    if (empty($message) || !is_string($message)) {
        return; // Non impostare popup se il messaggio non è valido
    }
    
    // Validazione del tipo
    $allowedTypes = ['info', 'success', 'warning', 'error'];
    if (!in_array($type, $allowedTypes)) {
        $type = 'info';
    }
    
    // Sanitizzazione del messaggio
    $message = trim($message);

    
    // Limitazione della lunghezza del messaggio
    if (strlen($message) > 500) {
        $message = substr($message, 0, 497) . '...';
    }
    
    $_SESSION['popup_message'] = $message;
    $_SESSION['popup_type'] = $type;
}

// Mostrare il popup (richiamata nella vista)
function showPopup() {
    if (!empty($_SESSION['popup_message'])) {
        echo getPopupHtml($_SESSION['popup_message'], $_SESSION['popup_type']);
        unset($_SESSION['popup_message'], $_SESSION['popup_type']);
    }
}
?>
