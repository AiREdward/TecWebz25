document.addEventListener('DOMContentLoaded', function () {
    // Termini e Condizioni
    const openTermsButton = document.getElementById('open-terms');
    const closeTermsButton = document.getElementById('close-terms');
    const termsModal = document.getElementById('modal-terms');

    // Privacy e Cookie Policy
    const openPrivacyButton = document.getElementById('open-privacy');
    const closePrivacyButton = document.getElementById('close-privacy');
    const privacyModal = document.getElementById('modal-privacy');

    function openModal(modal) {
        if (modal) {
            modal.style.display = 'block';
            document.body.classList.add('modal-open');
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal(modal);
                }
            });
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal(modal);
                }
            });
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    }

    // Event listener per Termini e Condizioni
    if (openTermsButton && termsModal) {
        openTermsButton.addEventListener('click', function (event) {
            event.preventDefault();
            openModal(termsModal);
        });
    }

    if (closeTermsButton && termsModal) {
        closeTermsButton.addEventListener('click', function () {
            closeModal(termsModal);
        });
    }

    // Event listener per Privacy e Cookie Policy
    if (openPrivacyButton && privacyModal) {
        openPrivacyButton.addEventListener('click', function (event) {
            event.preventDefault();
            openModal(privacyModal);
        });
    }

    if (closePrivacyButton && privacyModal) {
        closePrivacyButton.addEventListener('click', function () {
            closeModal(privacyModal);
        });
    }
});