import { Controller } from '@hotwired/stimulus';
import throttle from 'lodash/throttle';
import axios from "axios";

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

export default class extends Controller {
    static targets = ['form']
    static values = { url: String }

    initialize(){
        this.submit = throttle(this.submit, 2000);
    }

    submit() {
        const url = this.urlValue;
        const form = this.formTarget;

        if (!url || !form) return;

        try {
            axios({
                method: "post",
                url: url,
                data: new FormData(form),
                headers: { 'Content-Type': 'multipart/form-data' },
            })
                .finally(() => {})
                .catch(() => {});
        } catch (error) {}
    }
}
