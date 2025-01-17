import { Controller } from '@hotwired/stimulus';
import TomSelect from 'tom-select';

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
        this.displayPreviewImage(item);
        this.fillImageUrlField(item);
    }

    displayPreviewImage(item) {
        if (!this.hasPreviewImageIdValue) return;

        try {
            const previewImageElement = document.getElementById(this.previewImageIdValue);
            previewImageElement.src = item.children[0].src;
            previewImageElement.classList.remove('d-none');
        } catch (e) {
            console.error('Failed displaying preview image', e);
        }
    }

    fillImageUrlField(item) {
        if (!this.hasUrlFieldIdValue) return;

        try {
            const urlFieldElement = document.getElementById(this.urlFieldIdValue);
            urlFieldElement.value = item.children[0].src;
        } catch (e) {
            console.error('Failed filling image url field', e);
        }

    }
}


const renderItemWithIcon = (data) =>
    `<div>
        <img style="width: 25px" class="me-2" src="${data.icon}" alt="${data.name}" />
        ${data.name}
    </div>`;
