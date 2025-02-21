import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = [ 'input', 'preview' ];

    preview() {
        try {
            const button = document.getElementById('track_next');
            button.classList.add('disabled');
            this.previewTarget.src = '';
            const url = new URL(this.inputTarget.value);
            const urlParams = new URLSearchParams(url.search);
            const videoId = urlParams.get('v');
            if (videoId) {
                this.previewTarget.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                button.classList.remove('disabled');
            }
        } catch (e) {
            console.log(e);
        }
    }
}
