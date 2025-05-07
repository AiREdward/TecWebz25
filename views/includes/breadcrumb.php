<?php
// Includi il file CSS per la breadcrumb
$breadcrumbCss = '<link rel="stylesheet" href="assets/css/breadcrumb.css">';
// Verifica se è già stato incluso
if (!isset($GLOBALS['breadcrumb_css_included'])) {
    echo $breadcrumbCss;
    $GLOBALS['breadcrumb_css_included'] = true;
}
?>
<nav aria-label="breadcrumb">
    <p>Ti trovi in:
        <?php
        // Array del percorso: ogni elemento rappresenta una voce della breadcrumb
        $breadcrumb = isset($breadcrumb) ? $breadcrumb : [];

        // Iterazione sulle voci del breadcrumb
        foreach ($breadcrumb as $key => $item) {
            // Controlla se è l'ultimo elemento
            if ($key === array_key_last($breadcrumb)) {
                echo '<span class="active">' . htmlspecialchars($item['name']) . '</span>';
            } else {
                echo '<a href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['name']) . '</a> > ';
            }
        }
        ?>
    </p>
</nav>