import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
		const container = $(this.element).parent();

        let index = container.children("div").attr("id").split("_");
        index = parseInt(index[index.length - 1]) + 1;

        let deleteButton = $("<button></button>");
        deleteButton
            .append($('<i class="fas fa-trash-alt"></i>'))
            .addClass("btn p-1 fs-5")
            .css("margin-bottom", "4px")
            .css("margin-left", "4px")
            .attr("type", "button")
            .attr("data-controller", "media-delete");

        deleteButton.on("click", function() {
            $(this).parent().parent().remove();
        });

        container.children("legend").html(`Média n°${index}`).append(deleteButton);
    }
}
