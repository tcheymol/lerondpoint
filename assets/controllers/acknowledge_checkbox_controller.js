import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = ['button']

    check(e) {
        const button = this.buttonTarget;

        if (button) {
            button.disabled = !e.target.checked;
            button.classList.toggle('disabled',  !e.target.checked);
        }
    }
}
