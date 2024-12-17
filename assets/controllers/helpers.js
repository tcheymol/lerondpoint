import { GeocoderAutocomplete } from '@geoapify/geocoder-autocomplete';

export const placesKey = '089c0bbf75be49b483de4a7fa4b64007';

export const createGeocoder = () =>
    new GeocoderAutocomplete(
        document.getElementById("autocomplete"),
        placesKey,
        { debounceDelay: 300 },
    );
