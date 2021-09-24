import { Controller } from "stimulus";

export default class extends Controller {
	connect() {
		const container = $(this.element);

		if (container.hasClass("bg-image")) {
			const url = container.attr("bg-image-url");
			const minHeight = container.attr("min-height");

			container.css("background-image", `url(${url})`);

			if (minHeight != undefined) {
				container.css("min-height", minHeight);
			}
		}
	}
}
