import { Controller } from '@hotwired/stimulus';
import TomSelect from 'tom-select';
import { fillFieldUrl, displayPreviewImage } from './helper/imgHelper.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        icons: Boolean,
        previewImageId: String,
        urlFieldId: String,
    }

    connect() {
        new TomSelect(this.element, this.getConfig());
    }
    getConfig = () => {
        if (!this.hasIconsValue) return {};

        return {
            render: { option: renderItemWithIcon, item: renderItemWithIcon },
            onItemAdd : this.onItemAdd,
        };
    }
    onItemAdd = (index, item) => {
        displayPreviewImage(this.previewImageIdValue, item.children[0].src);
        fillFieldUrl(this.urlFieldIdValue, item.children[0].src);
    }
}


const renderItemWithIcon = (data) =>
    `<div>
        <img style="width: 25px" class="me-2" src="${data.icon}" alt="${data.name}" />
        ${data.name}
    </div>`;
