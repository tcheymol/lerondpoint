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
            button.classList.remove('disabled');
            this.previewFailureDisclaimerTarget.classList.add('d-none');
            const url = this.inputTarget.value;

            embed.image(url, {image: 'mqdefault'}, (img, result) => {
                if (!result.src) {
                    this.previewTarget.src = '/images/fallback_video.png';
                    this.previewFailureDisclaimerTarget.classList.remove('d-none');
                } else {
                    this.previewTarget.src = result.src;
                }

                hideImageContainer();
            });
        } catch (e) {
            console.log('error generating preview', e);
        }
    }
}
