import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/
export default class extends Controller {
    connect() {
        this.handleKeyDown = this.handleKeyDown.bind(this)
        document.addEventListener("keydown", this.handleKeyDown)
    }

    disconnect() {
        document.removeEventListener("keydown", this.handleKeyDown)
    }

    handleKeyDown(event) {
        if (event.key === "Escape" || event.key === "Esc") {
            window.history.back()
        }
    }
}
