document.addEventListener('DOMContentLoaded', function() {
    const getRatingButton = document.getElementById('get-rating-button');
    
    if (!getRatingButton) {
        console.error('Pulsante get-rating-button non trovato');
        return;
    }
    
    getRatingButton.addEventListener('click', function() {
        const conditionsElement = document.querySelector('input[name="condizioni"]:checked');
        const typeElement = document.querySelector('input[name="tipologia"]:checked');
        const brandElement = document.querySelector('input[name="marca"]:checked');
        
        if (!conditionsElement) {
            alert('Seleziona le condizioni del Prodotto');
            return;
        }
        
        if (!typeElement) {
            alert('Seleziona la tipologia del Prodotto');
            return;
        }
        
        if (!brandElement) {
            alert('Seleziona la marca del Prodotto');
            return;
        }
        
        const conditions = conditionsElement.value;
        const type = typeElement.value;
        const brand = brandElement.value;

        const query = new URLSearchParams({
            action: 'calc_rating',
            type,
            conditions,
            brand
        });
    
        fetch(`index.php?${query.toString()}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                const finalRatingElement = document.getElementById('final-rating');
                
                if (!finalRatingElement) {
                    console.error('Elemento final-rating non trovato');
                    return;
                }
                
                if (data.status === 'success') {
                    finalRatingElement.innerText = `€${data.rating}`;
                } else {
                    finalRatingElement.innerText = 'Errore nel calcolo';
                    console.error('Errore dal server:', data);
                }
            })
            .catch(error => {
                console.error('Errore nella richiesta:', error);
                const finalRatingElement = document.getElementById('final-rating');
                if (finalRatingElement) {
                    finalRatingElement.innerText = 'Errore di connessione';
                }
            });
    });
});