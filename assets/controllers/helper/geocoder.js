import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';

export const createGeocoder = (key) => {

    const alreadyInitializedInputs = document.getElementsByClassName('geoapify-autocomplete-input');
    if (alreadyInitializedInputs.length > 0) return;

    return new GeocoderAutocomplete(
        document.getElementById("autocomplete"),
        key,
        {debounceDelay: 300, placeholder: 'Entrez une adresse'},
    );
}
