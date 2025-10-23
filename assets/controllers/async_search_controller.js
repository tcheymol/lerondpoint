import { Controller } from '@hotwired/stimulus';
import debounce from 'lodash/debounce';
import {updateQueryParams} from "./helper/browserHelpers.js";
import axios from "axios";
import {hideElement, showElement} from "./helper/domManipulationHelper.js";

export default class extends Controller {
    static targets = ['container', 'loader', 'form', 'loadMore']

    initialize(){
        this.search = debounce(this.search, 500).bind(this)
    }

    async postForm(action) {
        const form = this.formTarget;
        const loader = this.getLoaderTarget();
        try{
            showElement(loader);
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
            console.log()
            this.hideLoadMore(data.hasNoMoreResults);

            hideElement(loader)
            return data.html;
        } catch (error) {
            hideElement(loader)

            return '';
        }
    }

    async search() {
        this.containerTarget.innerHTML = await this.postForm(this.formTarget.action);
    };

    async loadMore() {
        const newHtml = await this.postForm(this.formTarget.action + '?loadMore=1');
        this.containerTarget.innerHTML = this.containerTarget.innerHTML + newHtml;
    }

    getLoaderTarget = () => this.hasLoaderTarget ? this.loaderTarget : null;

    hideLoadMore = (hide) => {
        if (!hide) return;

        if (this.hasLoadMoreTarget) {
            hideElement(this.loadMoreTarget);
        }
    };
}
