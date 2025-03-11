// Shop functionality
document.addEventListener('DOMContentLoaded', function() {
    const cart = {
        items: [],
        total: 0
    };

    // Filter functionality
    const filterForm = document.getElementById('filter-form');
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    // Add change event listeners to checkboxes for immediate filtering
    document.querySelectorAll('input[name="genre"]').forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });

    // Add input event listeners to price inputs for immediate filtering
    document.getElementById('min-price').addEventListener('input', applyFilters);
    document.getElementById('max-price').addEventListener('input', applyFilters);

    function applyFilters() {
        const selectedGenres = Array.from(document.querySelectorAll('input[name="genre"]:checked'))
            .map(input => input.value);
        const minPrice = parseFloat(document.getElementById('min-price').value) || 0;
        const maxPrice = parseFloat(document.getElementById('max-price').value) || Infinity;

        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        products.forEach(product => {
            const price = parseFloat(product.querySelector('.price').textContent.replace('$', ''));
            const genre = product.querySelector('.genre').textContent.toLowerCase();

            // If no genres are selected, show all products that match the price range
            const matchesGenre = selectedGenres.length === 0 || selectedGenres.includes(genre);
            const matchesPrice = price >= minPrice && price <= maxPrice;

            if (matchesGenre && matchesPrice) {
                product.style.display = '';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });

        // Announce filter results to screen readers
        announceToScreenReader(`Showing ${visibleCount} products`);

        // Update UI to show no results message if needed
        const noResultsMessage = document.getElementById('no-results-message');
        if (visibleCount === 0) {
            if (!noResultsMessage) {
                const message = document.createElement('p');
                message.id = 'no-results-message';
                message.className = 'no-results';
                message.setAttribute('role', 'alert');
                message.textContent = 'No products match your selected filters';
                document.querySelector('.products-grid').appendChild(message);
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
            const productPrice = parseFloat(productCard.querySelector('.price').textContent.replace('$', ''));

            addToCart({
                id: productId,
                name: productName,
                price: productPrice
            });
        });
    });

    function addToCart(product) {
        const existingItem = cart.items.find(item => item.id === product.id);

        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.items.push({
                ...product,
                quantity: 1
            });
        }

        updateCart();
        announceToScreenReader(`Added ${product.name} to cart`);
    }

    function updateCart() {
        const cartList = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const checkoutButton = document.getElementById('checkout-button');

        cartList.innerHTML = '';
        cart.total = 0;

        cart.items.forEach(item => {
            cart.total += item.price * item.quantity;

            const li = document.createElement('li');
            li.setAttribute('role', 'listitem');
            li.innerHTML = `
                <div class="cart-item">
                    <span>${item.name}</span>
                    <span>$${(item.price * item.quantity).toFixed(2)}</span>
                    <div class="quantity-controls">
                        <button aria-label="Remove one ${item.name}" 
                                onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                        <span aria-label="Quantity">${item.quantity}</span>
                        <button aria-label="Add one ${item.name}"
                                onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                    </div>
                </div>
            `;
            cartList.appendChild(li);
        });

        cartTotal.textContent = `Total: $${cart.total.toFixed(2)}`;
        checkoutButton.disabled = cart.items.length === 0;
    }

    function updateQuantity(productId, newQuantity) {
        if (newQuantity <= 0) {
            cart.items = cart.items.filter(item => item.id !== productId);
        } else {
            const item = cart.items.find(item => item.id === productId);
            if (item) {
                item.quantity = newQuantity;
            }
        }
        updateCart();
    }

    // Initialize cart
    updateCart();
});