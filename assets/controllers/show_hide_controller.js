import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        document.body.style.marginTop = '100vh';
        window.addEventListener("scroll", () => {
            this.show();
        });
        // setTimeout(this.show, 4000)
    }

    show = () => {
        Array.prototype.forEach.call(document.getElementsByClassName('show-on-show-hide'),
            function(element) {
                element.style.top = '0';
            }
        );
        document.body.style.marginTop = '0';
        this.element.remove();
    }
}
