const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function initDropZone(containerId, inputName) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const fileInput = container.querySelector('input[type="file"]');
    const preview = container.querySelector('.media-preview');
    const hiddenInput = document.querySelector(`input[name="${inputName}"]`);
    let uploaded = hiddenInput && hiddenInput.value ? JSON.parse(hiddenInput.value) : [];

    function updateHidden() {
        if (hiddenInput) hiddenInput.value = JSON.stringify(uploaded);
    }

    function createThumbnail(url) {
        const el = document.createElement('div');
        el.className = 'inline-block mr-2 mb-2';
        el.innerHTML = `<img src="${url}" class="w-24 h-16 object-cover rounded-md"/>`;
        preview.appendChild(el);
    }

    // initialize existing
    uploaded.forEach(u => createThumbnail(`/storage/${u}`));

    container.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', async (e) => {
        const files = Array.from(e.target.files);
        await uploadFiles(files);
        fileInput.value = '';
    });

    container.addEventListener('dragover', (e) => {
        e.preventDefault();
        container.classList.add('ring-2', 'ring-primary');
    });
    container.addEventListener('dragleave', (e) => {
        container.classList.remove('ring-2', 'ring-primary');
    });
    container.addEventListener('drop', async (e) => {
        e.preventDefault();
        container.classList.remove('ring-2', 'ring-primary');
        const files = Array.from(e.dataTransfer.files || []);
        await uploadFiles(files);
    });

    async function uploadFiles(files) {
        for (const file of files) {
            const form = new FormData();
            form.append('file', file);

            const res = await fetch('/cms/properties/upload-media', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf },
                body: form,
            });
            if (!res.ok) continue;
            const json = await res.json();
            // server returns {path: 'properties/xxx.jpg', url: '...'}
            uploaded.push(json.path);
            updateHidden();
            createThumbnail(json.url);
        }
    }
}

window.addEventListener('DOMContentLoaded', () => {
    initDropZone('media-dropzone', 'media');
});
