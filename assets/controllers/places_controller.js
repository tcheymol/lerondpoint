import { Controller } from '@hotwired/stimulus';
import { createGeocoder } from './helpers.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        formName: String
    }

    connect() {
        this.setupAutocomplete();
    }

    setupAutocomplete() {
        const autocompleteInput = createGeocoder();

        autocompleteInput.on('select', (location) => this.fillAddressFields(location));
    }

    fillAddressFields(location) {
        if (!this.hasformNameValue) {
            return;
        }
        const inputs = ['lat', 'lon', 'address_line1', 'address_line2', 'city', 'country', 'postcode', 'state'];
        inputs.forEach(input => {
            const inputElement = document.getElementById(`${this.formNameValue}_${input}`);
            if (inputElement) {
                inputElement.value = location.properties[input];
            }
        });
    }
}
