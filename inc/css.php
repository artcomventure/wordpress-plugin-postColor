<?php

/**
 * Apply color settings.
 */
function post_color_css() {
    $CSS = "";

	// query all posts with set colors
	if ( !($query = new WP_Query( array(
		'post_type' => post_color_setting( 'post-types' ),
		'post_status' => 'draft,pending,publish',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_post-color',
				'compare' => 'EXISTS'
			),
		)
	) ))->have_posts() ) return;

	// loop through posts
	foreach ( $query->posts as $post ) {
		$color = get_post_meta( $post->ID, '_post-color', true );
		if ( ! ($color = array_filter( $color )) ) continue;

		// ... and add color CSS
		$CSS .= "#post-{$post->ID} {
            " . ( !empty($color['background']) ? "background-color: " . $color['background'] : '' ) . ";
            " . ( !empty($color['text']) ? "color: " . $color['text'] : '' ) . ";
        }";
    }

    // minify css
	$CSS = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $CSS ); // negative look ahead
	$CSS = preg_replace('/\s{2,}/', ' ', $CSS );
	$CSS = preg_replace('/\s*([:;{}])\s*/', '$1', $CSS );
	$CSS = preg_replace('/;}/', '}', $CSS );

	if ( ! $CSS ) return; ?>

    <style id="post-color-inline-css"><?php echo $CSS; ?></style>
<?php }
add_action( 'wp_head', 'post_color_css' );
