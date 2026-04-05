import { Controller } from '@hotwired/stimulus';
import debounce from 'lodash/debounce';
import {updateQueryParams} from "./helper/browserHelpers.js";
import axios from "axios";
import {hideElement, showElement} from "./helper/domManipulationHelper.js";

export default class extends Controller {
    static targets = ['container', 'loader', 'form', 'loadMore', 'sortBtn']

    initialize(){
        this.search = debounce(this.search, 500).bind(this)
        this.isLoadingMore = false;
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
            this.hideLoader();
            if (data.hasNoMoreResults && this.hasLoadMoreTarget) {
                hideElement(this.loadMoreTarget);
            }

            return data.html;
        } catch (error) {
            this.hideLoader()

            return '';
        }
    }

    selectSort(event) {
        const btn = event.currentTarget;
        const select = this.formTarget.querySelector('select[name$="[sortBy]"]');
        const isDateBtn = btn.dataset.sortValue === 'date';

        if (isDateBtn) {
            const isActive = btn.classList.contains('btn-dark');
            const newValue = (!isActive || select.value === 'oldest') ? 'newest' : 'oldest';
            select.value = newValue;
            btn.querySelector('i').className = newValue === 'newest'
                ? 'fa fa-arrow-down-wide-short'
                : 'fa fa-arrow-up-wide-short';
        } else {
            select.value = btn.dataset.sortValue;
        }

        this.sortBtnTargets.forEach(b => {
            b.classList.toggle('btn-dark', b === btn);
            b.classList.toggle('btn-outline-dark', b !== btn);
        });
        this.search();
    }

    async search() {
        this.containerTarget.innerHTML = await this.postForm(this.formTarget.action);
        this.observe();
    };

    async loadMore() {
        if (this.isLoadingMore) return;
        this.isLoadingMore = true;
        const newHtml = await this.postForm(this.formTarget.action + '?loadMore=1');
        this.containerTarget.insertAdjacentHTML('beforeend', newHtml);
        this.isLoadingMore = false;
    }

    getLoaderTarget = () => this.hasLoaderTarget ? this.loaderTarget : null;

    observe() {
        if (!this.hasLoadMoreTarget) return;
        if (this.observer) this.observer.disconnect();
        this.observer = new IntersectionObserver((entries) =>
            entries.forEach(entry => {
                if (entry.isIntersecting) this.loadMore()
            })
        );
        this.observer.observe(this.loadMoreTarget);
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
