<script>
function serviceIconPicker(icons, initialSelectedId) {
    return {
        icons: icons,
        selectedId: initialSelectedId,
        previewColor: 'yellow',
        modalOpen: false,
        newName: '',
        newBlack: null,
        newYellow: null,
        uploading: false,
        uploadError: '',

        async uploadIcon() {
            this.uploadError = '';

            if (!this.newName || !this.newBlack || !this.newYellow) {
                this.uploadError = 'Name, black SVG and yellow SVG are all required.';
                return;
            }

            this.uploading = true;

            const formData = new FormData();
            formData.append('name', this.newName);
            formData.append('black_icon', this.newBlack);
            formData.append('yellow_icon', this.newYellow);

            try {
                const res = await fetch('{{ route('cms.service-icons.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (!res.ok) {
                    const body = await res.json().catch(() => null);
                    throw new Error(body?.errors ? Object.values(body.errors).flat().join(' ') : 'Upload failed.');
                }

                const icon = await res.json();
                this.icons.push(icon);
                this.selectedId = icon.id;
                this.modalOpen = false;
                this.newName = '';
                this.newBlack = null;
                this.newYellow = null;
            } catch (e) {
                this.uploadError = e.message || 'Upload failed.';
            } finally {
                this.uploading = false;
            }
        },
    };
}
</script>
