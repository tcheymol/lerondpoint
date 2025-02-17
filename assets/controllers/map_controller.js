import { Controller } from '@hotwired/stimulus';
import { createGeocoder } from "./helpers.js";
import {
    addMainMap,
    addDroms,
    fillAddressFields,
    recenterMap,
    addLayers,
    addGroups,
    centerMapOnClickLocation,
} from './helper/mapHelpers.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {
        collectives: Array,
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
        const geocoder = createGeocoder();

        const allMaps = this.addDroms(mainMap);
        this.enableClickToCenter(mainMap);
        this.enableFillFieldsOnAutocomplete(mainMap, geocoder);

        addLayers(allMaps);
        addGroups(allMaps, this.collectivesValue);
    }

    enableFillFieldsOnAutocomplete(mainMap, geocoder) {
        if (this.hasAddressFieldsFormNameValue) {
            geocoder.on('select', this.onSelectAutocompleteLocation(mainMap));
        }
    }

    enableClickToCenter(mainMap) {
        if (this.hasEnableClickToCenterValue) {
            mainMap.on('click', (e) => {
                if (this.positionPinMarker) mainMap.removeLayer(this.positionPinMarker);
                this.positionPinMarker = centerMapOnClickLocation(mainMap, e.latlng, this.addressFieldsFormNameValue);
            });
        }
    }

    onSelectAutocompleteLocation = (map) => (location) =>{
        fillAddressFields(location, this.addressFieldsFormNameValue);
        this.positionPinMarker = recenterMap(map, location, this.positionPinMarker);
    }

    addDroms = (mainMap) => !this.enableDromsValue ? [mainMap] : [mainMap, ...addDroms()];
}
