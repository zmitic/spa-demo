const $ = require('jquery');

let activeRoute = null;
$(document).on('click', 'a', function () {
    let $a = $(this);
    let href = $a.attr('href');
    if (!href) {
        return;
    }

    if (!activeRoute) {
        let activeOutlet = $('outlet[active]').first();
        if (!activeOutlet.length) {
            return;
        }
        activeRoute = activeOutlet.attr('route-name');
        activeOutlet.removeAttr('active');
    }

    $.ajax({
        url: href,
        headers: {
            'active' : activeRoute
        },
        cache: true
    })
        .done((data, textStatus, jqXHR) => {
            if (!data) {
                console.error('No response');

                return;
            }

            $('outlet[active]').removeAttr('active');
            let outletDom = $(`outlet-inner[route-name="${activeRoute}"]`).first();
            if (!outletDom.length) {
                console.log('No outlet: ' + activeRoute);
                return;
            }
            activeRoute = jqXHR.getResponseHeader('spa-active-route');

            // history.pushState(null, null, currentRouteName);
            // console.log(jqXHR.getResponseHeader('spa-route'));
            outletDom.html(data);
            history.replaceState(null, null, href);
        })
        .always(() => {
        })
    ;

    return false;
});