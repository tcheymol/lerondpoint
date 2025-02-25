import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

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

            this.handleYoutube(url);
            this.handleVimeo(url);

            button.classList.remove('disabled');
        } catch (e) {
            console.log(e);
        }
    }

    handleVimeo(url) {
        if (!url.hostname.includes('vimeo.com')) {
            return;
        }

        try {
            const apiUrl = 'https://vimeo.com/api/oembed.json?url=' + encodeURI(url);
            axios.get(apiUrl).then(response => {
                const data = response.data;
                if (data.thumbnail_url) {
                    this.previewTarget.src = data.thumbnail_url;
                }
            });
        } catch (e) {
            return null;
        }
    }

    handleYoutube(url) {
        if (!url.hostname.includes('youtube.com')) {
            return;
        }

        const urlParams = new URLSearchParams(url.search);
        const videoId = urlParams.get('v');
        if (videoId) {
            this.previewTarget.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
        }
    }
}
