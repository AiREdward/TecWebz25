document.addEventListener('DOMContentLoaded', function () {
    const successContainer = document.getElementById('success-container');
    if (successContainer) {
        localStorage.removeItem('cartItems');
        sessionStorage.removeItem('cartData');
        return;
    }
    const form = document.getElementById('payment-form');
    const cardNumber = document.getElementById('card-number');
    const expiryDate = document.getElementById('expiry-date');
    const cvv = document.getElementById('cvv');
    const cardHolder = document.getElementById('card-holder');

    // Titolare della carta
    if (cardHolder) {
        cardHolder.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
            if (value.length > 50) {
                value = value.substring(0, 50);
            }
            e.target.value = value;

            const errorElement = document.getElementById('card-holder-error');
            if (errorElement) {
                if (value.trim().length < 2) {
                    errorElement.textContent = 'Il nome deve contenere almeno 2 caratteri';
                    errorElement.style.display = 'block';
                } else {
                    errorElement.style.display = 'none';
                }
            }
        });
    }

    // Numero della carta
    if (cardNumber) {
        cardNumber.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/g, '');
            if (value.length > 16) {
                value = value.substring(0, 16);
            }

            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }

            e.target.value = formattedValue;
            validateCardNumber(value);
        });
    }

    function validateCardNumber(rawValue) {
        const errorElement = document.getElementById('card-number-error');
        if (!errorElement) return;

        if (rawValue.length < 13) {
            errorElement.textContent = 'Il numero della carta deve contenere almeno 13 cifre';
            errorElement.style.display = 'block';
        } else if (rawValue.length > 16) {
            errorElement.textContent = 'Il numero della carta non può superare 16 cifre';
            errorElement.style.display = 'block';
        } else if (rawValue.length === 16 && !isValidCardNumber(rawValue)) {
            errorElement.textContent = 'Numero della carta non valido';
            errorElement.style.display = 'block';
        } else {
            errorElement.style.display = 'none';
        }
    }

    // Data di scadenza
    if (expiryDate) {
        expiryDate.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9]/g, '');

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

    // CVV
    if (cvv) {
        cvv.addEventListener('input', function (e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.length > 4) {
                value = value.substring(0, 4);
            }
            e.target.value = value;

            const errorElement = document.getElementById('cvv-error');
            if (errorElement) {
                if (value.length > 0 && value.length < 3) {
                    errorElement.textContent = 'CVV non valido';
                    errorElement.style.display = 'block';
                } else {
                    errorElement.style.display = 'none';
                }
            }
        });
    }

    // Submit del form
    if (form) {
        form.addEventListener('submit', function (e) {
            let isValid = true;
            document.querySelectorAll('.error').forEach(el => el.style.display = 'none');

            const holderValue = cardHolder?.value.trim() ?? '';
            const cardValue = cardNumber?.value.replace(/\s+/g, '') ?? '';
            const expiryValue = expiryDate?.value ?? '';
            const cvvValue = cvv?.value.trim() ?? '';

            // Validazioni
            if (!holderValue || holderValue.length < 2 || !/^[a-zA-ZÀ-ÿ\s]+$/.test(holderValue)) {
                document.getElementById('card-holder-error').textContent =
                    !holderValue ? 'Il nome del titolare è obbligatorio'
                    : holderValue.length < 2 ? 'Il nome deve contenere almeno 2 caratteri'
                    : 'Il nome può contenere solo lettere e spazi';
                document.getElementById('card-holder-error').style.display = 'block';
                isValid = false;
            }

            validateCardNumber(cardValue);
            if (cardValue.length < 13 || cardValue.length > 16 || !/^\d+$/.test(cardValue) || (cardValue.length === 16 && !isValidCardNumber(cardValue))) {
                isValid = false;
            }

            validateExpiryDate(expiryValue);
            const expiryPattern = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
            if (!expiryPattern.test(expiryValue)) {
                isValid = false;
            }

            if (!/^\d{3,4}$/.test(cvvValue)) {
                document.getElementById('cvv-error').textContent = 'Il CVV deve contenere 3 o 4 cifre';
                document.getElementById('cvv-error').style.display = 'block';
                isValid = false;
            }

            if (!isValid) e.preventDefault();
        });
    }

    // Gestione Quantità Carrello
    const cartDataInput = document.getElementById('cart-data-input');
    let cartData = { items: [], total: 0 };
    if (cartDataInput && cartDataInput.value) {
        try {
            cartData = JSON.parse(cartDataInput.value);
        } catch (e) {
            cartData = { items: [], total: 0 };
        }
    }

    function updateCartTotals() {
        let total = 0;
        cartData.items.forEach(item => {
            const qtySpan = document.querySelector(`.quantity-value[data-product-id="${item.id}"]`);
            if (qtySpan) {
                qtySpan.textContent = item.quantity;
                const itemContainer = qtySpan.closest('.payment-item');
                const price = parseFloat(qtySpan.dataset.price);
                const totalSpan = itemContainer ? itemContainer.querySelector('.payment-item-total .value') : null;
                if (totalSpan && !isNaN(price)) {
                    totalSpan.innerHTML = `<abbr title="Euro">&#8364;</abbr>${(price * item.quantity).toFixed(2)}`;
                }
                if (!isNaN(price)) total += price * item.quantity;
            }
        });

        const orderTotal = document.querySelector('#payment-total .value');
        if (orderTotal) {
            orderTotal.innerHTML = `<strong><abbr title="Euro">&#8364;</abbr>${total.toFixed(2)}</strong>`;
        }
        cartData.total = total;
        if (cartDataInput) cartDataInput.value = JSON.stringify(cartData);
    }

    function sendCartUpdate() {
        fetch('index.php?page=payment&action=update_cart', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'cartData=' + encodeURIComponent(JSON.stringify(cartData))
        }).catch(() => {});
    }

    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const item = cartData.items.find(i => String(i.id) === String(productId));
            if (!item) return;

            if (this.classList.contains('increase')) {
                item.quantity += 1;
            } else if (this.classList.contains('decrease') && item.quantity > 1) {
                item.quantity -= 1;
            }

            updateCartTotals();
            sendCartUpdate();
        });
    });

    // --- Gestione Annullamento Ordine ---
    const cancelOrderBtn = document.getElementById('btn-cancel-order');
    const cancelModal = document.getElementById('cancelOrderModal');
    const confirmCancelBtn = document.getElementById('confirm-cancel');
    const cancelCancelBtn = document.getElementById('cancel-cancel');

    if (cancelOrderBtn && cancelModal) {
        cancelOrderBtn.addEventListener('click', () => {
            cancelModal.setAttribute('aria-hidden', 'false');
        });
    }

    if (cancelCancelBtn && cancelModal) {
        cancelCancelBtn.addEventListener('click', () => {
            cancelModal.setAttribute('aria-hidden', 'true');
        });
    }

    if (confirmCancelBtn) {
        confirmCancelBtn.addEventListener('click', () => {
            // Pulisci i dati del carrello lato client prima di lasciare la pagina di pagamento
            localStorage.removeItem('cartItems');
            sessionStorage.removeItem('cartData');
            window.location.href = 'index.php?page=payment&action=cancel_order';
        });
    }
});

// Implementazione algoritmo di Luhn
function isValidCardNumber(cardNumber) {
    const cleanNumber = cardNumber.replace(/\D/g, '');
    if (!/^\d{13,19}$/.test(cleanNumber)) return false;

    let sum = 0;
    let isEven = false;
    for (let i = cleanNumber.length - 1; i >= 0; i--) {
        let digit = parseInt(cleanNumber.charAt(i), 10);
        if (isEven) {
            digit *= 2;
            if (digit > 9) digit -= 9;
        }
        sum += digit;
        isEven = !isEven;
    }
    return (sum % 10) === 0;
}
