import { Controller } from '@hotwired/stimulus';
import { Tooltip } from 'bootstrap';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {text: String};

    connect() {
        return new Tooltip(this.element, {
            placement: 'bottom',
            title: this.textValue,
        });
    }
}
