import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
		const container = $(this.element);

        container.removeClass("flex-column");

        container.children("div").children("input").each((index, element) => {
            $(element).on("click", () => {
                this.update(container);
            })
        });

        this.update(container);
    }

    update(container) {
        let selected = null;

        container.children("div").children("input").each((index, element) => {
            if ($(element).is(":checked")) {
                selected = $(element).val();
            }
        });

        container.parent().parent().children().children("input.form-control").each((index, element) => {
            element = $(element);

            switch (selected) {
                case "file":
                    this.toggle(element, element.attr("file") == "file");
                    break;
                case "url":
                    this.toggle(element, element.attr("url") == "url");
                    break;
                default:
                    this.toggle(element);
                    break;
            }
        });
    }

    toggle(element, visibility = false) {
        element.parent().children().each((index, element) => {
            element = $(element);

            if (visibility) {
                element.show();

                if (element.is("input")) {
                    if (element.attr("dynamicRequire")) {
                        element.attr("required", "");
                    }
                }
            } else {
                element.hide();

                if (element.is("input")) {
                    if (element.attr("dynamicRequire")) {
                        element.removeAttr("required");
                    }
                }
            }
        });
    }
}
