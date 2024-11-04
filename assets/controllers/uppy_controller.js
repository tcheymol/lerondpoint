import { Controller } from '@hotwired/stimulus';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHR from '@uppy/xhr-upload';
import French from '@uppy/locales/lib/fr_FR';

import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */

export default class extends Controller {
    static values = {
        endpoint: String,
    };

    connect() {
        const uppy  = new Uppy({ locale: French })
        .use(Dashboard, {
                inline: true,
                target: '#uppy-dashboard',
            })
            .use(XHR, {
                endpoint: this.endpointValue,
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
            const name = file.name;
            const nameInput = document.getElementById('track_name');
            if (nameInput && !nameInput.value) {
                nameInput.value = name;
            }

            uppy.upload();
        });
    }
}
