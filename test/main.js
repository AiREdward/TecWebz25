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

// Search functionality
const searchInputs = document.querySelectorAll('input[type="search"]');
searchInputs.forEach(input => {
    input.addEventListener('input', (e) => {
        // Add your search logic here
        console.log('Searching for:', e.target.value);
    });
});

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
