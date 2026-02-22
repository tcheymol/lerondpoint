import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const swiper = new Swiper(this.element, {
            loop: true,
            zoom: true,
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
