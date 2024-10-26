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
            'be7f0a8308a34e3e96e388a83e674477',
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
