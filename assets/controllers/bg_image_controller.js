import { Controller } from "stimulus";

export default class extends Controller {
	connect() {
		const container = $(this.element);

		if (container.hasClass("bg-image")) {
			const url = container.attr("bg-image-url");
			const minHeight = container.attr("min-height");
			const target = container.attr("target");

			if (target != undefined) {
				$(target).css("background-image", `url(${url})`);
			} else {
				container.css("background-image", `url(${url})`);
			}

			if (minHeight != undefined) {
				container.css("min-height", minHeight);
			}
		}
	}
}
