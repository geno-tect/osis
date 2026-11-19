/* Cegah form terkirim dua kali karena klik ganda.
   Form tetap berfungsi normal kalau JavaScript dimatikan. */
const forms = document.querySelectorAll('form[data-submit-once]');

forms.forEach((form) => {
    const submitButton = form.querySelector('button[type="submit"]');

    if (submitButton) {
        submitButton.dataset.label = submitButton.textContent;
    }

    form.addEventListener('submit', (event) => {
        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        const button = event.submitter || submitButton;

        if (!button) {
            return;
        }

        form.dataset.submitting = 'true';
        form.setAttribute('aria-busy', 'true');
        button.disabled = true;
        button.textContent = 'Menyimpan…';
    });
});

/* Kembalikan tombol saat halaman dipulihkan dari cache browser. */
window.addEventListener('pageshow', () => {
    document.querySelectorAll('form[data-submit-once]').forEach((form) => {
        const button = form.querySelector('button[type="submit"]');

        delete form.dataset.submitting;
        form.removeAttribute('aria-busy');

        if (button && button.dataset.label) {
            button.disabled = false;
            button.textContent = button.dataset.label;
        }
    });
});
