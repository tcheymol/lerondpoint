import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        this.initMap();
    }

    initMap() {
        const map = L.map('map').setView([51.505, -0.09], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([51.5, -0.09]).addTo(map);

        // map.setView([46.9, 1.4519], 5);
        // // const greenIcon = L.icon({
        // //     iconUrl: $('#map').data('marker'),
        // //     iconSize: [25, 40],
        // //     iconAnchor: [12, 38],
        // //     popupAnchor: [0, -35]
        // // });
        // const OpenStreetMap_Mapnik = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 19,
        //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">Les contributeurs d’OpenStreetMap</a>'
        // }).addTo(map);

        // $.get('/public/get-centers', (data) => {
        //     const centers = data[0];
        //     getPopupTemplate(centers);
        // });

        // const getPopupTemplate = (centers) => {
        //     $.each(centers, (key, center) => {
        //             const {lat, lng, pays, nom, ville} = center.adresse;
        //             if (lat !== null && lng !== null && pays.toLowerCase() === 'france') {
        //                 let marker = L.marker([lat, lng], {icon: greenIcon}).addTo(map);
        //                 marker.bindPopup(`<b>
        //                     <div>
        //                         <h6 class="text-primary">
        //                             ${center.nom}
        //                         </h6>
        //                         <img style="width: 12px;" src="build/images/homeV2/reconnect-centers-home.3d2de150.png" alt="">
        //                         <small>${nom} - ${ville}</small>
        //                     </div>
        //                 </b>`);
        //             }
        //         }
        //     )
        // }
    }
}
