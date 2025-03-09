document.addEventListener('DOMContentLoaded', () => {
    const filterSelect = document.getElementById('filter');
    const productList = document.getElementById('product-list');
    const cartItems = document.getElementById('cart-items');

    filterSelect.addEventListener('change', () => {
        const filterValue = filterSelect.value;
        const products = Array.from(productList.children);

        products.sort((a, b) => {
            const priceA = parseFloat(a.getAttribute('data-price'));
            const priceB = parseFloat(b.getAttribute('data-price'));
            if (filterValue === 'low') {
                return priceA - priceB;
            } else if (filterValue === 'high') {
                return priceB - priceA;
            } else {
                return 0;
            }
        });

        products.forEach(product => productList.appendChild(product));
    });

    productList.addEventListener('click', (event) => {
        if (event.target.classList.contains('add-to-cart')) {
            const productId = event.target.getAttribute('data-product-id');
            const productName = event.target.parentElement.textContent.replace('Add to Cart', '').trim();

            const cartItem = document.createElement('li');
            cartItem.textContent = productName;
            cartItem.setAttribute('data-product-id', productId);

            const removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.addEventListener('click', () => {
                cartItems.removeChild(cartItem);
            });

            cartItem.appendChild(removeButton);
            cartItems.appendChild(cartItem);
        }
    });
});
