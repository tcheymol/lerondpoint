import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
function toggleHeader(scrollDirection) {
    if ('down' === scrollDirection && 50 < document.documentElement.scrollTop) {
        hideHeader();
    } else if ('up' === scrollDirection && 50 > document.documentElement.scrollTop) {
        showHeader();
    }
}

function showHeader() {
    Array.prototype.forEach.call(document.getElementsByClassName('navbar'),
        function(element) {
            element.style.display = 'flex';
            document.getElementById('scrollDownButton').style.display = 'block';
        }
    );
}

function hideHeader() {
    Array.prototype.forEach.call(document.getElementsByClassName('navbar'),
        function(element) {
            element.style.display = 'none';
            document.getElementById('scrollDownButton').style.display = 'none';
        }
    );
}

export default class extends Controller {
    lastScrollPosition = 0;

    connect() {
            window.addEventListener("scroll", () => this.scroll());
        }

    scroll = () => {
        const currentScrollPosition = document.documentElement.scrollTop;
        const scrollDirection = currentScrollPosition >= this.lastScrollPosition ? 'down' : 'up';
        this.lastScrollPosition = currentScrollPosition;
        toggleHeader(scrollDirection);

        console.log('scroooolllllll', scrollDirection, currentScrollPosition, this.lastScrollPosition);
        const isMobile = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        if ('down' === scrollDirection && 0 < currentScrollPosition) {
            window.scrollTo({ top: window.innerHeight, behavior: 'smooth' });
        }
    }

    show = () => {
        hideHeader();
        document.querySelector('#scrollableHome').scrollIntoView({ behavior: 'smooth' });
        // window.scrollTo({ top: window.innerHeight, behavior: 'smooth' });
    }
}
