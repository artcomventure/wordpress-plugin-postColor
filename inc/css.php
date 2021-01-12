<?php

/**
 * Apply color settings.
 */
function post_color_css() {
    $css = "";

    foreach ( get_pages( array( 'post_status' => 'draft,pending,publish' ) ) as $post ) {
        if ( ! $color = get_post_meta( $post->ID, '_post-color', true ) ) continue;
        if ( ! array_filter( $color ) ) continue;

        $css .= "#post-{$post->ID} {
            background-color: " . $color['background'] . ";
            color: " . $color['text'] . ";
        }";
    }

    // minify css
    $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css ); // negative look ahead
	$css = preg_replace('/\s{2,}/', ' ', $css );
	$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css );
	$css = preg_replace('/;}/', '}', $css );

	if ( ! $css ) return; ?>

    <style type="text/css" id="post-color-css"><?php echo $css; ?></style>
<?php }
add_action( 'wp_head', 'post_color_css' );
