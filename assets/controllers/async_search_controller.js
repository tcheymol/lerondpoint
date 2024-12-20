import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import debounce from 'lodash/debounce';

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

    initialize(){
        this.search = debounce(this.search, 1000).bind(this)
    }

    search(event) {
        try {
            const input = event.target;
            const form = input.form;
            const params = new FormData(form);

            axios({
                method: "post",
                url: this.urlValue,
                data: params,
                headers: {"Content-Type": "multipart/form-data"},
            })
                .then((response) => {
                    this.containerTarget.innerHTML = response.data;
                })
                .catch(function (response) {
                    console.log(response);
                });
        } catch (error) {
            console.log(error);
        }
    };
}
