import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['yesContent', 'yesConfirm']

    toggle(event) {
        const isChecked = event.target.value !== '0'

        this.yesContentTarget.classList.toggle('hidden', !isChecked);

        console.log(this.yesConfirmTarget.checked, this.yesConfirmTarget.value);

        if (this.hasYesConfirmTarget) {
            this.yesConfirmTarget.value = !isChecked
            this.yesConfirmTarget.checked = !isChecked
        }
    }
}
