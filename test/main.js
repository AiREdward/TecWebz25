const tabButtons = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Aggiunge la classe active al pulsante cliccato
        button.classList.add('active');
        
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
    });
});

// Navigazione
const navLinks = document.querySelectorAll('.nav-links a');
const sections = document.querySelectorAll('.section');

// Mostra la prima sezione per impostazione predefinita
document.querySelector('.section').classList.add('active');
document.querySelector('.section').classList.remove('hidden');

navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Rimuove la classe active da tutti i link
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        
        // Nasconde tutte le sezioni
        sections.forEach(section => {
            section.classList.remove('active'); 
            section.classList.add('hidden');
        });

        // Mostra la sezione selezionata
        const targetId = link.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
            targetSection.classList.add('active');
            targetSection.classList.remove('hidden');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const searchEditInput = document.getElementById('search-product-edit');
    if (searchEditInput) {
        searchEditInput.addEventListener('input', function() {
            searchProducts(this.value, 'edit');
        });
    }
    
    const searchDeleteInput = document.getElementById('search-product-delete');
    if (searchDeleteInput) {
        searchDeleteInput.addEventListener('input', function() {
            searchProducts(this.value, 'delete');
        });
    }
    
    const editSelectedBtn = document.getElementById('edit-selected-product');
    if (editSelectedBtn) {
        editSelectedBtn.addEventListener('click', function() {
            const selectedProduct = document.querySelector('#edit-products-list input[type="radio"]:checked');
            if (selectedProduct) {
                const productId = selectedProduct.value;
                console.log('Loading product for edit, ID:', productId);
                loadProductForEdit(productId);
            } else {
                alert('Please select a product to edit');
            }
        });
    }
    
    const backToSearchBtn = document.getElementById('back-to-search');
    if (backToSearchBtn) {
        backToSearchBtn.addEventListener('click', function() {
            document.getElementById('edit-form-container').style.display = 'none';
        });
    }
    
    // Delete selected products button
    const deleteSelectedBtn = document.getElementById('delete-selected-products');
    if (deleteSelectedBtn) {
        deleteSelectedBtn.addEventListener('click', function() {
            const selectedProducts = document.querySelectorAll('#delete-products-list input[type="checkbox"]:checked');
            if (selectedProducts.length > 0) {
                const productIds = Array.from(selectedProducts).map(checkbox => checkbox.value);
                if (confirm(`Are you sure you want to delete ${productIds.length} product(s)?`)) {
                    // Mostra lo stato di caricamento
                    deleteSelectedBtn.textContent = 'Deleting...';
                    deleteSelectedBtn.disabled = true;
                    
                    // Invia richiesta per eliminare i prodotti
                    fetch('index.php?controller=admin&action=delete_products', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ ids: productIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Ripristina lo stato del pulsante
                        deleteSelectedBtn.textContent = 'Elimina gli elementi selezionati';
                        deleteSelectedBtn.disabled = false;
                        
                        if (data.success) {
                            alert(`Deleted ${productIds.length} product(s) successfully!`);
                            
                            const searchInput = document.getElementById('search-product-delete');
                            if (searchInput && searchInput.value) {
                                searchProducts(searchInput.value, 'delete');
                            } else {
                                document.getElementById('delete-products-list').innerHTML = 
                                    '<div class="product-row"><div class="product-cell no-results">Inserisci un termine di ricerca per trovare i prodotti</div></div>';
                            }
                        } else {
                            alert('Error: ' + (data.message || 'Failed to delete products'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the products.');
                        
                        deleteSelectedBtn.textContent = 'Elimina gli elementi selezionati';
                        deleteSelectedBtn.disabled = false;
                    });
                }
            } else {
                alert('Please select at least one product to delete');
            }
        });
    }
    
    // Handle file input preview for add product
    const productImageInput = document.getElementById('product-image');
    if (productImageInput) {
        productImageInput.addEventListener('change', function(e) {
            previewImage(e.target, 'image-preview');
        });
    }
    
    // Handle file input preview for edit product
    const editProductImageInput = document.getElementById('edit-product-image');
    if (editProductImageInput) {
        editProductImageInput.addEventListener('change', function(e) {
            previewImage(e.target, 'edit-image-preview');
        });
    }
});

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '';
            preview.style.backgroundImage = `url('${e.target.result}')`;
            preview.style.backgroundSize = 'cover';
            preview.style.backgroundPosition = 'center';
            preview.style.height = '200px';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function searchProducts(query, mode) {
    fetch(`index.php?page=admin&action=search_products&query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(products => {
            // Get the container element based on mode
            const container = document.getElementById(`${mode}-products-list`);
            
            // Clear the container
            container.innerHTML = '';
            
            if (products.length === 0) {
                // Mostra messaggio di nessun risultato
                container.innerHTML = `<div class="product-row"><div class="product-cell no-results" colspan="5">Nessun prodotto trovato</div></div>`;
                return;
            }
            
            // Crea HTML per ogni prodotto
            products.forEach(product => {
                const row = document.createElement('div');
                row.className = 'product-row';
                
                if (mode === 'edit') {
                    row.innerHTML = `
                        <div class="product-cell">
                            <input type="radio" name="product_id" value="${product.id}" id="product-${product.id}">
                        </div>
                        <div class="product-cell">${product.id}</div>
                        <div class="product-cell">${product.name}</div>
                        <div class="product-cell">${product.price} €</div>
                        <div class="product-cell">${product.genre}</div>
                    `;
                } else if (mode === 'delete') {
                    row.innerHTML = `
                        <div class="product-cell">
                            <input type="checkbox" name="product_ids[]" value="${product.id}" id="product-${product.id}">
                        </div>
                        <div class="product-cell">${product.id}</div>
                        <div class="product-cell">${product.name}</div>
                        <div class="product-cell">${product.price} €</div>
                        <div class="product-cell">${product.genre}</div>
                    `;
                }
                
                container.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            // Mostra messaggio di errore
            const container = document.getElementById(`${mode}-products-list`);
            container.innerHTML = `<div class="product-row"><div class="product-cell no-results" colspan="5">Errore durante il caricamento dei prodotti</div></div>`;
        });
}

function loadProductForEdit(productId) {
    console.log('loadProductForEdit called with ID:', productId);
    
    const selectedRadio = document.querySelector(`#edit-products-list input[value="${productId}"]`);
    if (!selectedRadio) {
        console.error('Selected radio not found');
        return;
    }
    
    try {
        const productData = JSON.parse(selectedRadio.dataset.product);
        console.log('Product data:', productData);
        
        // Verifica se tutti gli elementi richiesti esistono
        const editFormContainer = document.getElementById('edit-form-container');
        if (!editFormContainer) {
            console.error('Edit form container not found:', {
                editFormContainer: !!editFormContainer
            });
            alert('Error: Edit form elements not found. Please check the console for details.');
            return;
        }
        
        // Compila il modulo di modifica con i dati del prodotto
        const idField = document.getElementById('edit-product-id');
        const titleField = document.getElementById('edit-product-title');
        const priceField = document.getElementById('edit-product-price');
        const tradePriceField = document.getElementById('edit-product-trade-price');
        const descriptionField = document.getElementById('edit-product-description');
        const currentImageField = document.getElementById('current-image-path');
        
        // Verifica se tutti i campi del modulo esistono
        if (!idField || !titleField || !priceField || !tradePriceField || !descriptionField) {
            console.error('Form fields not found:', {
                idField: !!idField,
                titleField: !!titleField,
                priceField: !!priceField,
                tradePriceField: !!tradePriceField,
                descriptionField: !!descriptionField
            });
            alert('Error: Form fields not found. Please check the console for details.');
            return;
        }
        
        // Imposta i valori dei campi del modulo
        idField.value = productData.id;
        titleField.value = productData.name;
        priceField.value = productData.price;
        tradePriceField.value = productData.tradePrice;
        descriptionField.value = productData.description;
        
        // Verifica che currentImageField esista prima di usarlo
        if (currentImageField) {
            currentImageField.value = productData.image || '';
        } else {
            console.error('Campo current-image-path non trovato');
        }
        
        // Set the genre dropdown
        const genreSelect = document.getElementById('edit-product-genre');
        if (genreSelect) {
            for (let i = 0; i < genreSelect.options.length; i++) {
                if (genreSelect.options[i].value === productData.genre) {
                    genreSelect.selectedIndex = i;
                    break;
                }
            }
        } else {
            console.error('Campo edit-product-genre non trovato');
        }
        
        // Mostra anteprima dell'immagine corrente
        const imagePreview = document.getElementById('edit-image-preview');
        if (imagePreview) {
            if (productData.image) {
                imagePreview.style.backgroundImage = `url('${productData.image}')`;
                imagePreview.style.backgroundSize = 'cover';
                imagePreview.style.backgroundPosition = 'center';
                imagePreview.style.height = '200px';
                imagePreview.innerHTML = '';
            } else {
                imagePreview.style.backgroundImage = 'none';
                imagePreview.innerHTML = 'Nessuna immagine disponibile';
            }
        } else {
            console.error('Campo edit-image-preview non trovato');
        }
        
        // Nascondi il contenitore di ricerca e mostra il modulo di modifica
        editSearchContainer.style.display = 'none';
        editFormContainer.style.display = 'block';
        
        // Configura l'invio del modulo
        const editForm = document.getElementById('edit-product-form');
        if (editForm) {
            editForm.onsubmit = function(e) {
                e.preventDefault();
                
                // Crea oggetto FormData per gestire il caricamento dei file
                const formData = new FormData(editForm);
                
                // Mostra lo stato di caricamento
                const submitButton = editForm.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.textContent;
                submitButton.textContent = 'Aggiornamento in corso...';
                submitButton.disabled = true;
                
                // Invia i dati al server utilizzando l'API fetch
                fetch('index.php?controller=admin&action=update_product', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Ripristina lo stato del pulsante
                    submitButton.textContent = originalButtonText;
                    submitButton.disabled = false;
                    
                    if (data.success) {
                        // Mostra messaggio di successo
                        alert(`Prodotto "${productData.name}" aggiornato con successo!`);
                        
                        // Torna alla ricerca
                        editFormContainer.style.display = 'none';
                        editSearchContainer.style.display = 'block';
                        
                    } else {
                        alert('Errore: ' + (data.message || 'Impossibile aggiornare il prodotto'));
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert("Si è verificato un errore durante l'aggiornamento del prodotto.");
                    
                    // Ripristina lo stato del pulsante
                    submitButton.textContent = originalButtonText;
                    submitButton.disabled = false;
                });
            };
        }
    } catch (error) {
        console.error('Errore durante l\'elaborazione dei dati del prodotto:', error);
        alert('Errore durante il caricamento dei dati del prodotto. Controlla la console per i dettagli.');
    }
}

const filterSelects = document.querySelectorAll('.filter-select');
filterSelects.forEach(select => {
    select.addEventListener('change', (e) => {
        console.log('Filter changed to:', e.target.value);
    });
});

// Funzionalità modale
const addProductBtn = document.getElementById('add-product-btn');
const addProductModal = document.getElementById('add-product-modal');
const closeModalBtn = document.querySelector('.close-modal');
const cancelModalBtn = document.querySelector('.cancel-modal');

// Apri modale
if (addProductBtn) {
    addProductBtn.addEventListener('click', () => {
        addProductModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });
}

// Funzioni per chiudere la modale
function closeModal() {
    addProductModal.style.display = 'none';
    document.body.style.overflow = 'auto';
    addProductForm.reset();
    imagePreview.style.backgroundImage = '';
    imagePreview.textContent = 'Image preview will appear here';
}

// Chiudi modale con il pulsante X
if (closeModalBtn) {
    closeModalBtn.addEventListener('click', closeModal);
}

// Chiudi modale con il pulsante Annulla
if (cancelModalBtn) {
    cancelModalBtn.addEventListener('click', closeModal);
}

// Chiudi modale quando si fa clic all'esterno
window.addEventListener('click', (e) => {
    if (e.target === addProductModal) {
        closeModal();
    }
});

// Invio del modulo inline
const addProductForm = document.getElementById('add-product-form');
const productImageInput = document.getElementById('product-image');
const imagePreview = document.getElementById('image-preview');

// Funzionalità di anteprima immagine
if (productImageInput) {
    productImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.style.backgroundImage = `url(${e.target.result})`;
                imagePreview.textContent = '';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.backgroundImage = '';
            imagePreview.textContent = 'L\'anteprima dell\'immagine apparirà qui';
        }
    });
}

// Invio del modulo
if (addProductForm) {
    addProductForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const formData = new FormData(addProductForm);
        
        fetch('index.php?page=admin&action=add_product', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {

                alert('Prodotto aggiunto con successo!');
                
                addProductForm.reset();
                imagePreview.style.backgroundImage = '';
                imagePreview.textContent = 'L\'anteprima dell\'immagine apparirà qui';
                
                location.reload();
            } else {
                alert('Errore: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Si è verificato un errore durante l\'aggiunta del prodotto.');
        });
    });
}

function updateStatistics() {
    fetch('index.php?page=admin&action=get_statistics')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.stat-card:nth-child(1) .stat-number').textContent = data.total_users;

            document.querySelector('.stat-card:nth-child(1) .stat-change').innerHTML = `<i class="fa fa-circle" aria-hidden="true"></i> Attivi: ${data.active_users}`;
                
            document.querySelector('.stat-card:nth-child(2) .stat-number').textContent = data.total_products;
            
            document.querySelector('.stat-card:nth-child(3) .stat-number').textContent = data.total_sales;
            
            document.querySelector('.stat-card:nth-child(4) .stat-number').textContent = data.total_products_sold;
            
            document.querySelector('.stat-card:nth-child(5) .stat-number').textContent = `${data.total_revenue} €`;
        })
        .catch(error => console.error('Errore nel caricamento delle statistiche:', error));
}

// Aggiorna le statistiche quando si clicca sulla tab Statistiche
document.querySelector('.nav-links a[href="#statistics"]').addEventListener('click', updateStatistics);