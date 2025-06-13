import { Controller } from '@hotwired/stimulus';
import Glide from '@glidejs/glide';

import '../styles/glide.core.min.css'
import '../styles/glide.theme.css'

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {


    connect() {
        var glide = new Glide(this.element, {
            type: 'slider',
            perView: 1,
            focusAt: 'center',
        })

        glide.mount()
    }
}
