import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = { endpoint: String };
    static targets = ['input', 'preview', 'field', 'wrapper', 'icon'];

    async upload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);

        const response = await fetch(this.endpointValue, { method: 'POST', body: formData });
        if (!response.ok) return;

        const data = await response.json();
        if (!data.publicImagePath) return;

        this.fieldTarget.value = data.publicImagePath;
        this.previewTarget.src = data.publicImagePath;
        this.wrapperTarget.classList.remove('d-none');
        if (this.hasIconTarget) this.iconTarget.classList.add('d-none');
    }
}
