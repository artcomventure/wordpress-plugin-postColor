<?php

/**
 * https://wordpress.org/support/topic/gutenberg-updating-failed-with-custom-post-meta/
 *
 * Due to missing `auth_callback` in Bogo's `register_post_meta` for `_locale` and `_original_post`
 * it's not possible to save custom post metas.
 *
 * This fixes this issue till (maybe) Bogo will be updated.
 */

add_filter( 'register_meta_args', 'fix_bogos_register_post_meta', 10, 4 );
function fix_bogos_register_post_meta( $args, $defaults, $object_type, $meta_key ) {
	if ( in_array( $meta_key, array( '_locale', '_original_post' ) ) ) {
		$args += array(
			'auth_callback' => function () {
				return current_user_can('edit_posts' );
			}
		);
	}

	return $args;
}