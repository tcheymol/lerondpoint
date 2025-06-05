import { Controller } from '@hotwired/stimulus';
import PhotoSwipeLightbox from '../scripts/photoswipe/photoswipe-lightbox.esm.min.js'

import 'photoswipe/dist/photoswipe.min.css';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

export default class extends Controller {
    connect() {
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#trackPhotoswipe',
            children: 'a',
            pswpModule: () => import('photoswipe'),
        });
        lightbox.init();
    }
}
