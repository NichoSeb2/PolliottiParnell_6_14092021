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
			const footer = content.children(".modal-footer");

			title.text($(this).attr("title"));
			body.html($(this).attr("body"));

			footer.children("span").html("");
			if ($(this).attr("help") != undefined) {
				footer.addClass("justify-content-center");
				footer.children("span").append($(`<p class="form-text text-center m-0 mt-3 help-text"><i class="fas fa-info-circle"></i> ` + $(this).attr("help") + `</p>`));
			} else {
				footer.removeClass("justify-content-center");
			}

			button.attr("href", $(this).attr("link"));
		});
	}
}
