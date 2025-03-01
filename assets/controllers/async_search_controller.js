import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import debounce from 'lodash/debounce';
import { showElement, hideElement } from './helper/domManipulationHelper.js';
import { updateQueryParams } from './helper/browserHelpers.js';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
export default class extends Controller {
    static targets = ['container', 'loader']
    static values = {
        url: String,
    }

    initialize(){
        this.search = debounce(this.search, 500).bind(this)
    }

    search(event) {
        try {
            const input = event.target;
            const form = input.form;
            const params = new FormData(form);
            this.showLoader();

            axios({
                method: "post",
                url: this.urlValue,
                data: params,
                headers: {"Content-Type": "multipart/form-data"},
            })
                .then((response) => {
                    this.containerTarget.innerHTML = response.data.html;
                    updateQueryParams(response.data.queryParams);
                    this.hideLoader()
                })
                .catch(() => {
                    this.hideLoader()
                });
        } catch (error) {
            this.hideLoader()
        }
    };

    hideLoader() {
        hideElement(this.getLoaderTarget());
    }

    showLoader() {
        showElement(this.getLoaderTarget());
    }

    getLoaderTarget() {
        return this.hasLoaderTarget ? this.loaderTarget : null;
    }
}
