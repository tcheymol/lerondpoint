import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/
export default class extends Controller {
    static targets = ['input']
    static values = {
        path: String,
    }

    submit() {
        if (!this.hasInputTarget && !this.hasPathValue) {
            return;
        }
        const queryParams = this.inputTargets
            .map(input => input.value && input.name
                ? {name: input.name, value: input.value}
                : null)
            .filter(item => item !== null);

        const url = new URL(this.pathValue, window.location.origin);
        queryParams.forEach(({ name, value }) => url.searchParams.append(name, value));

        window.location.replace(url.toString());
    }
}
