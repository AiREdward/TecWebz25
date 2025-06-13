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
        const itemContainer = quantityElement.closest('.payment-item');

        if (newQuantity <= 0) {
            itemContainer.remove();
        } else {
            quantityElement.textContent = newQuantity;
            const totalElement = itemContainer.querySelector('.payment-item-total .value');
            const newTotal = (pricePerUnit * newQuantity).toFixed(2);
            totalElement.innerHTML = `<abbr title="Euro">&#8364;</abbr>${newTotal}`;
        }
        updateOrderTotal();
        updateCartSession();
    }
    
    function updateOrderTotal() {
        const itemTotals = document.querySelectorAll('.payment-item-total .value');
        let orderTotal = 0;
        itemTotals.forEach(item => {
            const itemTotal = parseFloat(item.innerHTML.replace('<abbr title="Euro">&#8364;</abbr>', ''));
            orderTotal += itemTotal;
        });

        const orderTotalElement = document.querySelector('#payment-total .value strong');
        if (orderTotalElement) {
            orderTotalElement.innerHTML = `<abbr title="Euro">&#8364;</abbr>${orderTotal.toFixed(2)}`;
        }
    }
    
    function updateCartSession() {
        const items = [];
        const productItems = document.querySelectorAll('.payment-item');
        
        productItems.forEach(item => {
            const id = item.querySelector('.quantity-value').getAttribute('data-product-id');
            const quantity = parseInt(item.querySelector('.quantity-value').textContent);
            const price = parseFloat(item.querySelector('.quantity-value').getAttribute('data-price'));
            const name = item.querySelector('.payment-item-name h3').textContent;
            const image = item.querySelector('.payment-item-image img')?.src || '';
            
            items.push({
                id: id,
                nome: name,
                prezzo: price,
                quantity: quantity,
                immagine: image
            });
        });
        
        const totalElement = document.querySelector('#payment-total .value strong');
        const total = totalElement ? parseFloat(totalElement.innerHTML.replace('<abbr title="Euro">&#8364;</abbr>', '')) : 0;
        
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
    
    if (paymentButton) {
        paymentButton.addEventListener('click', function(event) {
            const orderTotalElement = document.querySelector('#payment-total .value strong');
            
            if (orderTotalElement) {
                const orderTotal = parseFloat(orderTotalElement.innerHTML.replace('<abbr title="Euro">&#8364;</abbr>', ''));
                if (isNaN(orderTotal)) {
                    showCustomPopup('Errore nel calcolo del totale', 'error');
                    event.preventDefault();
                    return;
                }

                if (orderTotal <= 0) {
                    showCustomPopup('Impossibile effettuare ordine: carrello vuoto', 'error');
                    event.preventDefault(); 
                }
            } else {
                showCustomPopup('Errore nel calcolo del totale', 'error');
                event.preventDefault();
            }
        });
    }
    
    updateOrderTotal(); 
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-form');
    const cardNumber = document.getElementById('card-number');
    const expiryDate = document.getElementById('expiry-date');
    const cvv = document.getElementById('cvv');
    const cardHolder = document.getElementById('card-holder');
    
    if (cardHolder) {
        cardHolder.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
        });
    }

    if (cardNumber) {
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
        });
    }
    
    if (expiryDate) {
        expiryDate.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/gi, '');
            
            if (value.length > 2) {
                e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
            } else {
                e.target.value = value;
            }
            validateExpiryDate(e.target.value);
        });
    }
    
    function validateExpiryDate(expiryValue) {
        const expiryErrorElement = document.getElementById('expiry-date-error');
        if (!expiryErrorElement) return;
        
        const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
        let expiryValid = expiryPattern.test(expiryValue);
        let cardExpired = false;  
        
        if (expiryValid && expiryValue.length === 5) {
            const [expiryMonth, expiryYearShort] = expiryValue.split('/');
            const expiryYear = parseInt('20' + expiryYearShort, 10);
            const currentYear = new Date().getFullYear();
            const currentMonth = new Date().getMonth() + 1;

            if (expiryYear < currentYear || (expiryYear === currentYear && parseInt(expiryMonth, 10) < currentMonth)) {
                cardExpired = true;
                expiryValid = false;
            }
        }
        
        if (expiryValue.length === 5 && !expiryValid) {
            expiryErrorElement.textContent = cardExpired ? 'La carta è scaduta' : 'Data non valida (MM/AA)';
            expiryErrorElement.style.display = 'block';
            expiryErrorElement.classList.add('error-active');
        } else {
            expiryErrorElement.style.display = 'none';
            expiryErrorElement.classList.remove('error-active');
        }
    }
    
    if (cvv) {
        cvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/gi, '');
        });
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            document.querySelectorAll('.error').forEach(el => {
                el.style.display = 'none';
            });
            
            if (cardHolder && !cardHolder.value.trim()) {
                const errorElement = document.getElementById('card-holder-error');
                if (errorElement) errorElement.style.display = 'block';
                isValid = false;
            }
            
            if (cardNumber) {
                const cardNumberValue = cardNumber.value.replace(/\s+/g, '');
                if (cardNumberValue.length !== 16 || !/^\d+$/.test(cardNumberValue)) {
                    const errorElement = document.getElementById('card-number-error');
                    if (errorElement) errorElement.style.display = 'block';
                    isValid = false;
                }
            }
            
            if (expiryDate) {
                const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
                const expiryValue = expiryDate.value;
                let expiryValid = expiryPattern.test(expiryValue);
                let cardExpired = false;

                if (expiryValid) {
                    const [expiryMonth, expiryYearShort] = expiryValue.split('/');
                    const expiryYear = parseInt('20' + expiryYearShort, 10);
                    const currentYear = new Date().getFullYear();
                    const currentMonth = new Date().getMonth() + 1;

                    if (expiryYear < currentYear || (expiryYear === currentYear && parseInt(expiryMonth, 10) < currentMonth)) {
                        cardExpired = true;
                        expiryValid = false; 
                    }
                }

                if (!expiryValid) {
                    const expiryErrorElement = document.getElementById('expiry-date-error');
                    if (expiryErrorElement) {
                        expiryErrorElement.textContent = cardExpired ? 'La carta è scaduta' : 'Data non valida (MM/AA)';
                        expiryErrorElement.style.display = 'block';
                    }
                    isValid = false;
                }
            }
            
            if (cvv && !/^\d{3,4}$/.test(cvv.value)) {
                const errorElement = document.getElementById('cvv-error');
                if (errorElement) errorElement.style.display = 'block';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    const cancelOrderBtn = document.getElementById('btn-cancel-order');
    const cancelOrderModal = document.getElementById('cancelOrderModal');
    const confirmCancelBtn = document.getElementById('confirm-cancel');
    const cancelCancelBtn = document.getElementById('cancel-cancel');
    
    // Apre modale
    if (cancelOrderBtn) {
        cancelOrderBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openCancelModal();
        });
    }
    
    // Conferma cancellazione
    if (confirmCancelBtn) {
        confirmCancelBtn.addEventListener('click', function() {
            // Chiudi il carrello
            localStorage.removeItem('cartItems');
            sessionStorage.removeItem('cartData');
            
            window.location.href = 'index.php?page=payment&action=cancel_order';
        });
    }
    
    // Chiudere il modale
    if (cancelCancelBtn) {
        cancelCancelBtn.addEventListener('click', function() {
            closeCancelModal();
        });
    }
    if (cancelOrderModal) {
        cancelOrderModal.addEventListener('click', function(e) {
            if (e.target === cancelOrderModal) {
                closeCancelModal();
            }
        });
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && cancelOrderModal.getAttribute('aria-hidden') === 'false') {
            closeCancelModal();
        }
    });

    
    function openCancelModal() {
        cancelOrderModal.setAttribute('aria-hidden', 'false');
        cancelOrderModal.style.display = 'flex';
        document.body.classList.add('modal-open');
        
        confirmCancelBtn.focus();
        
        trapFocus(cancelOrderModal);
    }
    
    function closeCancelModal() {
        cancelOrderModal.setAttribute('aria-hidden', 'true');
        cancelOrderModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        
        cancelOrderBtn.focus();
    }
    
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];
        
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-form');
    const cardNumber = document.getElementById('card-number');
    const expiryDate = document.getElementById('expiry-date');
    const cvv = document.getElementById('cvv');
    const cardHolder = document.getElementById('card-holder');
    
    if (cardNumber) {
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
        });
    }
    
    if (expiryDate) {
        expiryDate.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/gi, '');
            
            if (value.length > 2) {
                e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
            } else {
                e.target.value = value;
            }
            validateExpiryDate(e.target.value);
        });
    }
    
    function validateExpiryDate(expiryValue) {
        const expiryErrorElement = document.getElementById('expiry-date-error');
        if (!expiryErrorElement) return;
        
        const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
        let expiryValid = expiryPattern.test(expiryValue);
        let cardExpired = false;  
        
        if (expiryValid && expiryValue.length === 5) {
            const [expiryMonth, expiryYearShort] = expiryValue.split('/');
            const expiryYear = parseInt('20' + expiryYearShort, 10);
            const currentYear = new Date().getFullYear();
            const currentMonth = new Date().getMonth() + 1;

            if (expiryYear < currentYear || (expiryYear === currentYear && parseInt(expiryMonth, 10) < currentMonth)) {
                cardExpired = true;
                expiryValid = false;
            }
        }
        
        if (expiryValue.length === 5 && !expiryValid) {
            expiryErrorElement.textContent = cardExpired ? 'La carta è scaduta' : 'Data non valida (MM/AA)';
            expiryErrorElement.style.display = 'block';
            expiryErrorElement.classList.add('error-active');
        } else {
            expiryErrorElement.style.display = 'none';
            expiryErrorElement.classList.remove('error-active');
        }
    }
    
    if (cvv) {
        cvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/gi, '');
        });
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            document.querySelectorAll('.error').forEach(el => {
                el.style.display = 'none';
            });
            
            if (cardHolder && !cardHolder.value.trim()) {
                const errorElement = document.getElementById('card-holder-error');
                if (errorElement) errorElement.style.display = 'block';
                isValid = false;
            }
            
            if (cardNumber) {
                const cardNumberValue = cardNumber.value.replace(/\s+/g, '');
                if (cardNumberValue.length !== 16 || !/^\d+$/.test(cardNumberValue)) {
                    const errorElement = document.getElementById('card-number-error');
                    if (errorElement) errorElement.style.display = 'block';
                    isValid = false;
                }
            }
            
            if (expiryDate) {
                const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
                const expiryValue = expiryDate.value;
                let expiryValid = expiryPattern.test(expiryValue);
                let cardExpired = false;

                if (expiryValid) {
                    const [expiryMonth, expiryYearShort] = expiryValue.split('/');
                    const expiryYear = parseInt('20' + expiryYearShort, 10);
                    const currentYear = new Date().getFullYear();
                    const currentMonth = new Date().getMonth() + 1;

                    if (expiryYear < currentYear || (expiryYear === currentYear && parseInt(expiryMonth, 10) < currentMonth)) {
                        cardExpired = true;
                        expiryValid = false; 
                    }
                }

                if (!expiryValid) {
                    const expiryErrorElement = document.getElementById('expiry-date-error');
                    if (expiryErrorElement) {
                        expiryErrorElement.textContent = cardExpired ? 'La carta è scaduta' : 'Data non valida (MM/AA)';
                        expiryErrorElement.style.display = 'block';
                    }
                    isValid = false;
                }
            }
            
            if (cvv && !/^\d{3,4}$/.test(cvv.value)) {
                const errorElement = document.getElementById('cvv-error');
                if (errorElement) errorElement.style.display = 'block';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});

// Svuota il carrello
document.addEventListener('DOMContentLoaded', function() {
    localStorage.removeItem('cartItems');
    sessionStorage.removeItem('cartData');
    
    console.log('Carrello svuotato con successo.');
});