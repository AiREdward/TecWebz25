document.addEventListener('DOMContentLoaded', function() {
    // Carica le valutazioni quando si accede alla sezione
    const valuationsSection = document.getElementById('valuations');
    const navLinks = document.querySelectorAll('#nav-links a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === '#valuations') {
            link.addEventListener('click', loadValuations);
        }
    });
    
    // Gestione del form di modifica
    const editValuationForm = document.getElementById('edit-valuation-form');
    if (editValuationForm) {
        editValuationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateValuation();
        });
    }
    
    // Gestione del pulsante per tornare alla lista
    const backToValuationsBtn = document.getElementById('back-to-valuations');
    if (backToValuationsBtn) {
        backToValuationsBtn.addEventListener('click', function() {
            document.getElementById('edit-valuation-form-container').style.display = 'none';
            document.querySelector('.valuation-grid').style.display = 'block';
        });
    }
});

// Funzione per caricare le valutazioni
function loadValuations() {
    fetch('index.php?page=admin&action=get_valuations')
        .then(response => response.json())
        .then(data => {
            const valuationsList = document.getElementById('valuations-list');
            valuationsList.innerHTML = '';
            
            if (data && data.length > 0) {
                data.forEach(valuation => {
                    const row = document.createElement('li');
                    row.className = 'valuation-row';
                    row.setAttribute('role', 'row');
                    
                    row.innerHTML = `
                        <div class="valuation-cell" role="cell">${valuation.nome}</div>
                        <div class="valuation-cell" role="cell">${valuation.categoria}</div>
                        <div class="valuation-cell" role="cell">${valuation.valore}</div>
                        <div class="valuation-cell" role="cell">
                            <button type="button" class="edit-valuation-btn" data-name="${valuation.nome}" data-categoria="${valuation.categoria}" data-valore="${valuation.valore}" aria-label="Modifica valutazione ${valuation.nome}">
                                <img src="assets/img/icons/pen-to-square-solid.svg" alt="Icona Modifica" width="20" height="20">
                            </button>
                        </div>
                    `;
                    
                    valuationsList.appendChild(row);
                });
                
                // Aggiungi event listener ai pulsanti di modifica
                document.querySelectorAll('.edit-valuation-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const name = this.getAttribute('data-name');
                        const categoria = this.getAttribute('data-categoria');
                        const valore = this.getAttribute('data-valore');
                        
                        showEditForm(name, categoria, valore);
                    });
                });
            } else {
                valuationsList.innerHTML = '<div class="no-results">Nessuna valutazione trovata</div>';
            }
        })
        .catch(error => {
            console.error('Errore durante il caricamento delle valutazioni:', error);
            showCustomPopup('Errore durante il caricamento delle valutazioni', 'error');
        });
}

// Funzione per mostrare il form di modifica
function showEditForm(name, categoria, valore) {
    // Nascondi la griglia delle valutazioni
    document.querySelector('.valuation-grid').style.display = 'none';
    
    // Popola il form con i dati della valutazione
    document.getElementById('edit-valuation-original-name').value = name;
    document.getElementById('edit-valuation-name').value = name;
    
    const categorySelect = document.getElementById('edit-valuation-category');
    for (let i = 0; i < categorySelect.options.length; i++) {
        if (categorySelect.options[i].value === categoria) {
            categorySelect.selectedIndex = i;
            break;
        }
    }
    
    document.getElementById('edit-valuation-value').value = valore;
    
    // Mostra il form di modifica
    document.getElementById('edit-valuation-form-container').style.display = 'block';
}

// Funzione per aggiornare una valutazione
function updateValuation() {
    const form = document.getElementById('edit-valuation-form');
    const formData = new FormData(form);
    
    fetch('index.php?page=admin&action=update_valuation', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCustomPopup('Valutazione aggiornata con successo', 'success');
            // Nascondi il form e ricarica le valutazioni
            document.getElementById('edit-valuation-form-container').style.display = 'none';
            document.querySelector('.valuation-grid').style.display = 'block';
            loadValuations();
        } else {
            showCustomPopup(data.message || 'Errore durante l\'aggiornamento della valutazione', 'error');
        }
    })
    .catch(error => {
        console.error('Errore durante l\'aggiornamento della valutazione:', error);
        showCustomPopup('Errore durante l\'aggiornamento della valutazione', 'error');
    });
}

// Funzione per mostrare popup personalizzati (riutilizzata da altre parti dell'applicazione)
function showCustomPopup(message, type) {
    if (typeof window.showPopup === 'function') {
        window.showPopup(message, type);
    } else {
        alert(message);
    }
}