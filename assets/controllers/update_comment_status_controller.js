const routes = require('../../public/js/fos_js_routes.json');

import { Controller } from 'stimulus';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

export default class extends Controller {
	connect() {
		const container = $(this.element);

		container.on("click", () => {
			let status;

			const id = parseInt(container.attr("comment-id"));

			if (container.is(":checked")) {
				status = "on";
			} else {
				status = "off";
			}

			const link = Routing.generate("app_comment_update_status", { id, status });

			$.ajax({
                url: link, 
                type: 'GET', 
                data: {}, 
                success: (result) => {}, 
                error: (result, status, error) => {}, 
            });
		});
	}
}
