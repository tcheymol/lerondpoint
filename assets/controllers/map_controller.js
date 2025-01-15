import { Controller } from '@hotwired/stimulus';
import { createGeocoder } from "./helpers.js";
import { fillAddressFields } from "./helper/mapHelpers.js";

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = { collectives: Array }
    maps = [];
    mainMap = null;
    positionPinMarker = null;

    connect() {
        this.initMap();
        const geocoder = createGeocoder();
        geocoder.on('select', this.recenterMap);
    }

    initMap() {
        this.mainMap = L.map('map').setView([46.603354, 1.888334], 6);
        const greenIcon = L.icon({ iconUrl: '/hut.png', iconSize: [35, 35] });
        this.mainMap.on('click', (e) => {
            const location = { properties: { lat: e.latlng.lat, lon: e.latlng.lng } };
            this.recenterMap(location);
        });

        const dromLocations = [
            { id: 'mapGuadeloupe', name: "Guadeloupe", coords: [16.265, -61.551], zoom: 7 },
            { id: 'mapMartinique', name: "Martinique", coords: [14.6415, -61.0242], zoom: 7 },
            { id: 'mapGuyane', name: "Guyane", coords: [3.9339, -53.1258], zoom: 4.5 },
            { id: 'mapReunion', name: "La Réunion", coords: [-21.1151, 55.5364], zoom: 7 },
            { id: 'mapMayotte', name: "Mayotte", coords: [-12.8275, 45.1662], zoom: 8 },
            // { name: "Saint-Pierre-et-Miquelon", coords: [46.8852, -56.3159] },
            // { name: "Saint-Barthélemy", coords: [17.9, -62.8333] },
            // { name: "Saint-Martin", coords: [18.0708, -63.0501] },
            // { name: "Wallis-et-Futuna", coords: [-13.7686, -177.1561] },
            // { name: "Polynésie française", coords: [-17.6797, -149.4068] },
            // { name: "Nouvelle-Calédonie", coords: [-20.9043, 165.6180] }
        ];

        try {
            this.maps = dromLocations.map(location => L.map(location.id, {
                center: location.coords,
                zoom: location.zoom,
                zoomControl: false,
                attributionControl: false
            }));
        } catch (e) {
        }

        [this.mainMap, ...this.maps].forEach(map => {
            L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_toner/{z}/{x}/{y}{r}.png', { maxZoom: 18 }).addTo(map);
            this.collectivesValue.forEach(collective => {
                if (collective.lat && collective.lon) {
                    L.marker([collective.lat, collective.lon], {icon: greenIcon}).addTo(map);
                }
            });
        });
    }

    recenterMap = (location) =>{
        fillAddressFields(location, 'collective');

        if (this.positionPinMarker) {
            this.mainMap.removeLayer(this.positionPinMarker);
        }
        if (!location || !location.properties) {
            this.mainMap.setView([46.603354, 1.888334], 6);

            return;

        }
        const lon = location.properties.lon;
        const lat = location.properties.lat;
        const positionPin = L.icon({ iconUrl: '/pin.png', iconSize: [35, 35] });
        this.positionPinMarker = L.marker([lat, lon], {icon: positionPin}).addTo(this.mainMap);


        this.mainMap.setView([lat, lon]);
    }
}
