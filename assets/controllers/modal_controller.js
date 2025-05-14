import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';
import {hideAllModals} from "./helper/modalHelper.js";

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        hideAllModals();
        document.addEventListener("turbo:before-cache", () => {
            hideAllModals();
        });
    };
}
