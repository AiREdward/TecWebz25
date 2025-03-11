<?php
include 'popup.php';

function showPopup($message, $type = "info") {
    echo getPopupView($message, $type);
}
?>
