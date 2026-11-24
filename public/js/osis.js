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
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-foto-dropzone]').forEach((dropzone) => {
        const input = dropzone.querySelector('[data-foto-input]');
        const preview = dropzone.querySelector('[data-foto-preview]');
        if (!input || !preview) return;

        const showFile = (file) => {
            if (!file || !file.type.startsWith('image/')) return;
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
            const copy = dropzone.querySelector('.foto-upload-copy');
            if (copy) copy.innerHTML = '<strong>Foto siap diunggah</strong><br><small>' + file.name.replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])) + '</small>';
            const hapusFoto = document.getElementById('hapus_foto');
            if (hapusFoto) hapusFoto.value = '0';
            const fotoLama = document.getElementById('foto-preview-box');
            if (fotoLama) fotoLama.style.display = 'none';
        };

        input.addEventListener('change', () => showFile(input.files[0]));
        ['dragenter', 'dragover'].forEach((eventName) => dropzone.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropzone.classList.add('is-dragging');
        }));
        ['dragleave', 'drop'].forEach((eventName) => dropzone.addEventListener(eventName, (event) => {
            event.preventDefault();
            dropzone.classList.remove('is-dragging');
        }));
        dropzone.addEventListener('drop', (event) => {
            const file = event.dataTransfer.files[0];
            if (!file) return;
            const transfer = new DataTransfer();
            transfer.items.add(file);
            input.files = transfer.files;
            showFile(file);
        });
    });
});
