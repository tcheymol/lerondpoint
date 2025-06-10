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

            const previewTarget = this.previewTarget;

            console.log('Generating preview for', url);

            embed.image(this.inputTarget.value, {image: 'mqdefault'}, (err, thumbnail) => {
                if (err) throw err
                console.log(thumbnail.src)
                this.previewTarget.src = thumbnail.src;
            })
            // try {
            //     const url = 'https://www.npmjs.com/package/url-metadata';
            //     const metadata = await urlMetadata(url);
            //     console.log(metadata);
            // } catch (err) {
            //     console.log(err);
            // }h

            hideImageContainer();

            button.classList.remove('disabled');
        } catch (e) {
            console.log('error generating preview', e);
        }
    }

    previewUrl(url) {
        this.previewTarget.src = url;
    }
}
