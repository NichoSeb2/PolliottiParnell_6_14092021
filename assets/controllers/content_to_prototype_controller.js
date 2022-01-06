import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        const container = $(this.element);

        const parent = $("<div></div>")
            .addClass("col-lg-4 p-1")
        ;

        const preview = $("<div></div>")
            .addClass("d-flex flex-column justify-content-center overlay-play bg-image a-r-16-9")
            .attr("data-bs-toggle", "modal")
            .attr("data-bs-target", "#fullscreenMediaEditModal-__name__")
            .attr("data-controller", "bg-image")
            .attr("bg-image-url", "/images/placeholder.png")
        ;
        preview.append($(`<div class="button"><i class="fas fa-pencil-alt" title="Édition du média"></i><i class="fas fa-trash-alt" title="Suppression du média"></i></div>`));
        parent.append(preview);

        const modal = $("<div></div>")
            .addClass("modal modal-fullscreen fade")
            .attr("id", "fullscreenMediaEditModal-__name__")
            .attr("tabindex", "-1")
            .attr("aria-labelledby", "fullscreenMediaModalEditLabel-__name__")
            .attr("aria-hidden", "true")
        ;
        const dialog = $("<div></div>")
            .addClass("modal-dialog")
        ;
        const content = $("<div></div>")
            .addClass("modal-content")
        ;
        const header = $("<div></div>")
            .addClass("modal-header")
        ;
        header.append($(`<h5 class="modal-title" id="fullscreenMediaModalEditLabel-__name__">Lorem</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cancel"></button>`));

        const body = $("<div></div>")
            .addClass("modal-body py-0 min-vw-50")
        ;

        const fieldset = $("<fieldset></fieldset>").addClass("m-0");
        fieldset.append(container.html().trim());

        body.append(fieldset);
        body.append($(`<p class="form-text m-0 mb-3 help-text"><i class="fas fa-info-circle"></i> ` + "La création de ce média ne sera réellement effectuée qu'après-avoir sauvegardé le trick." + `</p>`));
        content.append(header);
        content.append(body);
        dialog.append(content);
        modal.append(dialog);

        parent.append(modal);

        const fakeContainer = $("<span></span>");
        fakeContainer.append(parent);

        container.html("");
        $(container.attr("target")).attr("data-prototype", fakeContainer.html().trim());
    }
}
