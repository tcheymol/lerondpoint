import { Controller } from '@hotwired/stimulus';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHR from '@uppy/xhr-upload';
import French from '@uppy/locales/lib/fr_FR';

import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */

export default class extends Controller {
    static values = {
        endpoint: String,
    };

    connect() {
        new Uppy({ locale: French })
            .use(Dashboard, {
            inline: true,
            target: '#uppy-dashboard'
            })
            .use(XHR, { endpoint: this.endpointValue })
        ;
    }
}
