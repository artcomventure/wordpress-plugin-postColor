(function ( $ ) {

    function attachColorPicker( $context ) {
        if ( !$context || !$context.is( 'input.color-picker' ) )
            $context = $( 'input.color-picker', $context );

        $context.wpColorPicker( {
            change: function( event, ui ) {
                var $toggler = $(this).closest( '.wp-picker-input-wrap' ).prev();

                setTimeout( function() {
                    $toggler.css( { color: ui.color.toString() } );
                }, 35 );
            }
        } );
    }

    attachColorPicker();

    /**
     * Add color.
     */

    $( '.wp-picker-container.add-post-color' ).on( 'click', function() {
        var $addButton = $(this);
        var scope = $addButton.data( 'scope' );

        $.get( ajaxurl, {
            action: 'add-post-color',
            scope: scope,
            beforeSend: function() {
                $addButton.addClass( 'loading' );
            }
        }, function ( $response ) {
            $addButton.removeClass( 'loading' ).before( $response = $( $response) );
            $addButton.before( '&nbsp;' );
            attachColorPicker( $response );
            $response.click();
        } );
    } );

})( jQuery );