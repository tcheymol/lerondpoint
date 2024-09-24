import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        console.log('Hello Stimulus! (places_controller.js)');
        opencage.algoliaAutocomplete({
            container: '#place',
            plugins: [
                opencage.OpenCageGeoSearchPlugin(
                    {
                        key: 'd406c8f6956244e1891843cf3c653bd9',
                    },
                    // optional event handlers:
                    {
                        onSelect: function handleSelect(params) {
                            console.log('Selected Item is', params.item);
                            const latlng = [params.item.geometry.lat, params.item.geometry.lng];
                            // do something with the coords
                            console.log('Selected result coords', latlng);
                        },
                        onSubmit: function handleSubmit(params) {
                            // Do something with the selected and then submitted value
                            console.log('Submit with', params.state.query);
                        },
                    }
                ),
            ],
        });
    }
}
