import { Modal } from 'bootstrap';

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

function onCollectiveClick(collective, e) {
    const modalElement = document.getElementById('collectiveDetailsModal');
    (new Modal(modalElement)).show();

    try {
        const modalTitle = modalElement.getElementsByClassName('modal-title')[0];
        modalTitle.textContent = collective.id + ' - ' + collective.name;
        const modalBody = modalElement.getElementsByClassName('modal-body')[0];
        modalBody.innerHTML = '';

        collective.actions.forEach(action => {
            const item = document.createElement('div');
            item.style.textAlign = 'center';

            const img = document.createElement('img');
            img.src = action.iconPath;
            img.alt = action.name;
            img.style.width = '100px';

            const text = document.createElement('div');
            text.textContent = action.name;

            item.appendChild(img);
            item.appendChild(text);

            modalBody.appendChild(item);
        });

    } catch (e) {
        console.error('Failed to display collective details', e);
    }

}

export const addCollectiveToMap = (map, collective) => {
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
    try {
        return getDromLocations().map(location => L.map(location.id, {
            center: location.coords,
            zoom: location.zoom,
            zoomControl: false,
            attributionControl: false
        }));
    } catch (e) {
        console.error('Failed adding map for drom', e);

        return [];
    }
}

export const centerMapOnClickLocation = (map, latlng, addressFieldsFormName) => {
    const location = {properties: {lat: latlng.lat, lon: latlng.lng}};
    fillAddressFields(location, addressFieldsFormName);

    return recenterMap(map, location);
};

export const addMainMap = () => {
    const map = L.map('map')
    resetView(map)

    return map;
}

export const recenterMap = (map, location, positionPinMarker) => {
    if (positionPinMarker) map.removeLayer(positionPinMarker);
    if (!location || !location.properties) return;

    const { lon, lat } = location.properties;
    map.setView([lat, lon]);

    return L.marker([lat, lon], {icon: createIcon('/pin.png')}).addTo(map);
}

const resetView = (map) => map.setView([46.603354, 1.888334], 6);

export const addLayers = (maps) => maps.forEach(map => addLayer(map));

export const addCollectives = (maps, collectives) => maps.forEach(map => {
    collectives.forEach(collective => addCollectiveToMap(map, collective))
});
