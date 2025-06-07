<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">

    <title>Errore di Connessione</title>

    <meta name="author" content="SomeNerdStudios">
    <meta name="description" content="Pagina di errore per problemi di connessione al database. Verifica lo stato del server e le impostazioni di connessione">
    <meta name="keywords" content="">  <!-- non inseriamo kewyowrds perchè questa pagina non può essere accessibile tramite navigazione -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/mediaQuery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <main class="error-container">
        <section class="error-icon">
            <img src="assets/img/icons/triangle-exclamation-solid.svg" alt="Icona Errore" width="15" height="15">
        </section>
        <h1 id="error-title">Errore di Connessione al <span lang="en">database</span></h1>
        <p id="error-message">Non siamo in grado di stabilire una connessione con il <span lang="en">database</span> in questo momento.</p>
        <aside class="error-details">
            <p>Si prega di controllare i seguenti aspetti:</p>
            <ul>
                <li>Il server del <span lang="en">database</span> è attivo</li>
                <li>Le credenziali di connessione sono corrette</li>
                <li>Il nome del <span lang="en">database</span> esiste</li>
                <li>Le impostazioni del <span lang="en">firewall</span> del <span lang="en">server</span></li>
            </ul>
        </aside>
        <a href="../index.php" id="back-button">Torna alla <span lang="en">Homepage</span></a>
    </main>
</body>
</html>
