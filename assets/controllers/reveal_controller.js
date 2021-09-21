import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
		const button = $(this.element);
        const target = button.attr("target");

        if (target != "") {
            button.on("click", () => {
                button.parent("div").hide();
                $(target).removeClass("d-none");
            });
        }
    }
}
