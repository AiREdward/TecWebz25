// Tab functionality for product management
const tabButtons = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons and contents
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked button
        button.classList.add('active');
        
        // Show corresponding content
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
    });
});

// Navigation
const navLinks = document.querySelectorAll('.nav-links a');
const sections = document.querySelectorAll('.section');

// Show first section by default
document.querySelector('.section').classList.add('active');
document.querySelector('.section').classList.remove('hidden'); // Assicurati che venga mostrata

navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Rimuove la classe active da tutti i link
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        
        // Nasconde tutte le sezioni
        sections.forEach(section => {
            section.classList.remove('active'); 
            section.classList.add('hidden'); // Nasconde tutte le sezioni
        });

        // Mostra la sezione selezionata
        const targetId = link.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
            targetSection.classList.add('active');
            targetSection.classList.remove('hidden'); // Rimuove la classe hidden
        }
    });
});

// Product search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality for edit products
    const searchEditInput = document.getElementById('search-product-edit');
    if (searchEditInput) {
        searchEditInput.addEventListener('input', function() {
            searchProducts(this.value, 'edit');
        });
    }
    
    // Search functionality for delete products
    const searchDeleteInput = document.getElementById('search-product-delete');
    if (searchDeleteInput) {
        searchDeleteInput.addEventListener('input', function() {
            searchProducts(this.value, 'delete');
        });
    }
    
    // Edit selected product button
    const editSelectedBtn = document.getElementById('edit-selected-product');
    if (editSelectedBtn) {
        editSelectedBtn.addEventListener('click', function() {
            const selectedProduct = document.querySelector('#edit-products-list input[type="radio"]:checked');
            if (selectedProduct) {
                const productId = selectedProduct.value;
                console.log('Loading product for edit, ID:', productId); // Debug log
                loadProductForEdit(productId);
            } else {
                alert('Please select a product to edit');
            }
        });
    }
    
    // Back to search button
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
                            
                            // Refresh the product list
                            const searchInput = document.getElementById('search-product-delete');
                            if (searchInput && searchInput.value) {
                                searchProducts(searchInput.value, 'delete');
                            } else {
                                // Clear the list if no search term
                                document.getElementById('delete-products-list').innerHTML = 
                                    '<tr><td colspan="5" class="no-results">Enter a search term to find products</td></tr>';
                            }
                        } else {
                            alert('Error: ' + (data.message || 'Failed to delete products'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the products.');
                        
                        // Reset button state
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

// Function to preview image
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

// Function to search products
function searchProducts(query, mode) {
    // Clear previous results
    const resultsList = document.getElementById(`${mode}-products-list`);
    resultsList.innerHTML = '';
    
    if (query.trim() === '') {
        resultsList.innerHTML = '<tr><td colspan="5" class="no-results">Enter a search term to find products</td></tr>';
        return;
    }
    
    // Show loading state
    resultsList.innerHTML = '<tr><td colspan="5" class="no-results">Searching...</td></tr>';
    
    // Fetch products from the database using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `index.php?page=admin&action=search_products&query=${encodeURIComponent(query)}`, true);
    
    xhr.onload = function() {
        if (this.status === 200) {
            try {
                const products = JSON.parse(this.responseText);
                
                // Display results
                if (products.length === 0) {
                    resultsList.innerHTML = '<tr><td colspan="5" class="no-results">No products found</td></tr>';
                } else {
                    resultsList.innerHTML = '';
                    products.forEach(product => {
                        const row = document.createElement('tr');
                        
                        // Create selection cell (radio for edit, checkbox for delete)
                        const selectionCell = document.createElement('td');
                        const selectionInput = document.createElement('input');
                        
                        if (mode === 'edit') {
                            selectionInput.type = 'radio';
                            selectionInput.name = 'edit-product-selection';
                        } else {
                            selectionInput.type = 'checkbox';
                            selectionInput.name = 'delete-product-selection[]';
                        }
                        
                        selectionInput.value = product.id;
                        selectionInput.dataset.product = JSON.stringify(product);
                        selectionCell.appendChild(selectionInput);
                        row.appendChild(selectionCell);
                        
                        // Add other cells
                        row.innerHTML += `
                            <td>${product.id}</td>
                            <td>${product.name}</td>
                            <td>€${parseFloat(product.price).toFixed(2)}</td>
                            <td>${product.genre}</td>
                        `;
                        
                        resultsList.appendChild(row);
                    });
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                resultsList.innerHTML = '<tr><td colspan="5" class="no-results">Error loading products</td></tr>';
            }
        } else {
            console.error('Request failed with status:', this.status);
            resultsList.innerHTML = '<tr><td colspan="5" class="no-results">Error loading products</td></tr>';
        }
    };
    
    xhr.onerror = function() {
        console.error('Request failed');
        resultsList.innerHTML = '<tr><td colspan="5" class="no-results">Error loading products</td></tr>';
    };
    
    xhr.send();
}

// Function to load product data for editing
function loadProductForEdit(productId) {
    console.log('loadProductForEdit called with ID:', productId); // Debug log
    
    // In a real application, you would fetch the product data from the server
    // For demo purposes, we'll get it from the data attribute we set earlier
    const selectedRadio = document.querySelector(`#edit-products-list input[value="${productId}"]`);
    if (!selectedRadio) {
        console.error('Selected radio not found'); // Debug log
        return;
    }
    
    try {
        const productData = JSON.parse(selectedRadio.dataset.product);
        console.log('Product data:', productData); // Debug log
        
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
                imagePreview.innerHTML = 'No image available';
            }
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
                submitButton.textContent = 'Updating...';
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
                        alert(`Product "${productData.name}" updated successfully!`);
                        
                        // Go back to search
                        editFormContainer.style.display = 'none';
                        editSearchContainer.style.display = 'block';
                        
                        // Clear the search input to refresh the list
                        const searchInput = document.getElementById('search-product-edit');
                        if (searchInput && searchInput.value) {
                            searchProducts(searchInput.value, 'edit');
                        }
                    } else {
                        alert('Error: ' + (data.message || 'Failed to update product'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the product.');
                    
                    // Reset button state
                    submitButton.textContent = originalButtonText;
                    submitButton.disabled = false;
                });
            };
        }
    } catch (error) {
        console.error('Error processing product data:', error);
        alert('Error loading product data. Please check the console for details.');
    }
}

// Filter functionality
const filterSelects = document.querySelectorAll('.filter-select');
filterSelects.forEach(select => {
    select.addEventListener('change', (e) => {
        // Add your filter logic here
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
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    });
}

// Close modal functions
function closeModal() {
    addProductModal.style.display = 'none';
    document.body.style.overflow = 'auto'; // Enable scrolling
    addProductForm.reset(); // Reset form
    imagePreview.style.backgroundImage = ''; // Clear image preview
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
            imagePreview.textContent = 'Image preview will appear here';
        }
    });
}

// Form submission
if (addProductForm) {
    addProductForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Create FormData object to handle file uploads
        const formData = new FormData(addProductForm);
        
        // Send the data to the server using fetch API
        fetch('index.php?page=admin&action=add_product', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                alert('Prodotto aggiunto con successo!');
                
                // Reset the form
                addProductForm.reset();
                imagePreview.style.backgroundImage = '';
                imagePreview.textContent = 'Image preview will appear here';
                
                // Reload the page to show the new product
                // Alternatively, you could dynamically add the new product to the DOM
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
