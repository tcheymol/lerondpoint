import { Controller } from '@hotwired/stimulus';
import debounce from 'lodash/debounce';
import {updateQueryParams} from "./helper/browserHelpers.js";
import axios from "axios";
import {hideElement, showElement} from "./helper/domManipulationHelper.js";
import {hideLoader, showLoader} from "./helper/loaderHelper.js";

export default class extends Controller {
    static targets = ['container', 'loader', 'form', 'loadMore']

    initialize(){
        this.search = debounce(this.search, 500).bind(this)
        this.observe();
    }

    async postForm(action) {
        const form = this.formTarget;
        try{
            this.showLoader();
            const response = await axios({
                method: 'POST',
                url: action,
                data: new FormData(form),
                headers: {
                    "Content-Type": "multipart/form-data",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            const data = response.data;
            updateQueryParams(data.queryParams);
            if (data.hasNoMoreResults) this.hideLoader();

            return data.html;
        } catch (error) {
            hideLoader()

            return '';
        }
    }

    async search() {
        this.containerTarget.innerHTML = await this.postForm(this.formTarget.action);
    };

    async loadMore() {
        setTimeout(async() => {
            const newHtml = await this.postForm(this.formTarget.action + '?loadMore=1');
            this.containerTarget.innerHTML = this.containerTarget.innerHTML + newHtml;
        }, 500);
    }

    getLoaderTarget = () => this.hasLoaderTarget ? this.loaderTarget : null;

    observe() {
        if (!this.hasLoadMoreTarget) return;
        const observer = new IntersectionObserver((entries) =>
            entries.forEach(entry => {
                if (entry.isIntersecting) this.loadMore()
            })
        );
        observer.observe(this.loadMoreTarget);
    }

    showLoader() {
        const loader = this.getLoaderTarget();
        showElement(loader);
    }

    hideLoader() {
        const loader = this.getLoaderTarget();
        hideElement(loader);
    }
}
