import { Controller } from '@hotwired/stimulus';
import Macy from "macy";

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/
export default class extends Controller {
    connect() {
        Macy({
            container: this.element,
            columns: 2,
            margin: 16,
            breakAt: {
                768: 2,
                480: 1
            }
        })
    }
}
