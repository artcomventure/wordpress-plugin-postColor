<?php

/**
 * Apply color settings.
 */
function post_color_css() {
    $CSS = "";

	// query all posts with set colors
	if ( ($query = new WP_Query( array(
		'post_type' => post_color_setting( 'post-types' ),
		'post_status' => 'draft,pending,publish',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_post-color',
				'compare' => 'EXISTS'
			),
		)
	) ))->have_posts() ) foreach ( $query->posts as $post ) {
        $color = get_post_meta( $post->ID, '_post-color', true );
        if ( ! ($color = array_filter( $color )) ) continue;

        $selector = ["#post-{$post->ID}"];
        // add post color to body!?
        if ( apply_filters( 'add-post-color-to-body', $post->ID == get_the_ID() || (is_home() && $post->ID == get_option( 'page_for_posts' )), $post->ID ) )
            // `html` prefix to override without `!important` flag
            $selector = array_merge( $selector, array( 'html body', 'html body.custom-background' ) );

        // ... and add color CSS
        $CSS .= implode( ', ', $selector ) . " {
            " . ( !empty($color['background']) ? "background-color: " . $color['background'] : '' ) . ";
            " . ( !empty($color['text']) ? "color: " . $color['text'] : '' ) . ";
        }";
    }

	if ( post_color_setting( 'block' ) )
        foreach ( post_color_setting( 'colors' ) as $color ) {
            $selector = ltrim( strtolower( $color ), '#' );
            preg_match_all('/(?:[0-9]+|[a-zA-Z]+)/', $selector, $selector );
            $selector = implode( '-', $selector[0] );

            $CSS .= ".has-text-color.has-{$selector}-color { color: {$color} }";
            $CSS .= ".has-background.has-{$selector}-background-color { background-color: {$color} }";
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
