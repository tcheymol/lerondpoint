import { Controller } from '@hotwired/stimulus';
/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */

export default class extends Controller {
    connect() {
        new Uppy.Uppy({ locale: Uppy.locales.fr_FR })
            .use(Uppy.Dashboard, {
            inline: true,
            target: '#uppy-dashboard'
        });
    }
}
