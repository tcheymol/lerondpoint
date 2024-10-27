import { Controller } from '@hotwired/stimulus';
import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';

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
        const autocompleteInput = new GeocoderAutocomplete(
            document.getElementById("autocomplete"),
            '089c0bbf75be49b483de4a7fa4b64007',
            { debounceDelay: 500 });

        autocompleteInput.on('select', (location) => this.fillAddressFields(location));
    }

    fillAddressFields(location) {
        const inputs = ['lat', 'lon', 'address_line1', 'address_line2', 'city', 'country', 'postcode', 'state'];
        inputs.forEach(input => {
            const inputElement = document.getElementById(`${this.formNameValue}_${input}`);
            if (inputElement) {
                inputElement.value = location.properties[input];
            }
        });
    }
}
