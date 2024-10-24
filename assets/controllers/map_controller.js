import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        collectives: Array
    }

    connect() {
        this.initMap();
    }

    initMap() {
        const map = L.map('map').setView([46.603354, 1.888334], 6);
        L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_toner/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
        }).addTo(map);

        var reunionMap = L.map('reunionMap', {
            center: [-21.13, 55.53],
            zoom: 7,
            dragging: false,
            zoomControl: false,
            attributionControl: false
        });
        L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_toner/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
        }).addTo(reunionMap);

        const greenIcon = L.icon({
            iconUrl: 'hut.png',
            iconSize: [35, 35],
        });

        this.collectivesValue.forEach(collective => {
            if (collective.lat && collective.lon) {
                L.marker([collective.lat, collective.lon], {icon: greenIcon}).addTo(map);
            }
        });
    }
}
