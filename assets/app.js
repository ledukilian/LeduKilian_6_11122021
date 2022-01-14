/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/zephyr.css';
import './styles/style.css';

// start the Stimulus application
import './bootstrap';

$(document).on('click', 'a[href^="#"]', function(e) {
    let id = $(this).attr('href');
    let $id = $(id);
    if ($id.length === 0) {
        return;
    }
    e.preventDefault();
    let mainNavbarSize = document.getElementById('main-navbar').offsetHeight;
    let pos = $id.offset().top - mainNavbarSize;
    $('body, html').animate({scrollTop: pos});
});