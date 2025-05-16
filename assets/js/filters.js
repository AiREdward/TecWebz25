document.addEventListener('DOMContentLoaded', function() {
    const filterTitle = document.querySelector('#filters h2');
    const filterForm = document.querySelector('#filter-form');
    const searchContainer = document.querySelector('#search-container');
    
    if (filterTitle && filterForm) {
        filterTitle.addEventListener('click', function() {
            filterForm.classList.toggle('show');
            filterTitle.classList.toggle('active');
            
            // Aggiungi la classe show anche al contenitore di ricerca
            if (searchContainer) {
                searchContainer.classList.toggle('show');
            }
        });
    }
});