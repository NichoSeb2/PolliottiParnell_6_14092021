const routes = require('../../public/js/fos_js_routes.json');

import { Controller } from 'stimulus';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

export default class extends Controller {
	connect() {
		const button = $(this.element);

		button.on("click", function() {
			const button = $($(this).attr("data-bs-target") + "Button");
			const content = button.parent().parent();
			const title = content.children(".modal-header").children(".modal-title");
			const body = content.children(".modal-body");

			title.text($(this).attr("title"));
			body.html($(this).attr("body"));
			button.attr("href", $(this).attr("link"));
		});
	}
}
