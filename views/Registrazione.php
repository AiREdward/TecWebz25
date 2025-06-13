<?php
include 'controllers/includes/popupController.php';

// Recupera la variabile breadcrumb se presente
$breadcrumb = isset($breadcrumb) ? $breadcrumb : [];

// Output buffering per il menu e breadcrumb
$data = [
    '{{menu}}' => (function() use ($breadcrumb) {
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

showPopup();

// Sostituisci i segnaposto
$output = str_replace(array_keys($data), array_values($data), $html);
echo $output;
?>