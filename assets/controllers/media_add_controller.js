import { Controller } from "stimulus";

export default class extends Controller {
	connect() {
		const button = $(this.element);

		button.on("click", function (e) {
			const list = $($(this).attr('data-list-selector'));
			let counter = list.data('widget-counter') || list.children().length;

			let newWidget = list.attr('data-prototype');
			newWidget = newWidget.replace(/__name__/g, counter);
			counter++;

			list.data('widget-counter', counter);

			const newElement = $.parseHTML(newWidget);

			list.append(newElement);
		});
	}
}
