import { Controller } from '@hotwired/stimulus';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHR from '@uppy/xhr-upload';
import French from '@uppy/locales/lib/fr_FR';

import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';

function updateTurboFrame(attachmentId) {
    try {
        const frame = document.getElementById("attachments_previews")
        const framePathParts = frame.src.split('?ids=');
        const framePath = framePathParts[0];
        const existingIdsString = framePathParts[1] ?? '';
        const existingIds = existingIdsString ? existingIdsString.split(',') : [];
        existingIds.push(attachmentId);

        frame.src = `${framePath}?ids=${existingIds.join(',')}`;
    } catch (error) {
        console.error('Error updating Turbo frame:', error);
    }
}

function updateAttachmentsIdsInput(attachmentId) {
    const attachmentsIdsInput = document.getElementById('track_attachmentsIds');
    if (attachmentsIdsInput) {
        attachmentsIdsInput.value = !attachmentsIdsInput.value ? attachmentId : `${attachmentsIdsInput.value},${attachmentId}`;
    }
}

function disableFormButton() {
    const button = document.getElementById('track_next');
    button.classList.add('disabled');
}

function enableFormButton() {
    const button = document.getElementById('track_next');
    button.classList.remove('disabled');
}

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static values = {
        endpoint: String,
    };

    connect() {
        const uppy  = new Uppy({
            locale: French,
            allowedFileTypes: ['image/*', '.heic',  '.heif'],
        })
        .use(Dashboard, { inline: true, target: '#uppy-dashboard' })
            .use(XHR, {
                endpoint: this.endpointValue,
                async onBeforeRequest(xhr) {
                    disableFormButton();
                },
                async onAfterResponse(xhr) {
                    enableFormButton()
                    if (xhr.status !== 200) {
                        alert("Erreur lors de l'upload du fichier");
                        return;
                    }
                    const response = JSON.parse(xhr.response);
                    if (!response || !response.id) {
                        alert("Erreur lors de l'upload du fichier");
                        return;
                    }

                    const attachmentId = response.id;
                    updateAttachmentsIdsInput(attachmentId);
                    updateTurboFrame(attachmentId);
                },
                async onError(error) {
                    alert("Erreur lors de l'upload du fichier");
                    console.error('Upload error:', error);
                    enableFormButton();
                }
            });

        uppy.on('file-added', () => {
            uppy.upload();
        });
    }
}
