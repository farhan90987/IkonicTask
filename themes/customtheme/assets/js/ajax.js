/**
 * Jquery for ajax on button click
 * Task No 6
 */
jQuery( document ).ready( function( $ ) {
    $( '.btn_ajax_projects' ).click(function(){
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'get_projects',
                nonce: ajax_object.nonce
            },
            success: function ( response ) {
                if ( response.success ) {
                    let projects = response.data;
                    console.log( projects );
                } else {
                    console.error( 'Failed to fetch projects.' );
                }
            },
            error: function ( error ) {
                console.error( 'AJAX error:', error );
            }
        });
    })
});