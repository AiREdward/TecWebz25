<?php
include 'controllers/includes/popupController.php';

// Prepara i dati dinamici (puoi aggiungere altri se necessario)
$data = [
    '{{menu}}' => (function() {
        ob_start();
        include 'includes/menu.php';
        return ob_get_clean();
    })(),
    '{{footer}}' => (function() {
        ob_start();
        include 'includes/footer.php';
        return ob_get_clean();
    })(),
];

// Carica il template HTML
$templatePath = __DIR__ . '/../template/RegistrazioneTemplate.html';
$html = file_get_contents($templatePath);

// Sostituisci i segnaposto
$output = str_replace(array_keys($data), array_values($data), $html);

// Mostra eventuali popup
showPopup();

// Stampa l'output finale
echo $output;
?>