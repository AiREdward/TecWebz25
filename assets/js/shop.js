document.addEventListener('DOMContentLoaded', function() {
    const cart = document.getElementById('cart');
    const closeCartButton = document.getElementById('close-cart');
    const hamburgerMenu = document.getElementById('cart-hamburger-menu');

    cart.addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Aggiungi evento per mostrare/nascondere il carrello
    hamburgerMenu.addEventListener('click', function(event) {
        event.stopPropagation();
        cart.classList.toggle('open');
    });

    // Aggiungi evento per chiudere il carrello
    closeCartButton.addEventListener('click', function(event) {
        event.stopPropagation();
        cart.classList.remove('open');
    });

    // Chiudi il carrello se clicchi fuori
    document.addEventListener('click', function() {
        cart.classList.remove('open');
    });

    const cartData = {
        items: JSON.parse(localStorage.getItem('cartItems')) || [],
        total: 0
    };

    const filterForm = document.getElementById('filter-form');
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    document.getElementById('max-price').addEventListener('input', function() {
        const minValue = 5;
        if (this.value < minValue) {
            this.value = minValue;
        }
    });

    const selectAllCheckbox = document.getElementById('select-all-genres');
    const genreCheckboxes = document.querySelectorAll('input[name="genere"]');

    // Inizializza "Seleziona tutti" come selezionata e tutti i generi come selezionati
    selectAllCheckbox.checked = true;
    genreCheckboxes.forEach(checkbox => checkbox.checked = true);
    const allCheckedInitially = Array.from(genreCheckboxes).every(cb => cb.checked);
    selectAllCheckbox.indeterminate = !allCheckedInitially;

    // Aggiungi evento per "Seleziona tutti"
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        genreCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });

    // Aggiorna lo stato di "Seleziona tutti" quando una checkbox cambia
    genreCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(genreCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(genreCheckboxes).every(cb => !cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = !allChecked && !noneChecked;
        });
    });

    function applyFilters() {
        const selectedGenres = Array.from(document.querySelectorAll('input[name="genere"]:checked'))
            .map(input => input.value.toLowerCase());
        const minPrice = parseFloat(document.getElementById('min-price').value) || 0;
        const maxPrice = parseFloat(document.getElementById('max-price').value) || Infinity;

        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        products.forEach(product => {
            const price = parseFloat(product.querySelector('.prezzo').textContent.replace('Prezzo: $', ''));
            const genre = product.querySelector('.genere').textContent.replace('Genere: ', '').toLowerCase();

            // Se non sono selezionati generi o il prezzo è fuori dai limiti, nascondi il prodotto
            const matchesGenre = selectedGenres.length > 0 && selectedGenres.includes(genre);
            const matchesPrice = price >= minPrice && price <= maxPrice;

            if (matchesGenre && matchesPrice) {
                product.style.display = '';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });

        // Mostra o nasconde il messaggio di "Nessun risultato trovato"
        const noResultsMessage = document.getElementById('no-results-message');
        if (visibleCount === 0) {
            if (!noResultsMessage) {
                const message = document.createElement('p');
                message.id = 'no-results-message';
                message.className = 'no-results';
                message.setAttribute('role', 'alert');
                message.textContent = 'Nessun risultato trovato. Prova a modificare i filtri.';
                document.querySelector('#products-box').appendChild(message);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }

    // CARRELLO
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productCard = this.closest('.product-card');
            const productId = this.dataset.productId;
            const productName = productCard.querySelector('h3').textContent;
            const productPrice = parseFloat(productCard.querySelector('.prezzo').textContent.replace('Prezzo: $', ''));
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

            const li = document.createElement('li');
            li.setAttribute('role', 'listitem');
            li.innerHTML = `
                <div class="cart-item">
                    <span>${item.nome}</span>
                    <span>€${(item.prezzo * item.quantity).toFixed(2)}</span>
                    <div id="quantity-controls">
                        <button aria-label="Remove one ${item.nome}" 
                                onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                        <span aria-label="Quantity">${item.quantity} <abbr title="Quantità">qta</abbr></span>
                        <button aria-label="Add one ${item.nome}"
                                onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                    </div>
                </div>
            `;
            cartList.appendChild(li);
        });

        cartTotal.textContent = `Totale: €${cartData.total.toFixed(2)}`;

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

    // Reinderizza al pagamento
    document.getElementById('checkout-button').addEventListener('click', function() {
        // Salva i dati del carrello nel sessionStorage per la pagina di pagamento
        const cartDataToSend = {
            items: cartData.items,
            total: cartData.total
        };
        
        // Rimuovi i dati esistenti del carrello dal sessionStorage
        sessionStorage.removeItem('cartData');
        
        // Memorizza i nuovi dati del carrello
        sessionStorage.setItem('cartData', JSON.stringify(cartDataToSend));

        // Invia i dati al server tramite POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?page=shop&action=checkout';
        form.style.display = 'none';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'cartData';
        input.value = JSON.stringify(cartDataToSend);

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
        
        return false;
    });
});