document.addEventListener('DOMContentLoaded', function() {
    // Clear cart data from localStorage and sessionStorage
    localStorage.removeItem('cartItems');
    sessionStorage.removeItem('cartData');
    
    console.log('Cart data has been cleared successfully');
});