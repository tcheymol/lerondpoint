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

export const addCollectiveToMap = (map, collective) => {
    if (collective.lat && collective.lon) {
        L.marker([collective.lat, collective.lon], {icon: createIcon('/hut.png')}).addTo(map)
            .on('click', (e) => {
                console.log('clicked on collective', collective, e);
            })
        ;
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

export const centerMapOnClickLocation = (map, latlng) => {
    const location = {properties: {lat: latlng.lat, lon: latlng.lng}};

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
