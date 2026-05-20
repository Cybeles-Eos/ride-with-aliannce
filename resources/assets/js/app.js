window.$ = window.jQuery = require('jquery');
require('popper.js');
require('bootstrap');
require('select2');
require('jquery-validation');
require('slick-carousel');
require('magnific-popup');
window.swal = require('sweetalert');
require('readmore-js');
require('datatables');
require('cookieconsent');
var AOS = require('aos');
AOS.init({
    easing: 'ease-in-out-sine'
});

// vendor
require('./static/platform/platform');
require('./static/platform/ajaxq');
require('./static/platform/centralAjax');
require('./static/platform/config');
require('./static/platform/delete');

require('./static/vendors/jquery.easing.min.js');
require('./static/vendors/scrolling-nav.js');

require('./static/custom/image_on_error.js');
require('./static/custom/menu_nav.js');
require('./static/custom/jquery_validation.js');
require('./static/custom/jquery.chain-height.js');

require('./static/custom/custom-slick-carousel.js');
// custom scripts mixed
require('./static/custom/custom-scripts.js');
require('./static/custom/custom-datatable.js');
// mobile navigation
require('./static/custom/custom-mobile-menu.js');
// target chrome on safari and pc
require('./static/custom/custom-safari-chrome');
// image background 
require('./static/custom/custom-imagebackground');
// cookie consent
require('./static/custom/custom-cookieconsent');