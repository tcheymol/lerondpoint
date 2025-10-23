import { Controller } from '@hotwired/stimulus';
import debounce from 'lodash/debounce';
import {postForm} from "./helper/postForm.js";

export default class extends Controller {
    static targets = ['container', 'loader', 'form']

    initialize(){
        this.search = debounce(this.search, 500).bind(this)
    }

    async search() {
        this.containerTarget.innerHTML = await postForm(this.formTarget, this.getLoaderTarget());
    };

    async loadMore() {
        const newHtml = await postForm(this.formTarget, this.getLoaderTarget(), this.formTarget.action + '?loadMore=1');
        this.containerTarget.innerHTML = this.containerTarget.innerHTML + newHtml;
    }

    getLoaderTarget = () => this.hasLoaderTarget ? this.loaderTarget : null;
}
