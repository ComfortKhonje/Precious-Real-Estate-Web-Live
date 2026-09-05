/**
 * Rich text editor for CMS content fields (announcements/news "Full
 * Content"). Added 2026-09-02 — the field was a plain <textarea> before,
 * with no formatting options at all.
 *
 * Deliberately does NOT enable Quill's built-in "image" toolbar button —
 * that embeds images as base64 data URIs directly inside the saved HTML,
 * which bypasses MediaService entirely (no WebP variants, no size limits,
 * bloats the content column). Images belong in the separate "Gallery
 * Images" upload field next to this editor, which does go through
 * MediaService properly. Text formatting only, on purpose.
 */
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import '../css/quill-brand.css';

function initEditor(container) {
    const targetName = container.dataset.quillEditor;
    const hidden = document.querySelector(`textarea[name="${targetName}"]`);
    if (!hidden) return;

    hidden.style.display = 'none';

    const editorHost = document.createElement('div');
    editorHost.className = 'bg-white rounded-2xl overflow-hidden border border-transparent focus-within:ring-2 focus-within:ring-primary focus-within:border-primary/20';
    container.appendChild(editorHost);

    const quill = new Quill(editorHost, {
        theme: 'snow',
        placeholder: hidden.placeholder || 'Write the full content...',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['blockquote', 'link'],
                ['clean'],
            ],
        },
    });

    if (hidden.value) {
        quill.clipboard.dangerouslyPasteHTML(hidden.value);
    }

    quill.on('text-change', () => {
        hidden.value = quill.root.innerHTML;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-quill-editor]').forEach(initEditor);
});
