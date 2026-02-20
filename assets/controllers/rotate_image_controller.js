import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import {hideLoader, showLoader} from "./helper/loaderHelper.js";

export default class extends Controller {
    static targets = ['image']
    static values = {
        url: String,
    }

    rotate(event) {
        showLoader();
        setTimeout(hideLoader, 5000);
        event.preventDefault();
        event.stopPropagation();

        if (!this.hasUrlValue) return;

        axios
            .get(this.urlValue)
            .then((response) => {
                if (response.status !== 200 || response.data.success !== true) {
                    throw new Error();
                }

                this.rotation = (this.rotation + 90) % 360;
                this.imageTarget.style.transform = `rotate(${this.rotation}deg)`;
            })
            .catch(() => {
                alert("Oops, il y a eu une petite erreur lors de la rotation de l'image");
            })
            .finally(() => hideLoader());
    }

    connect() {
        this.rotation = 0;
    }
}
