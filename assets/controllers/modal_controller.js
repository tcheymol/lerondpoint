import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        document.querySelectorAll('.modal.show').forEach(modal => {
            modal = Modal.getInstance(modal) || new Modal(modal);
            modal.hide();
        });
        document.addEventListener("turbo:before-cache", () => {
            document.querySelectorAll('.modal.show').forEach(modal => {
                const instance = Modal.getInstance(modal)
                if (instance) {
                    instance.hide()
                }
            })
        })
    };
}
