const confirmPasswordInput = document.getElementById('confirm_password');
const togglePassworConfirm = document.getElementById('togglePassworConfirm');

togglePassworConfirm.addEventListener('click', () => {
    const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
    confirmPasswordInput.type = type;

    // Cambia l'icona della visibilità della conferma password
    togglePassworConfirm.classList.toggle('fa-eye');
    togglePassworConfirm.classList.toggle('fa-eye-slash');
});

const passwordInput = document.getElementById('password');
const passwordMatchIcon = document.getElementById('passwordMatchIcon');

function updatePasswordMatchIcon() {
    if (confirmPasswordInput.value === '') {
        passwordMatchIcon.className = 'fa'; // Reset icon
    } else if (passwordInput.value === confirmPasswordInput.value) {
        passwordMatchIcon.className = 'fa fa-check-circle'; // Match icon
        passwordMatchIcon.style.color = 'green';
    } else {
        passwordMatchIcon.className = 'fa fa-times-circle'; // Mismatch icon
        passwordMatchIcon.style.color = 'red';
    }
}

passwordInput.addEventListener('input', updatePasswordMatchIcon);
confirmPasswordInput.addEventListener('input', updatePasswordMatchIcon);