import { Controller } from '@hotwired/stimulus';
import embed from 'embed-video';
import urlMetadata from 'url-metadata';
import { hideImageContainer } from './helper/captchaHelper.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = [ 'input', 'preview' ];

    async preview() {
        try {
            const button = document.getElementById('track_next');
            button.classList.add('disabled');
            this.previewTarget.src = '';
            const url = this.inputTarget.value;
            let previewUrl = null;

            embed.image(url, {image: 'mqdefault'}, async (err, thumbnail) => {
                if (err) throw err
                if (!thumbnail) {
                    alert("Nous n'avons pas pu trouver de miniature pour cette vidéo. Veuillez vérifier l'URL et réessayer.");
                    return;
                }
                previewUrl = thumbnail.src;
            })

            hideImageContainer();

            button.classList.remove('disabled');
        } catch (e) {
            console.log('error generating preview', e);
        }
    }
}
