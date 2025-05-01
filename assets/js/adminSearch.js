// Funzione per filtrare gli utenti in base al testo di ricerca
function searchUsers(query) {
    // Ottiene tutti gli elementi utente
    const userItems = document.querySelectorAll('.user-item');
    
    // Converte la query in minuscolo per un confronto case-insensitive
    query = query.toLowerCase();
    
    // Itera su ogni elemento utente
    userItems.forEach(item => {
        // Ottiene il nome utente dall'elemento
        const username = item.querySelector('.user-name').textContent.toLowerCase();
        
        // Verifica se il nome utente contiene la query di ricerca
        if (username.includes(query)) {
            // Mostra l'elemento se corrisponde
            item.style.display = '';
        } else {
            // Nasconde l'elemento se non corrisponde
            item.style.display = 'none';
        }
    });
}

// Aggiunge l'event listener quando il DOM è completamente caricato
document.addEventListener('DOMContentLoaded', function() {
    // Trova l'input di ricerca nella sezione utenti
    const searchUserInput = document.querySelector('#users .filter-group input[type="search"]');
    
    // Verifica che l'elemento esista
    if (searchUserInput) {
        // Aggiunge l'event listener per l'evento input
        searchUserInput.addEventListener('input', function() {
            // Chiama la funzione di ricerca con il valore corrente dell'input
            searchUsers(this.value);
        });
    }
});