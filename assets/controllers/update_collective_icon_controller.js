import { Controller } from '@hotwired/stimulus';
import {displayPreviewImage, fillFieldUrl} from './helper/imgHelper.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        iconPath: String,
        fieldElementId: String,
        imagePreviewElementId: String,
    };

    updateIcon() {
        fillFieldUrl(this.fieldElementIdValue, this.iconPathValue);
        displayPreviewImage(this.imagePreviewElementIdValue, this.iconPathValue);
    }
}
