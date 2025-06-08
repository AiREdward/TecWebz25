function setupPasswordToggle(inputId, iconId) {
    const field = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (!field || !icon) return;

    icon.addEventListener('click', function () {
        const isHidden = field.type === 'password';
        field.type = isHidden ? 'text' : 'password';

        icon.src = isHidden
            ? 'assets/img/icons/eye-slash-solid.svg'
            : 'assets/img/icons/eye-solid.svg';

        icon.alt = isHidden
            ? 'Nascondi password'
            : 'Mostra password';
    });

    icon.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            icon.click();
        }
    });
}

setupPasswordToggle('password', 'togglePassword');
setupPasswordToggle('confirm_password', 'togglePasswordConfirm');
