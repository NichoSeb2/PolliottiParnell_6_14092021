const routes = require('../../public/js/fos_js_routes.json');

import { Controller } from 'stimulus';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

export default class extends Controller {
    connect() {
        const button = $(this.element);
        button.on("click", (e) => {
            e.preventDefault();

            console.log(Routing.generate('app_trick', { slug: "test" }));
        });
    }
}
