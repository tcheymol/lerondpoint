import { Controller } from '@hotwired/stimulus';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHR from '@uppy/xhr-upload';
import French from '@uppy/locales/lib/fr_FR';

import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';
import { hideVideoContainer } from './helper/captchaHelper.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = [ 'button' ];

    static values = {
        endpoint: String,
    };

    connect() {
        const uppy  = new Uppy({ locale: French })
        .use(Dashboard, { inline: true, target: '#uppy-dashboard' })
            .use(XHR, {
                endpoint: this.endpointValue,
                async onBeforeRequest() { hideVideoContainer() },
                async onAfterResponse(xhr) {
                    if (xhr.status !== 200) {
                        return;
                    }
                    const response = JSON.parse(xhr.response);
                    if (!response || !response.id) {
                        return;
                    }
                    const attachmentId = response.id;
                    const attachmentsIdsInput = document.getElementById('track_attachmentsIds');
                    if (attachmentsIdsInput) {
                        attachmentsIdsInput.value = !attachmentsIdsInput.value ? attachmentId : `${attachmentsIdsInput.value},${attachmentId}`;
                    }
                },
            });

        uppy.on('file-added', (file) => {
            const button = document.getElementById('track_next');
            button.classList.remove('disabled');

            uppy.upload();
        });
    }
}
