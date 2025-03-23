import { Modal } from 'bootstrap';
import {appendImg, appendText, generateDiv, updateElementHref, updateElementHtml} from './domManipulationHelper.js';

export const fillAddressFields = (location, formName) => {
    if (!formName) return;

    const inputs = ['lat', 'lon', 'address_line1', 'address_line2', 'city', 'country', 'postcode', 'state'];
    inputs.forEach(input => {
        const inputElement = document.getElementById(`${formName}_${input}`);
        if (inputElement) {
            inputElement.value = location.properties[input];
        }
    });
}

const getDromLocations = () => [
    {id: 'mapGuadeloupe', name: "Guadeloupe", coords: [16.265, -61.551], zoom: 7},
    {id: 'mapMartinique', name: "Martinique", coords: [14.6415, -61.0242], zoom: 7},
    {id: 'mapGuyane', name: "Guyane", coords: [3.9339, -53.1258], zoom: 4.5},
    {id: 'mapReunion', name: "La Réunion", coords: [-21.1151, 55.5364], zoom: 7},
    {id: 'mapMayotte', name: "Mayotte", coords: [-12.8275, 45.1662], zoom: 8},
];

const createIcon = (iconUrl) => L.icon({ iconUrl,  iconSize: [35, 35] });


const generateActionsDom = (collective) => {
    const container = generateDiv();

    collective.actions.forEach(action => {
        const item = generateDiv();
        appendImg(action, item);
        appendText(action, item);

        container.appendChild(item);
    });

    return container.innerHTML;
}

function onCollectiveClick(collective, e) {
    (new Modal(document.getElementById('collectiveDetailsModal'))).show();

    try {
        updateElementHtml('collectiveDetailsModalTitle', `${collective.id} - ${collective.name}`);
        updateElementHtml('collectiveDetailsModalActions', generateActionsDom(collective));
        updateElementHtml('collectiveDetailsModalShortDescription', collective.shortDescription);
        updateElementHtml('collectiveDetailsModalFollowUs', collective.followUs);
        updateElementHtml('collectiveDetailsModalDescription', collective.description);
        updateElementHref('collectiveDetailsModalShowUrl', collective.showUrl);
    } catch (e) {
        console.error('Failed to display collective details', e);
    }

}

export const addCollectives = (map, collectives) => collectives.forEach(collective => addCollective(map, collective));

const addCollective = (map, collective) => {
    const iconPath = collective.iconPath ?? '/hut.png';
    if (collective.lat && collective.lon) {
        L.marker([collective.lat, collective.lon], {icon: createIcon(iconPath)})
            .addTo(map)
            .on('click', (e) => onCollectiveClick(collective, e));
    }
}
export const addLayer = (map) =>
    L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_toner/{z}/{x}/{y}{r}.png', {maxZoom: 18}).addTo(map);

export const addDroms = () => {
    const maps = [];
    getDromLocations().forEach(location => {
        const mapContainer = document.getElementById(location.id);
        if (!mapContainer) return;

        const map = L.map(location.id, {
            center: location.coords,
            zoom: location.zoom,
            zoomControl: false,
            attributionControl: false
        });
        maps.push(map);
    });

    return maps
}

export const centerMapOnClickLocation = (map, latlng, addressFieldsFormName) => {
    const location = {properties: {lat: latlng.lat, lon: latlng.lng}};
    fillAddressFields(location, addressFieldsFormName);

    return recenterMap(map, location);
};

export const addMainMap = () => {
    const mapContainer = document.getElementById('map');
    if (!mapContainer) return;
    const map = L.map('map')
    resetView(map)

    return map;
}

export const recenterMap = (map, location, positionPinMarker, zoom) => {
    if (positionPinMarker) map.removeLayer(positionPinMarker);
    if (!location || !location.properties) return;

    const { lon, lat } = location.properties;
    map.setView([lat, lon], zoom);

    addPin(map, lat, lon);
}

export const addPin = (map, lat, lon) => {
    if (!map || !lat || !lon) return;
    L.marker([lat, lon], {icon: createIcon('/pin.png')}).addTo(map);
}

const resetView = (map) => map.setView([46.603354, 1.888334], 6);
