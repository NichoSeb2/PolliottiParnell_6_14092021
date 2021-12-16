import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        const container = $(this.element);

        const target = $(container.attr("data-bs-target") + " .modal-dialog .modal-content .modal-body");
        const targetTitle = $(container.attr("data-bs-target") + " .modal-dialog .modal-content .modal-title");
        const origin = container.children(".modal-container");

        container.on("click", () => {
            targetTitle.text(origin.attr("title"));
            target.html(origin.html());
        });
    }
}
