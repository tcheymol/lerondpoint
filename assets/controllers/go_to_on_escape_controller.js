import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/
export default class extends Controller {
    static values = {
        path: String,
    };

    connect() {
        document.addEventListener("keydown", this.handleKeyDown)
    }

    disconnect() {
        document.removeEventListener("keydown", this.handleKeyDown)
    }

    handleKeyDown = (event) => {
        if (event.key === "Escape" || event.key === "Esc"|| event.key === "r") {
            event.stopPropagation()
            event.preventDefault()
            window.location.replace(this.pathValue);
        }
    }
}
