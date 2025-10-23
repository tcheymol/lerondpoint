import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {
         modalId: String,
    }

    click() {
        new Modal(`#${this.modalIdValue}`).show();
    };
}
