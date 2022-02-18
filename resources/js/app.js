require('./bootstrap');
window.$ = window.jQuery = require( "jquery" );

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

jQuery(document).ready(function($) {
    setTimeout(() => {
        $('#status_message').slideUp('slow');
    }, 3000);

    $('#task_filter_trigger').on('click', function() {

        let text = $(this).text();

        if (text == 'Filter') {
            $(this).text('Close Filter');
        }
        if (text == 'Close Filter') {
            $(this).text('Filter');
        }

        $('#task_filter').slideToggle('3000');
    })
});

CKEDITOR.replace( 'description' );
