import { Controller } from '@hotwired/stimulus';
import { createGeocoder } from './helper/geocoder.js';
import {
    addMainMap,
    addDroms,
    fillAddressFields,
    recenterMap,
    addLayers,
    addCollectives,
    centerMapOnClickLocation,
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
        enableDroms: Boolean,
        enableClickToCenter: Boolean,
    }
    positionPinMarker = null;

    connect() {
        this.initMap();
    }

    initMap() {
        const mainMap = addMainMap();
        const geocoder = createGeocoder(this.geoapifyKeyValue);

        const allMaps = this.addDroms(mainMap);
        this.enableClickToCenter(mainMap);
        this.enableCenterOnAutocomplete(mainMap, geocoder);
        this.enableFillFieldsOnAutocomplete(mainMap, geocoder);

        addLayers(allMaps);
        addCollectives(allMaps, this.collectivesValue);
    }

    enableFillFieldsOnAutocomplete(mainMap, geocoder) {
        if (this.hasAddressFieldsFormNameValue) {
            geocoder.on('select', this.onSelectAutocompleteLocation(mainMap));
        }
    }

    enableCenterOnAutocomplete(mainMap, geocoder) {
        geocoder.on('select', this.centerOnSelectAutocompleteLocation(mainMap));
    }

    enableClickToCenter(mainMap) {
        if (this.hasEnableClickToCenterValue) {
            mainMap.on('click', (e) => {
                if (this.positionPinMarker) mainMap.removeLayer(this.positionPinMarker);
                this.positionPinMarker = centerMapOnClickLocation(mainMap, e.latlng, this.addressFieldsFormNameValue);
            });
        }
    }

    centerOnSelectAutocompleteLocation = (map) => (location) =>{
        this.positionPinMarker = recenterMap(map, location, this.positionPinMarker, 8);
    }

    onSelectAutocompleteLocation = (map) => (location) =>{
        fillAddressFields(location, this.addressFieldsFormNameValue);
    }

    addDroms = (mainMap) => !this.enableDromsValue ? [mainMap] : [mainMap, ...addDroms()];
}
