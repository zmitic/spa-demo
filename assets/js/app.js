const $ = require('jquery');


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

require('../../vendor/htc/spa-bundle/src/Resources/public/js/htc_spa_jquery.js');

$(document).on('click', '.navbar a.nav-item[href]', function () {
    let $a = $(this);
    $a.closest('.navbar-nav').find('a.active').removeClass('active');
    $a.addClass('active');
});


