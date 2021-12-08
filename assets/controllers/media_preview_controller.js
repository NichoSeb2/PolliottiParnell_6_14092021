import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
		const input = $(this.element);
		const container = input.parent();

		let label = $("<label>Aperçu de l'image</label>");
		label
			.addClass("fs-5 m-0 pt-3 form-label w-100")
		;

		let image = $("<img>");
		image
			.attr("src", input.attr("url"))
			.addClass("w-50")
		;

		container.append(label, image);
    }
}
