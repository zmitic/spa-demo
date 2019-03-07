const $ = require('jquery');

$(document).on('click', 'a', function () {
    let $a = $(this);
    let href = $a.attr('href');
    if (!href) {
        return;
    }

    let activeOutlet = $('outlet[active]').first();
    if (!activeOutlet.length) {
        return;
    }
    console.log(activeOutlet.attr('route-name'));

    $.ajax({
        url: href,
        headers: {
            'active' : activeOutlet.attr('route-name')
        },
        cache: true
    })
        .done((data, textStatus, jqXHR) => {
            if (!data) {
                console.log('No changes');
                return;
            }
            let spaParent = jqXHR.getResponseHeader('spa-outlet');
            let outletDom = $(`outlet[route-name="${spaParent}"]`).first();
            if (!outletDom.length) {
                outletDom = $(`outlet[route-name="root"]`).first();
            }

            if (!outletDom.length) {
                console.log('No outlet: ' + spaParent);
                return;
            }

            // history.pushState(null, null, currentRouteName);
            // console.log(jqXHR.getResponseHeader('spa-route'));
            outletDom.html(data);
            // history.replaceState(null, null, href);
        })
        .always(() => {
        })
    ;

    return false;
});