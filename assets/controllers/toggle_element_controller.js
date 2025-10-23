import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {
        showElementId: String,
        hideElementId: String,
        hideSecondElementId: String,
    }

    show() {
        if (this.hasShowElementIdValue) {
            const showElement = document.getElementById(this.showElementIdValue);
            if (showElement) {
                showElement.classList.remove('hidden');
            }
        }
        if (this.hasHideElementIdValue) {
            const hideElement = document.getElementById(this.hideElementIdValue);
            if (hideElement) {
                hideElement.classList.add('hidden');
            }
        }if (this.hasHideSecondElementIdValue) {
            const hideSecondElement = document.getElementById(this.hideSecondElementIdValue);
            if (hideSecondElement) {
                hideSecondElement.classList.add('hidden');
            }
        }
    }
}
