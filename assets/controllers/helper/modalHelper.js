import { Modal } from 'bootstrap';

export const hideAllModals = () => {
    document.querySelectorAll('.modal.show').forEach(modal => {
        modal = Modal.getInstance(modal) || new Modal(modal);
        modal.hide();
    });
}
