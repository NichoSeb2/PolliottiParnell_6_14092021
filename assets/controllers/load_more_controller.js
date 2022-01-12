const routes = require('../../public/js/fos_js_routes.json');

import { Controller } from 'stimulus';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

export default class extends Controller {
    connect() {
        const button = $(this.element);

        button.on("click", (e) => {
            e.preventDefault();

            const initialBtnText = button.text();

            button.attr("disabled", "disabled");
            button.html('<span class="spinner-border spinner-border-sm" role="status"></span> Chargement...');

            const container = $(button.attr("target"));
            const route = button.attr("route");
            const loaded = $(button.attr("target") + " > div").length;
            const to_load = parseInt(button.attr("to-load"));
            const parent_id = button.attr("parent-id");
            let link;

            if (parent_id != undefined) {
                link = Routing.generate(route, { loaded, to_load, parent_id });
            } else {
                link = Routing.generate(route, { loaded, to_load });
            }

            $.ajax({
                url: link, 
                type: 'GET', 
                data: {}, 
                success: (data, status, response) => {
                    const max_element = parseInt(response.getResponseHeader("total-element-count"));

                    button.removeAttr("disabled");
                    button.html(initialBtnText);

                    const elements = $.parseHTML(data).filter(e => {
                        return e.data === undefined;
                    });

                    elements.forEach(element => {
                        container.append(element);                        
                    });

                    const threshold = parseInt(button.attr("threshold"));

                    if ((loaded + elements.length) == 0) {
                        container.append($(`<div class="col-lg-22"><p class="text-center">` + "Il n'y a pour l'instant aucun trick." + `</p></div>`))
                    }

                    if ((loaded + elements.length) >= max_element) {
                        button.parent().remove();
                    }

                    if (threshold != undefined && (loaded + elements.length) >= threshold) {
                        $(button.attr("threshold-target")).removeClass("d-none");
                    }
                }, 
                error: (response, status, error) => {}, 
            });
        });
    }
}
