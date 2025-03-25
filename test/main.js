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
