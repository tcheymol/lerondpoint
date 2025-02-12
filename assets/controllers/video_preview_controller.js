import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = [ 'input', 'preview', 'button' ];

    preview() {
        try {
            this.previewTarget.src = '';
            this.buttonTarget.disabled = true;
            const url = new URL(this.inputTarget.value);
            const urlParams = new URLSearchParams(url.search);
            const videoId = urlParams.get('v');
            if (videoId) {
                this.previewTarget.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                this.buttonTarget.disabled = '';
            }
        } catch (e) {
            console.log(e);
        }
    }
}
