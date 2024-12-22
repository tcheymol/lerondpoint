import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
function toggleHeader(scrollDirection) {
    Array.prototype.forEach.call(document.getElementsByClassName('navbar'),
        function(element) {
            if ('down' === scrollDirection && 50 < document.documentElement.scrollTop) {
                element.style.display = 'none';
                document.getElementById('scrollDownButton').style.display = 'none';
            } else if ('up' === scrollDirection && 50 > document.documentElement.scrollTop) {
                element.style.display = 'flex';
                document.getElementById('scrollDownButton').style.display = 'block';
            }
        }
    );
}

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    lastScrollPosition = 0;

    connect() {
            window.addEventListener("scroll", () => this.show());
        }

        show = () => {
            const currentScrollPosition = document.documentElement.scrollTop;
            const scrollDirection = currentScrollPosition >= this.lastScrollPosition ? 'down' : 'up';
            this.lastScrollPosition = currentScrollPosition;
            toggleHeader(scrollDirection);

            if ('down' === scrollDirection && 0 === this.lastScrollPosition) {
                window.scrollTo({
                    top: window.innerHeight,
                    behavior: 'smooth'
                });
            }
        }
}
