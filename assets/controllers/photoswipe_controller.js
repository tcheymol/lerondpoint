import { Controller } from '@hotwired/stimulus';
import PhotoSwipeLightbox from '../scripts/photoswipe/photoswipe-lightbox.esm.min.js'

import 'photoswipe/dist/photoswipe.min.css';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

export default class extends Controller {
    connect() {
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#trackPhotoswipe',
            children: 'a',
            pswpModule: () => import('photoswipe'),
        });
        lightbox.on('uiRegister', function() {
            lightbox.pswp.ui.registerElement({
                name: 'bulletsIndicator',
                className: 'pswp__bullets-indicator',
                appendTo: 'wrapper',
                onInit: (el, pswp) => {
                    const bullets = [];
                    let bullet;
                    let prevIndex = -1;

                    for (let i = 0; i < pswp.getNumItems(); i++) {
                        bullet = document.createElement('div');
                        bullet.className = 'pswp__bullet';
                        bullet.onclick = (e) => {
                            pswp.goTo(bullets.indexOf(e.target));
                        };
                        el.appendChild(bullet);
                        bullets.push(bullet);
                    }

                    pswp.on('change', (a,) => {
                        if (prevIndex >= 0) {
                            bullets[prevIndex].classList.remove('pswp__bullet--active');
                        }
                        bullets[pswp.currIndex].classList.add('pswp__bullet--active');
                        prevIndex = pswp.currIndex;
                    });


                }
            });

            lightbox.pswp.ui.registerElement({
                name: 'download-button',
                order: 8,
                isButton: true,
                tagName: 'a',

                // SVG with outline
                html: {
                    isCustomSVG: true,
                    inner: '<path d="M20.5 14.3 17.1 18V10h-2.2v7.9l-3.4-3.6L10 16l6 6.1 6-6.1ZM23 23H9v2h14Z" id="pswp__icn-download"/>',
                    outlineID: 'pswp__icn-download'
                },

                // Or provide full svg:
                // html: '<svg width="32" height="32" viewBox="0 0 32 32" aria-hidden="true" class="pswp__icn"><path d="M20.5 14.3 17.1 18V10h-2.2v7.9l-3.4-3.6L10 16l6 6.1 6-6.1ZM23 23H9v2h14Z" /></svg>',

                // Or provide any other markup:
                // html: '<i class="fa-solid fa-download"></i>'

                onInit: (el, pswp) => {
                    el.setAttribute('download', '');
                    el.setAttribute('target', '_blank');
                    el.setAttribute('rel', 'noopener');

                    pswp.on('change', () => {
                        console.log('change');
                        el.href = pswp.currSlide.data.src;
                    });
                }
            });

            lightbox.pswp.ui.registerElement({
                name: 'zoom-level-indicator',
                order: 9,
                onInit: (el, pswp) => {
                    pswp.on('zoomPanUpdate', (e) => {
                        if (e.slide === pswp.currSlide) {
                            el.innerText = 'Zoom : ' + Math.round(pswp.currSlide.currZoomLevel * 100) + '%';
                        }
                    });
                }
            });
        });
        lightbox.init();
    }
}
