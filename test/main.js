const tabButtons = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked button
        button.classList.add('active');
        
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
    });
});

// Navigation
const navLinks = document.querySelectorAll('.nav-links a');
const sections = document.querySelectorAll('.section');

// Show first section by default
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

// Gestione del pulsante hamburger
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', function() {
            // Cambia l'icona da hamburger a X e viceversa
            const icon = hamburgerBtn.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }
    
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
            document.getElementById('edit-search-container').style.display = 'block';
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
                    // Show loading state
                    deleteSelectedBtn.textContent = 'Deleting...';
                    deleteSelectedBtn.disabled = true;
                    
                    // Send request to delete products
                    fetch('index.php?page=admin&action=delete_products', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ ids: productIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Reset button state
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
    // Get the container element based on mode
    const resultsList = document.getElementById(`${mode}-products-list`);
    
    // Clear the container
    resultsList.innerHTML = '';
    
    if (query.trim() === '') {
        resultsList.innerHTML = `<div class="product-row"><div class="product-cell no-results" colspan="5">Inserisci un termine di ricerca per trovare i prodotti</div></div>`;
        return;
    }
    
    // Show loading state
    resultsList.innerHTML = `<div class="product-row"><div class="product-cell no-results" colspan="5">Ricerca in corso...</div></div>`;
    
    // Fetch products from the database
    fetch(`index.php?page=admin&action=search_products&query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(products => {
            // Clear the container again
            resultsList.innerHTML = '';
            
            if (products.length === 0) {
                // Show no results message
                resultsList.innerHTML = `<div class="product-row"><div class="product-cell no-results" colspan="5">Nessun prodotto trovato</div></div>`;
                return;
            }
            
            // Create HTML for each product
            products.forEach(product => {
                const row = document.createElement('div');
                row.className = 'product-row';
                
                // Create selection cell (radio for edit, checkbox for delete)
                const selectionCell = document.createElement('div');
                selectionCell.className = 'product-cell';
                
                const selectionInput = document.createElement('input');
                
                if (mode === 'edit') {
                    selectionInput.type = 'radio';
                    selectionInput.name = 'product_id';
                } else {
                    selectionInput.type = 'checkbox';
                    selectionInput.name = 'product_ids[]';
                }
                
                selectionInput.value = product.id;
                selectionInput.id = `product-${product.id}`;
                selectionInput.dataset.product = JSON.stringify(product);
                
                selectionCell.appendChild(selectionInput);
                row.appendChild(selectionCell);
                
                // Add other cells
                const idCell = document.createElement('div');
                idCell.className = 'product-cell';
                idCell.textContent = product.id;
                row.appendChild(idCell);
                
                const nameCell = document.createElement('div');
                nameCell.className = 'product-cell';
                nameCell.textContent = product.name;
                row.appendChild(nameCell);
                
                const priceCell = document.createElement('div');
                priceCell.className = 'product-cell';
                priceCell.textContent = `${product.price} €`;
                row.appendChild(priceCell);
                
                const genreCell = document.createElement('div');
                genreCell.className = 'product-cell';
                genreCell.textContent = product.genre;
                row.appendChild(genreCell);
                
                resultsList.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Errore:', error);
            // Show error message
            resultsList.innerHTML = `<div class="product-row"><div class="product-cell no-results" colspan="5">Errore durante il caricamento dei prodotti</div></div>`;
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
        
        // Check if all required elements exist
        const editFormContainer = document.getElementById('edit-form-container');
        const editSearchContainer = document.getElementById('edit-search-container');
        
        if (!editFormContainer || !editSearchContainer) {
            console.error('Edit containers not found:', {
                editFormContainer: !!editFormContainer,
                editSearchContainer: !!editSearchContainer
            });
            alert('Error: Edit form elements not found. Please check the console for details.');
            return;
        }
        
        // Fill the edit form with product data
        const idField = document.getElementById('edit-product-id');
        const titleField = document.getElementById('edit-product-title');
        const priceField = document.getElementById('edit-product-price');
        const tradePriceField = document.getElementById('edit-product-trade-price');
        const descriptionField = document.getElementById('edit-product-description');
        const currentImageField = document.getElementById('current-image-path');
        
        // Check if all form fields exist
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
        
        // Set form field values
        idField.value = productData.id;
        titleField.value = productData.name;
        priceField.value = productData.price;
        tradePriceField.value = productData.tradePrice;
        descriptionField.value = productData.description;
        
        if (currentImageField) {
            currentImageField.value = productData.image || '';
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
        }
        
        // Show current image preview
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
        
        // Hide search container and show edit form
        editSearchContainer.style.display = 'none';
        editFormContainer.style.display = 'block';
        
        // Set up form submission
        const editForm = document.getElementById('edit-product-form');
        if (editForm) {
            editForm.onsubmit = function(e) {
                e.preventDefault();
                
                // Create FormData object to handle file uploads
                const formData = new FormData(editForm);
                
                // Show loading state
                const submitButton = editForm.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.textContent;
                submitButton.textContent = 'Aggiornamento in corso...';
                submitButton.disabled = true;
                
                // Send the data to the server using fetch API
                fetch('index.php?page=admin&action=update_product', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    submitButton.textContent = originalButtonText;
                    submitButton.disabled = false;
                    
                    if (data.success) {
                        // Show success message
                        alert(`Prodotto "${productData.name}" aggiornato con successo!`);
                        
                        // Go back to search
                        editFormContainer.style.display = 'none';
                        editSearchContainer.style.display = 'block';
                        
                        // Clear the search input to refresh the list
                        const searchInput = document.getElementById('search-product-edit');
                        if (searchInput && searchInput.value) {
                            searchProducts(searchInput.value, 'edit');
                        }
                    } else {
                        alert('Errore: ' + (data.message || 'Impossibile aggiornare il prodotto'));
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert("Si è verificato un errore durante l'aggiornamento del prodotto.");
                    
                    // Reset button state
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

// Modal functionality
const addProductBtn = document.getElementById('add-product-btn');
const addProductModal = document.getElementById('add-product-modal');
const closeModalBtn = document.querySelector('.close-modal');
const cancelModalBtn = document.querySelector('.cancel-modal');

// Open modal
if (addProductBtn) {
    addProductBtn.addEventListener('click', () => {
        addProductModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });
}

// Close modal functions
function closeModal() {
    addProductModal.style.display = 'none';
    document.body.style.overflow = 'auto';
    addProductForm.reset();
    imagePreview.style.backgroundImage = '';
    imagePreview.textContent = 'Image preview will appear here';
}

// Close modal with X button
if (closeModalBtn) {
    closeModalBtn.addEventListener('click', closeModal);
}

// Close modal with Cancel button
if (cancelModalBtn) {
    cancelModalBtn.addEventListener('click', closeModal);
}

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    if (e.target === addProductModal) {
        closeModal();
    }
});

// Form submission for the inline form
const addProductForm = document.getElementById('add-product-form');
const productImageInput = document.getElementById('product-image');
const imagePreview = document.getElementById('image-preview');

// Image preview functionality
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

// Form submission
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



// Funções para o menu hamburger
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');
    const mainContent = document.querySelector('.main-content');
    
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            hamburgerBtn.classList.toggle('active');
            mainContent.classList.toggle('sidebar-active');
        });
    }
    
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            hamburgerBtn.classList.remove('active');
            mainContent.classList.remove('sidebar-active');
        });
    }
    
    // Fechar o menu quando um link é clicado (em dispositivos móveis)
    const sidebarLinks = document.querySelectorAll('.sidebar a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                hamburgerBtn.classList.remove('active');
                mainContent.classList.remove('sidebar-active');
            }
        });
    });
    
    // Ajustar o menu quando a janela é redimensionada
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            hamburgerBtn.classList.remove('active');
            mainContent.classList.remove('sidebar-active');
        }
    });
});