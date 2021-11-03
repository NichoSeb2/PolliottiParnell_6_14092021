import { Controller } from "stimulus";

export default class extends Controller {
	connect() {
		const container = $(this.element);

		this.update(container);

		container.on("click", () => this.update(container));
	}

	update(container) {
		let newLabel;

		if (container.is(":checked")) {
			newLabel = container.attr("on");
		} else {
			newLabel = container.attr("off");
		}

		$(`label[for="${container.attr("id")}"]`).text(newLabel);
	}
}
