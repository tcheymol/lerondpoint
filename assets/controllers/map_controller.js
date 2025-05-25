import { Controller } from '@hotwired/stimulus';
import { createGeocoder } from './helper/geocoder.js';
import {
    addMainMap,
    addDroms,
    fillAddressFields,
    recenterMap,
    addLayer,
    addCollectives,
    centerMapOnClickLocation, addPin,
} from './helper/mapHelpers.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {
        collectives: Array,
        geoapifyKey: String,
        addressFieldsFormName: String,
        enableClickToCenter: Boolean,
        initialPinPosition: Object,
    }
    positionPinMarker = null;

    connect() {
        this.initMap();
    }

    initMap() {
        const mainMap = addMainMap();
        const geocoder = createGeocoder(this.geoapifyKeyValue);

        const dromsMaps = addDroms();
        const allMaps = !mainMap ? dromsMaps : [mainMap, ...dromsMaps];

        allMaps.forEach((map) => {
            this.enableClickToCenter(map);
            if (geocoder) {
                this.enableCenterOnAutocomplete(map, geocoder);
                this.enableFillFieldsOnAutocomplete(geocoder);
            }
            this.addInitialPin(map);
            addLayer(map);
            addCollectives(map, this.collectivesValue);
        });

    }

    enableFillFieldsOnAutocomplete(geocoder) {
        if (this.hasAddressFieldsFormNameValue) geocoder.on('select', this.onSelectAutocompleteLocation());
    }

    addInitialPin(map) {
        if (!this.hasInitialPinPositionValue) return;
        const { lat, lon } = this.initialPinPositionValue;

        addPin(map, lat, lon);
    }

    enableCenterOnAutocomplete(map, geocoder) {
        geocoder.on('select', this.centerOnSelectAutocompleteLocation(map));
    }

    enableClickToCenter(map) {
        if (this.hasEnableClickToCenterValue && map) {
            map.on('click', (e) => {
                if (this.positionPinMarker) map.removeLayer(this.positionPinMarker);
                this.positionPinMarker = centerMapOnClickLocation(map, e.latlng, this.addressFieldsFormNameValue);
            });
        }
    }

    centerOnSelectAutocompleteLocation = (map) => (location) => {
        this.positionPinMarker = recenterMap(map, location, this.positionPinMarker, 8);
    }

    onSelectAutocompleteLocation = () => (location) => fillAddressFields(location, this.addressFieldsFormNameValue);
}
