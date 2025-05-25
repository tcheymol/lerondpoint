import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';

const geocoderConfig = {debounceDelay: 300, placeholder: 'Entrez une adresse'};

export const createGeocoder = (key) => {

    const alreadyInitializedInputs = document.getElementsByClassName('geoapify-autocomplete-input');
    if (alreadyInitializedInputs && alreadyInitializedInputs.length > 0) return;

    const autocompleteContainer = document.getElementById("autocomplete");
    if (!autocompleteContainer) return;

    return new GeocoderAutocomplete(autocompleteContainer, key, geocoderConfig);
}
