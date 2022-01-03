import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
		const container = $(this.element).parent();

        let index = container.children("div").attr("id").split("_");
        index = parseInt(index[index.length - 1]) + 1;

        let deleteButton = $("<button></button>");
        deleteButton
            .text("Supprimer le média")
            .addClass("btn btn-danger text-light mb-3")
            .attr("type", "button");

        deleteButton.on("click", function() {
            const container = $(this).parent().parent().parent().parent().parent().parent();
            const closeButton = $(this).parent().parent().parent().children(".modal-header").children(".btn-close");

            closeButton.trigger('click');

            setTimeout(() => {
                container.remove();
            }, 400);
        });

        container.children("legend").remove();
        container.append(deleteButton);

        const title = container.parent().parent().children(".modal-header").children(".modal-title");

        title.html(`Média n°${index}`);
    }
}
