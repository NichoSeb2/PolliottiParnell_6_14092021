import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
		const container = $(this.element).parent().parent().parent();

        let index = container.children("div").attr("id").split("_");
        index = parseInt(index[index.length - 1]) + 1;

        container.children("legend").text(`Média n°${index}`);
    }
}
