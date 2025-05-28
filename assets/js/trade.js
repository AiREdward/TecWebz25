document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('get-rating-button').addEventListener('click', function() {
        // Gets the selected values from the radio buttons
        const conditions = document.querySelector('input[name="condizioni"]:checked').value;
        const type = document.querySelector('input[name="tipologia"]:checked').value;
        const brand = document.querySelector('input[name="marca"]:checked').value;

        // Validates the selected values
        const query = new URLSearchParams({
            action: 'calc_rating',
            type,
            conditions,
            brand
        });
    
        // Makes the fetch request to the server
        fetch(`index.php?${query.toString()}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // document.getElementById('final-rating').innerText = `${data.rating},00`;
                    document.getElementById('final-rating').innerText = `€${data.rating}`;
                } else {
                    document.getElementById('final-rating').innerText = 'Error';
                }
        });
    });
});
