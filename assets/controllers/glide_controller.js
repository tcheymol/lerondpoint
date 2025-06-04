import { Controller } from '@hotwired/stimulus';
import Glide from '@glidejs/glide'

import '../styles/glide.code.min.css';
import '../styles/glide.theme.min.css';


/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/
export default class extends Controller {
    connect() {
        new Glide('.glide').mount()
    }
}
