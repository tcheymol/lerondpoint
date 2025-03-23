import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';

export const createGeocoder = (key) =>
    new GeocoderAutocomplete(
        document.getElementById("autocomplete"),
        key,
        { debounceDelay: 300, placeholder: 'Entrez une adresse' },
    );
