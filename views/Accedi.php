<?php
include 'controllers/includes/popupController.php';

// Prepara i dati dinamici
$redirectValue = isset($_SESSION['redirect_after_login']) ? htmlspecialchars($_SESSION['redirect_after_login']) : '';

// Recupera la variabile breadcrumb se presente
$breadcrumb = isset($breadcrumb) ? $breadcrumb : [];

// Output buffering per il menu e breadcrumb
$data = [
    '{{menu}}' => (function() use ($breadcrumb) {
        ob_start();
        // Rende disponibile $breadcrumb per il menu
        include 'includes/menu.php';
        return ob_get_clean();
    })(),
    '{{footer}}' => (function() {
        ob_start();
        include 'includes/footer.php';
        return ob_get_clean();
    })(),
    '{{redirect}}' => $redirectValue,
];

// Carica il template HTML
$templatePath = __DIR__ . '/../template/AccediTemplate.html';
$html = file_get_contents($templatePath);

// Mostra eventuali popup
showPopup();

// Sostituisci i segnaposto
$output = str_replace(array_keys($data), array_values($data), $html);

// Stampa l'output finale
echo $output;
?>
