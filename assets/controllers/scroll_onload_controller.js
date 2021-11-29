import { Controller } from "stimulus";

export default class extends Controller {
	connect() {
		const container = $(this.element);

		$(document).ready(() => {
			if (container.attr("id")) {
                location.href = "#" + container.attr("id");
            }
		});
	}
}
