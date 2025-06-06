<?php
// Carica il template HTML
$template = file_get_contents(__DIR__ . '/../template/AdminTemplate.html');

// Genera la lista utenti come HTML
$usersListHtml = '';
if (isset($users) && !empty($users)) {
    foreach ($users as $user) {
        $usersListHtml .= '<li class="user-item">';
        $usersListHtml .= '<div class="user-select">';
        $usersListHtml .= '<input type="radio" name="selected_user" id="user-' . $user['id'] . '" value="' . $user['id'] . '">';
        $usersListHtml .= '<label for="user-' . $user['id'] . '" class="sr-only">Seleziona utente</label>';
        $usersListHtml .= '</div>';
        $usersListHtml .= '<div class="user-info-main">';
        $usersListHtml .= '<div class="user-name">' . htmlspecialchars($user['username']) . '</div>';
        $usersListHtml .= '<div class="user-email">' . htmlspecialchars($user['email']) . '</div>';
        $usersListHtml .= '</div>';
        $usersListHtml .= '<div class="user-details">';
        $usersListHtml .= '<div class="user-role">' . ucfirst($user['ruolo']) . '</div>';
        $usersListHtml .= '<div class="user-status">' . ucfirst($user['stato']) . '</div>';
        $usersListHtml .= '</div>';
        $usersListHtml .= '</li>';
    }
} else {
    $usersListHtml = '<div class="no-results">Nessun utente trovato</div>';
}

// Genera le statistiche come HTML
$statisticsHtml = '';
if (isset($statistics)) {
    $statisticsHtml .= '<article class="stat-card"><div class="stat-icon"><img src="assets/img/icons/whiteusers-solid.svg" alt="Icona Utenti Bianca" width="30" height="30"></div><div class="stat-info"><h3>Utenti Totali</h3><p class="stat-number">' . $statistics['total_users'] . '</p><p class="stat-change positive"><img src="assets/img/icons/circle-green.svg" alt="Icona Cerchio verde"  width="15" height="15"/> Attivi: ' . $statistics['active_users'] . '</p></div></article>';
    $statisticsHtml .= '<article class="stat-card"><div class="stat-icon"><img src="assets/img/icons/bag-shopping-solid.svg" alt="Icona Borsa Bianca" width="30" height="30"></div><div class="stat-info"><h3>Prodotti Totali</h3><p class="stat-number">' . $statistics['total_products'] . '</p><p class="stat-change positive"><img src="assets/img/icons/circle-green.svg" alt="Icona Cerchio verde"  width="15" height="15"/> In catalogo</p></div></article>';
    $statisticsHtml .= '<article class="stat-card"><div class="stat-icon"><img src="assets/img/icons/dollar-sign-solid.svg" alt="Icona Dollaro Bianca" width="30" height="30"></div><div class="stat-info"><h3>Vendite Totali</h3><p class="stat-number">' . $statistics['total_sales'] . '</p><p class="stat-change positive"><img src="assets/img/icons/circle-green.svg" alt="Icona Cerchio verde"  width="15" height="15"/> Ordini</p></div></article>';
    $statisticsHtml .= '<article class="stat-card"><div class="stat-icon"><img src="assets/img/icons/whitecart-shopping-solid.svg" alt="Icona Carrello Bianca" width="30" height="30"></div><div class="stat-info"><h3>Prodotti Venduti</h3><p class="stat-number">' . $statistics['total_products_sold'] . '</p><p class="stat-change positive"><img src="assets/img/icons/circle-green.svg" alt="Icona Cerchio verde"  width="15" height="15"/> Articoli</p></div></article>';
    $statisticsHtml .= '<article class="stat-card"><div class="stat-icon"><img src="assets/img/icons/euro-sign-solid.svg" alt="Icona Euro Bianca" width="30" height="30"></div><div class="stat-info"><h3>Incasso Totale</h3><p class="stat-number">' . $statistics['total_revenue'] . ' €</p><p class="stat-change positive"><img src="assets/img/icons/circle-green.svg" alt="Icona Cerchio verde"  width="15" height="15"/> Fatturato</p></div></article>';
}

// Sostituisci i placeholder nel template
$output = str_replace(
    ['{{USERS_LIST}}', '{{STATISTICS}}'],
    [$usersListHtml, $statisticsHtml],
    $template
);

// Stampa il risultato finale
echo $output;
?>
