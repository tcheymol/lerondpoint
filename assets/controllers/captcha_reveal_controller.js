import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';

export default class extends Controller {
    static targets = ['captcha', 'submit', 'trigger', 'tabs', 'title', 'url', 'attachments', 'warnModal']

    #onAttachmentsChange = () => this.validate();
    #pendingUrl = null;
    #warnModal = null;

    connect() {
        if (this.hasAttachmentsTarget) {
            this.attachmentsTarget.addEventListener('change', this.#onAttachmentsChange);
        }
        if (this.hasWarnModalTarget) {
            this.#warnModal = new Modal(this.warnModalTarget);
        }
        this.validate();
    }

    disconnect() {
        if (this.hasAttachmentsTarget) {
            this.attachmentsTarget.removeEventListener('change', this.#onAttachmentsChange);
        }
    }

    validate() {
        if (!this.hasTriggerTarget) return;
        const titleFilled = this.titleTarget.value.trim().length > 0;
        this.triggerTarget.disabled = !(titleFilled && this.#hasMedia());
    }

    warnSwitch(event) {
        if (event.currentTarget.classList.contains('active')) return;
        if (this.#hasMedia() && this.#warnModal) {
            event.preventDefault();
            this.#pendingUrl = event.currentTarget.href;
            this.#warnModal.show();
        }
    }

    confirmSwitch() {
        this.#warnModal.hide();
        window.location.href = this.#pendingUrl;
    }

    #hasMedia() {
        return (this.hasAttachmentsTarget && this.attachmentsTarget.value.trim().length > 0)
            || (this.hasUrlTarget && this.urlTarget.value.trim().length > 0);
    }

    reveal() {
        this.triggerTarget.classList.add('d-none');
        this.tabsTarget.classList.add('d-none');
        this.captchaTarget.classList.remove('d-none');
        this.submitTarget.classList.remove('d-none');
        this.captchaTarget.querySelector('input')?.focus();
    }
}
