document.addEventListener('DOMContentLoaded', function() {
    const filterTitle = document.querySelector('#filters h2');
    const filterForm = document.querySelector('#filter-form');
    
    if (filterTitle && filterForm) {
        filterTitle.addEventListener('click', function() {
            filterForm.classList.toggle('show');
            filterTitle.classList.toggle('active');
        });
    }
});