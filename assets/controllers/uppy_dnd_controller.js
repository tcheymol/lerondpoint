import { Controller } from '@hotwired/stimulus';
import Uppy from '@uppy/core';
import DragDrop from '@uppy/drag-drop';
import XHR from '@uppy/xhr-upload';
import French from '@uppy/locales/lib/fr_FR';

import '@uppy/core/dist/style.min.css';
import '@uppy/drag-drop/dist/style.min.css';
import {hideLoader, showLoader} from "./helper/loaderHelper.js";
import {displayPreviewImage, fillFieldUrl} from "./helper/imgHelper.js";

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {
        endpoint: String,
        targetInputId: String,
        previewElementId: String,
    };

    connect() {
        const targetInputId = !this.hasTargetInputIdValue ? null : this.targetInputIdValue;
        const previewElementId = !this.hasPreviewElementIdValue ? null : this.previewElementIdValue;

        new Uppy({
            locale: French,
            autoProceed: true,

        }).use(DragDrop, {target: '#uppyDnd',})
        .use(XHR, {
            endpoint: this.endpointValue,
            async onBeforeRequest() {
              showLoader();
            },
            async onAfterResponse(xhr) {
                hideLoader();
                if (xhr.status !== 200) {
                    alert("Erreur lors de l'upload du fichier");
                    return;
                }
                const response = JSON.parse(xhr.response);
                if (!response || !response.publicImagePath) {
                    alert("Erreur lors de l'upload du fichier");
                    return;
                }

                fillFieldUrl(targetInputId, response.publicImagePath);
                displayPreviewImage(previewElementId, response.publicImagePath);
            },
            async onError(error) {
                alert("Erreur lors de l'upload du fichier");
                console.error('Upload error:', error);
            }
        });
    }
}
