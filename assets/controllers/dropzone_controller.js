import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('dropzone:connect', this._onConnect);
        this.element.addEventListener('dropzone:change', this._onChange);
        this.element.addEventListener('dropzone:clear', this._onClear);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('dropzone:connect', this._onConnect);
        this.element.removeEventListener('dropzone:change', this._onChange);
        this.element.removeEventListener('dropzone:clear', this._onClear);
    }

    _onConnect(event) {
        // The dropzone was just created
    }

    _onChange(event) {
        const name = event.detail.name;
        const nameInput = document.getElementById('track_name');
        if (nameInput) {
            nameInput.value = name;
        }

        const fileType = event.detail.type;
        // The dropzone just changed
    }

    _onClear(event) {
        // The dropzone has just been cleared
    }
}