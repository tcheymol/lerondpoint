import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['container']
    static values = {
        url: String,
    }

    search = (event) => {
        console.log(event);
        const input = event.target;
        console.log(input);

        const form = input.form;
        console.log(form);
        const params = new FormData(form);
        console.log(params);

        axios({
            method: "post",
            url: this.urlValue,
            data: params,
            headers: { "Content-Type": "multipart/form-data" },
        })
        .then((response) => {
            console.log(response);
            this.containerTarget.innerHTML = response.data;
        })
        .catch(function (response) {
            console.log(response);
        });
    }
}
