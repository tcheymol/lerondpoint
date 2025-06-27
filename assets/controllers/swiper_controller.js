import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/
export default class extends Controller {
    connect() {
        console.log('Swiper controller connected');
        console.log(Swiper);
        console.log('Swiper controller connected');

        const swiper = new Swiper(this.element, {
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
            },
            mousewheel: true,
            keyboard: true,
        });
        console.log('Swiper controller connected');
        console.log(swiper);
        console.log(swiper.navigation);
    }
}
