document.addEventListener('DOMContentLoaded', function() {
    const increaseButtons = document.querySelectorAll('.quantity-btn.increase');
    const decreaseButtons = document.querySelectorAll('.quantity-btn.decrease');
    const paymentButton = document.querySelector('#btn-pay'); 
    
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            updateQuantity(productId, 1);
        });
    });
    

    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            updateQuantity(productId, -1);
        });
    });
    
    function updateQuantity(productId, change) {
        const quantityElement = document.querySelector(`.quantity-value[data-product-id="${productId}"]`);
        const pricePerUnit = parseFloat(quantityElement.getAttribute('data-price'));
        
        let currentQuantity = parseInt(quantityElement.textContent);
        let newQuantity = currentQuantity + change;
        const itemContainer = quantityElement.closest('#payment-item');

        if (newQuantity <= 0) {
            itemContainer.remove();
        } else {
            quantityElement.textContent = newQuantity;
            const totalElement = itemContainer.querySelector('#payment-item-total .value');
            const newTotal = (pricePerUnit * newQuantity).toFixed(2);
            totalElement.textContent = `€${newTotal}`;
        }
        updateOrderTotal();
        updateCartSession();
    }
    
    function updateOrderTotal() {
        const itemTotals = document.querySelectorAll('#payment-item-total .value');
        let orderTotal = 0;
        
        itemTotals.forEach(item => {
            const itemTotal = parseFloat(item.textContent.replace('€', ''));
            orderTotal += itemTotal;
        });
        
        const orderTotalElement = document.querySelector('#payment-total .value strong');
        orderTotalElement.textContent = `€${orderTotal.toFixed(2)}`;


    }
    
    function updateCartSession() {
        const items = [];
        const productItems = document.querySelectorAll('#payment-item');
        
        productItems.forEach(item => {
            const id = item.querySelector('.quantity-value').getAttribute('data-product-id');
            const quantity = parseInt(item.querySelector('.quantity-value').textContent);
            const price = parseFloat(item.querySelector('.quantity-value').getAttribute('data-price'));
            const name = item.querySelector('#payment-item-name h3').textContent;
            const image = item.querySelector('#payment-item-image img')?.src || '';
            
            items.push({
                id: id,
                nome: name,
                prezzo: price,
                quantity: quantity,
                immagine: image
            });
        });
        
        const total = parseFloat(document.querySelector('#payment-total .value strong').textContent.replace('€', ''));
        const cartData = {
            items: items,
            total: total
        };
        
        const cartDataInput = document.getElementById('cart-data-input');
        if (cartDataInput) {
            cartDataInput.value = JSON.stringify(cartData);
        }
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?page=payment&action=update_cart', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('cartData=' + encodeURIComponent(JSON.stringify(cartData)));
    }

    // Aggiungi event listener al pulsante di pagamento una sola volta
    if (paymentButton) {
        paymentButton.addEventListener('click', function(event) {
            const orderTotalElement = document.querySelector('#payment-total .value strong');
            const orderTotal = parseFloat(orderTotalElement.textContent.replace('€', ''));

            if (orderTotal <= 0) {
                alert('Impossibile effettuare ordine: carrello vuoto');
                event.preventDefault(); // Impedisce l'invio del form se il carrello è vuoto
            }
            // Se l'ordine non è vuoto, il form verrà inviato normalmente
        });
    }

    // Esegui il controllo iniziale al caricamento della pagina per impostare lo stato iniziale del pulsante
    updateOrderTotal(); 
});