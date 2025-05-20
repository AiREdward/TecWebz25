<!-- <link rel="stylesheet" href="assets/css/style.css"> IN TEORIA NON SERVE-->

<?php
// Funzione che restituisce solo il markup HTML, senza eseguire subito l'output
function getPopupHtml($message, $type = "info") {
    $icons = [
        "info" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        "success" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"></path></svg>',
        "error" => '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>'
    ];
    $icon = isset($icons[$type]) ? $icons[$type] : $icons["info"];

    return "<article class='popup $type' role='alert' aria-live='assertive'>
                <section class='popup-icon'>$icon</section>
                <section class='popup-content'>
                    <span class='popup-message' id='popup-message'>$message</span>
                </section>
                <button class='popup-close' onclick='closePopup(this)' aria-label='Chiudi notifica'>&times;</button>
            </article>";
}
?>

<script src="assets/js/popup.js"></script>