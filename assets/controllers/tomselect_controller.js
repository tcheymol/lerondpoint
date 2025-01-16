import { Controller } from '@hotwired/stimulus';
import TomSelect from 'tom-select';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        new TomSelect(this.element,{
            render: {
                option: function (data) {
                    return `<div><img style="width: 25px" class="me-2" src="${data.icon}" alt="${data.name}" />${data.name}</div>`;
                },
                item: function (item) {
                    return `<div><img style="width: 25px" class="me-2" src="${item.icon}" alt="${item.name}" />${item.name}</div>`;
                }
            }
        });
    }
}
