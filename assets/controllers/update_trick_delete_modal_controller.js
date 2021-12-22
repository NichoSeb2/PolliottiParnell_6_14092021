const routes = require('../../public/js/fos_js_routes.json');

import { Controller } from 'stimulus';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

export default class extends Controller {
	connect() {
		const button = $(this.element);

		button.on("click", function() {
			const button = $($(this).attr("data-bs-target") + "Button");

			const link = Routing.generate("app_trick_delete", { slug: $(this).attr("slug") });

			button.attr("href", link);
		});
	}
}
