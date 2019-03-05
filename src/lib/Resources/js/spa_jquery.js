const $ = require('jquery');

$(document).on('click', 'a', function () {
    let $a = $(this);
    let href = $a.attr('href');
    if (!href) {
        return;
    }

    console.log(history);

    $.ajax({
        url: href,
        cache: true
    })
        .done((data, textStatus, jqXHR) => {
            let spaParent = jqXHR.getResponseHeader('spa_outlet');
            let outletDom = $(`outlet[route-name="${spaParent}"]`).first();
            if (!outletDom.length) {
                alert('No outlet: ' + spaParent);
                return false;
            }

            // history.pushState(null, null, currentRouteName);
            console.log(jqXHR.getResponseHeader('spa_route'));
            outletDom.html(data);
            history.replaceState(null, null, href);
        })
        .always(() => {
        })
    ;

    return false;
});