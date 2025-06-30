document.addEventListener('DOMContentLoaded', function() {
    const filterTitle = document.querySelector('#filters h2');
    const filterForm = document.querySelector('#filter-form');
    const searchContainer = document.querySelector('#search-container');
    
    if (filterTitle && filterForm) {
        filterTitle.addEventListener('click', function() {
            filterForm.classList.toggle('show');
            filterTitle.classList.toggle('active');
            
            if (searchContainer) {
                searchContainer.classList.toggle('show');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-products');
    const productsBox = document.getElementById('products-box');
    
    if (!searchInput || !productsBox) return;
    
    let debounceTimer;
    let cachedResults = {};
    
    if (searchInput) {
        searchInput.placeholder = "Cerca per nome prodotto...";
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        
        const searchTerm = this.value.trim();

        debounceTimer = setTimeout(() => {
            if (searchTerm.length >= 1) {
                if (cachedResults[searchTerm]) {
                    updateProductsList(cachedResults[searchTerm]);
                } else {
                    searchProducts(searchTerm);
                }
            } else if (searchTerm.length === 0) {
                if (cachedResults['']) {
                    updateProductsList(cachedResults['']);
                } else {
                    resetSearch();
                }
            }
        }, 200);
    });
    
    function searchProducts(term) {
        
        fetch(`index.php?page=shop&action=search&term=${encodeURIComponent(term)}`)
            .then(response => response.json())
            .then(data => {
                cachedResults[term] = data.products;
                updateProductsList(data.products);
            })
            .catch(error => {
                console.error('Errore durante la ricerca:', error);
            });
    }
    
    function resetSearch() {
        fetch('index.php?page=shop&action=search&term=')
            .then(response => response.json())
            .then(data => {
                cachedResults[''] = data.products;
                updateProductsList(data.products);
            })
            .catch(error => {
                console.error('Errore durante il reset della ricerca:', error);
            });
    }
    
    function updateProductsList(products) {
        productsBox.innerHTML = '';
        
        if (products.length === 0) {
            productsBox.innerHTML = '<p class="no-results">Nessun prodotto trovato. Prova con un\'altra ricerca.</p>';
            return;
        }
        
        // Calcola la data di 7 giorni fa per i prodotti recenti
        const recentDate = new Date();
        recentDate.setDate(recentDate.getDate() - 7);
        
        products.forEach(product => {
            const productDate = new Date(product.data_creazione);
            const isRecent = productDate >= recentDate;
            
            const productElement = document.createElement('li');
            productElement.className = `product-card ${isRecent ? 'recent-product' : ''}`;
            
            productElement.innerHTML = `
                <article>
                    <h3 id="product-title-${product.id}">${product.nome}</h3>
                    <img src="${product.immagine}" 
                        alt="${product.nome}" 
                        loading="lazy"
                        width="200" 
                        height="200"
                        aria-labelledby="product-title-${product.id}">
                    <p class="prezzo">Prezzo: <abbr title="Euro">&#8364;</abbr>${parseFloat(product.prezzo).toFixed(2)}</p>
                    <p class="genere">Genere: ${product.genere}</p>
                    ${isRecent ? '<span class="badge">Nuovo!</span>' : ''}
                    <div class="product-actions">
                        <button class="add-to-cart" 
                                data-product-id="${product.id}">
                            Aggiungi ${product.nome} al carrello
                        </button>
                        <a href="index.php?page=product&id=${product.id}" class="view-product">
                            Visualizza ${product.nome}
                        </a>
                    </div>
                </article>
            `;
            
            productsBox.appendChild(productElement);
        });
        
        const cartData = {
            items: JSON.parse(localStorage.getItem('cartItems')) || [],
            total: 0
        };

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productCard = this.closest('.product-card');
                const productId = this.dataset.productId;
                const productName = productCard.querySelector('h3').textContent;
                const productPrice = parseFloat(productCard.querySelector('.prezzo').innerHTML.replace('Prezzo: <abbr title="Euro">€</abbr>', ''));
                const productImage = productCard.querySelector('img').src;

                addToCart({
                    id: productId,
                    nome: productName,
                    prezzo: productPrice,
                    immagine: productImage
                });
            });
        });

        function addToCart(product) {
            const existingItem = cartData.items.find(item => item.id === product.id);
        
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cartData.items.push({
                    ...product,
                    quantity: 1
                });
            }
        
            updateCart();
            saveCart();
        }

        function updateCart() {
            const cartList = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            const checkoutButton = document.getElementById('checkout-button');
                
            cartList.innerHTML = '';
            cartData.total = 0;
                
            cartData.items.forEach(item => {
                cartData.total += item.prezzo * item.quantity;
            
                const el = document.createElement('article');
                el.setAttribute('role', 'listitem');
                el.innerHTML = `
                    <div class="cart-item">
                        <span>${item.nome}</span>
                        <span><abbr title="Euro">&#8364;</abbr>${(item.prezzo * item.quantity).toFixed(2)}</span>
                        <div id="quantity-controls">
                            <button aria-label="Remove one ${item.nome}" 
                                    onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                            <span aria-label="Quantity">${item.quantity} <abbr title="Quantità">qta</abbr></span>
                            <button aria-label="Add one ${item.nome}"
                                    onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                        </div>
                    </div>
                `;
                cartList.appendChild(el);
            });
        
            cartTotal.innerHTML = `Totale: <abbr title="Euro">&#8364;</abbr>${cartData.total.toFixed(2)}`;
        
            // Controlla se il carrello è vuoto
            if (cartData.items.length === 0) {
                checkoutButton.style.display = 'none';
                if (!document.getElementById('empty-cart-message')) {
                    const emptyMessage = document.createElement('p');
                    emptyMessage.id = 'empty-cart-message';
                    emptyMessage.className = 'empty-cart';
                    emptyMessage.textContent = 'Inizia ad acquistare! Il tuo carrello è vuoto';
                    cartList.parentElement.appendChild(emptyMessage);
                }
            } else {
                checkoutButton.style.display = '';
                const emptyMessage = document.getElementById('empty-cart-message');
                if (emptyMessage) {
                    emptyMessage.remove();
                }
            }
        
            checkoutButton.disabled = cartData.items.length === 0;
        }
    
        function saveCart() {
            localStorage.setItem('cartItems', JSON.stringify(cartData.items));
        }
    
        window.updateQuantity = function(productId, newQuantity) {
            if (newQuantity <= 0) {
                cartData.items = cartData.items.filter(item => item.id !== productId);
            } else {
                const item = cartData.items.find(item => item.id === productId);
                if (item) {
                    item.quantity = newQuantity;
                }
            }
            updateCart();
            saveCart();
        };
    
        updateCart();
    }
});