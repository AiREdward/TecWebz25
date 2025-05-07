document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-products');
    const productsBox = document.getElementById('products-box');
    
    if (!searchInput || !productsBox) return;
    
    let debounceTimer;
    let cachedResults = {}; // Cache per memorizzare i risultati delle ricerche
    
    // Aggiorna il placeholder per chiarire che la ricerca è solo per nome
    if (searchInput) {
        searchInput.placeholder = "Cerca per nome prodotto...";
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        
        const searchTerm = this.value.trim();
        
        // Debounce per evitare troppe richieste durante la digitazione
        debounceTimer = setTimeout(() => {
            if (searchTerm.length >= 2) {
                // Controlla se abbiamo già i risultati in cache
                if (cachedResults[searchTerm]) {
                    updateProductsList(cachedResults[searchTerm]);
                } else {
                    searchProducts(searchTerm);
                }
            } else if (searchTerm.length === 0) {
                // Se la ricerca è vuota, mostra tutti i prodotti
                if (cachedResults['']) {
                    updateProductsList(cachedResults['']);
                } else {
                    resetSearch();
                }
            }
        }, 200); // Ridotto da 300ms a 200ms
    });
    
    function searchProducts(term) {
        fetch(`index.php?page=shop&action=search&term=${encodeURIComponent(term)}`)
            .then(response => response.json())
            .then(data => {
                // Memorizza i risultati nella cache
                cachedResults[term] = data.products;
                updateProductsList(data.products);
            })
            .catch(error => {
                console.error('Errore durante la ricerca:', error);
            });
    }
    
    function resetSearch() {
        // Ricarica tutti i prodotti
        fetch('index.php?page=shop&action=search&term=')
            .then(response => response.json())
            .then(data => {
                // Memorizza i risultati vuoti nella cache
                cachedResults[''] = data.products;
                updateProductsList(data.products);
            })
            .catch(error => {
                console.error('Errore durante il reset della ricerca:', error);
            });
    }
    
    function updateProductsList(products) {
        // Svuota il contenitore dei prodotti
        productsBox.innerHTML = '';
        
        if (products.length === 0) {
            productsBox.innerHTML = '<p class="no-results">Nessun prodotto trovato. Prova con un\'altra ricerca.</p>';
            return;
        }
        
        // Calcola la data di 7 giorni fa per i prodotti recenti
        const recentDate = new Date();
        recentDate.setDate(recentDate.getDate() - 7);
        
        // Aggiungi i prodotti filtrati
        products.forEach(product => {
            const productDate = new Date(product.data_creazione);
            const isRecent = productDate >= recentDate;
            
            const productElement = document.createElement('li');
            productElement.className = `product-card ${isRecent ? 'recent-product' : ''}`;
            
            productElement.innerHTML = `
                <article>
                    <img src="${product.immagine}" 
                        alt="${product.nome}" 
                        loading="lazy"
                        width="200" 
                        height="200">
                    <h3>${product.nome}</h3>
                    <p class="prezzo">Prezzo: €${parseFloat(product.prezzo).toFixed(2)}</p>
                    <p class="genere">Genere: ${product.genere}</p>
                    ${isRecent ? '<span class="badge">Nuovo!</span>' : ''}
                    <div class="product-actions">
                        <button class="add-to-cart" 
                                aria-label="Aggiungi ${product.nome} al carrello"
                                data-product-id="${product.id}">
                            Aggiungi al carrello
                        </button>
                        <a href="index.php?page=product&id=${product.id}" class="view-product" aria-label="Visualizza il prodotto: ${product.nome}">
                            Visualizza prodotto
                        </a>
                    </div>
                </article>
            `;
            
            productsBox.appendChild(productElement);
        });
        
        // Riattiva i listener per i pulsanti del carrello
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                // Riutilizza la funzione di aggiunta al carrello esistente
                if (typeof addToCart === 'function') {
                    addToCart(productId);
                }
            });
        });
    }
});