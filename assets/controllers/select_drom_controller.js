import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

export default class extends Controller {
    static values = {
        url: String,
    }

    update(event) {
        const selectedDrom = event.target.value;
        if (!selectedDrom || !this.hasUrlValue) {
            return;
        }

        window.location.replace(`${this.urlValue}/${selectedDrom}`);
    }
}
