function searchUsers(query) {
    const userItems = document.querySelectorAll('.user-item');
    query = query.toLowerCase();
    
    userItems.forEach(item => {
        const username = item.querySelector('.user-name').textContent.toLowerCase();
        
        if (username.includes(query)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchUserInput = document.querySelector('#users #filter-group input[type="search"]');
    if (searchUserInput) {
        searchUserInput.addEventListener('input', function() {
            searchUsers(this.value);
        });
    }
});