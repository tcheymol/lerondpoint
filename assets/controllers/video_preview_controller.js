import { Controller } from '@hotwired/stimulus';
import embed from 'embed-video';
import { hideImageContainer } from './helper/captchaHelper.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = [ 'input', 'preview', 'previewFailureDisclaimer' ];

    async preview() {
        try {
            const button = document.getElementById('track_next');
            button.classList.add('disabled');
            this.previewFailureDisclaimerTarget.classList.add('d-none');
            const url = this.inputTarget.value;

            const preview = await embed.image(url, {image: 'mqdefault'});

            const previewSrc = (new DOMParser())
                .parseFromString(preview, 'text/html')
                .querySelector('img')
                ?.src;
            if (!previewSrc) {
                this.previewTarget.src = '/images/fallback_video.png';
                this.previewFailureDisclaimerTarget.classList.remove('d-none');
            } else {
                this.previewTarget.src = previewSrc;
            }

            hideImageContainer();

            button.classList.remove('disabled');
        } catch (e) {
            console.log('error generating preview', e);
        }
    }
}
