document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.getElementById('cart-hamburger-menu');
    const cart = document.getElementById('cart');

    // Aggiungi evento per mostrare/nascondere il carrello
    hamburgerMenu.addEventListener('click', function() {
        cart.classList.toggle('open');
    });

    // Chiudi il carrello se clicchi fuori (opzionale)
    document.addEventListener('click', function(event) {
        if (!cart.contains(event.target) && !hamburgerMenu.contains(event.target)) {
            cart.classList.remove('open');
        }
    });

    const cartData = {
        items: JSON.parse(localStorage.getItem('cartItems')) || [],
        total: 0
    };

    // Filter functionality
    const filterForm = document.getElementById('filter-form');
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    // Add change event listeners to checkboxes for immediate filtering
    document.querySelectorAll('input[name="genere"]').forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });

    // Add input event listeners to price inputs for immediate filtering
    document.getElementById('min-price').addEventListener('input', applyFilters);
    document.getElementById('max-price').addEventListener('input', applyFilters);

    // Add input validation for max-price
    document.getElementById('max-price').addEventListener('input', function() {
        const minValue = 5;
        if (this.value < minValue) {
            this.value = minValue;
        }
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

            // If no genres are selected, show no products
            const matchesGenre = selectedGenres.length > 0 && selectedGenres.includes(genre);
            const matchesPrice = price >= minPrice && price <= maxPrice;

            if (matchesGenre && matchesPrice) {
                product.style.display = '';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });

        // Update UI to show no results message if needed
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

    // Cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productCard = this.closest('.product-card');
            const productId = this.dataset.productId;
            const productName = productCard.querySelector('h3').textContent;
            const productPrice = parseFloat(productCard.querySelector('.prezzo').textContent.replace('Prezzo: $', ''));

            addToCart({
                id: productId,
                nome: productName,
                prezzo: productPrice
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
                    <span>$${(item.prezzo * item.quantity).toFixed(2)}</span>
                    <div class="quantity-controls">
                        <button aria-label="Remove one ${item.nome}" 
                                onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                        <span aria-label="Quantity">${item.quantity}</span>
                        <button aria-label="Add one ${item.nome}"
                                onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                    </div>
                </div>
            `;
            cartList.appendChild(li);
        });

        cartTotal.textContent = `Totale: $${cartData.total.toFixed(2)}`;

        // Check if the cart is empty
        if (cartData.items.length === 0) {
            checkoutButton.style.display = 'none'; // Hide the checkout button
            if (!document.getElementById('empty-cart-message')) {
                const emptyMessage = document.createElement('p');
                emptyMessage.id = 'empty-cart-message';
                emptyMessage.className = 'empty-cart';
                emptyMessage.textContent = 'Inizia ad acquistare! Il tuo carrello è vuoto';
                cartList.parentElement.appendChild(emptyMessage);
            }
        } else {
            checkoutButton.style.display = ''; // Show the checkout button
            const emptyMessage = document.getElementById('empty-cart-message');
            if (emptyMessage) {
                emptyMessage.remove(); // Remove the empty cart message
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

    // Initialize cart
    updateCart();

    // Redirect to payment page
    document.getElementById('checkout-button').addEventListener('click', function() {
        // Store cart data in sessionStorage for the payment page
        const cartData = {
            items: cart.items,
            total: cart.total
        };
        
        // Clear any existing cartData in sessionStorage
        sessionStorage.removeItem('cartData');
        
        // Store the new cartData
        sessionStorage.setItem('cartData', JSON.stringify(cartData));
        
        // Redirect to payment page
        window.location.href = 'index.php?page=payment';
    });
});