const routes = require('../../public/js/fos_js_routes.json');

import { Controller } from 'stimulus';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

export default class extends Controller {
    connect() {
        const container = $(this.element);

        const target = $(container.attr("data-bs-target") + " .modal-dialog .modal-content .modal-body");
        const targetTitle = $(container.attr("data-bs-target") + " .modal-dialog .modal-content .modal-title");
        const origin = container.children(".modal-container");

        container.on("click", () => {
            targetTitle.text(origin.attr("title"));
            target.html(origin.html());
        });
    }
}
