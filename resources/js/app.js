require('./bootstrap');
window.$ = window.jQuery = require( "jquery" );

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

jQuery(document).ready(function($) {
    setTimeout(() => {
        $('#status_message').slideUp('slow');
    }, 3000);
});

CKEDITOR.replace( 'description' );
