<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Ottiene il nome del file attuale

$menu_items = [
    'Home' => 'index.php?page=home',
    'Shop' => 'index.php?page=shop',
    'Noleggio' => 'index.php?page=rental',
    'Iscrizione Torneo' => 'index.php?page=tournament',
];

$ruolo = $_SESSION['ruolo'] ?? null; // Prendi il ruolo dell'utente se esiste
$loggedIn = isset($_SESSION['user']); // Controlla se l'utente è loggato
?>

<nav>
    <ul>
        <?php foreach ($menu_items as $name => $link): ?>
            <li><a href="<?= $link ?>" class="<?= strpos($_SERVER['REQUEST_URI'], $link) !== false ? 'active' : '' ?>"><?= $name ?></a></li>
        <?php endforeach; ?>

        <?php if ($ruolo === 'admin'): ?>
            <li><a href="index.php?page=admin" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=admin') !== false ? 'active' : '' ?>">Admin Dashboard</a></li>
        <?php endif; ?>

        <?php if ($loggedIn): ?>
            <li><a href="index.php?page=auth&action=logout">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php?page=auth&action=login" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=auth&action=login') !== false ? 'active' : '' ?>">Accedi</a></li>
            <li><a href="index.php?page=auth&action=register" class="<?= strpos($_SERVER['REQUEST_URI'], 'index.php?page=auth&action=register') !== false ? 'active' : '' ?>">Registrazione</a></li>
        <?php endif; ?>

    </ul>
</nav>
