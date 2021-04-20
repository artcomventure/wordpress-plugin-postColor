<?php

/**
 * Plugin Name: Post Color
 * Plugin URI: https://github.com/artcomventure/wordpress-plugin-postColor
 * Description: Set specific colors for each and every post/page.
 * Version: 1.0.10
 * Text Domain: post-color
 * Author: artcom venture GmbH
 * Author URI: http://www.artcom-venture.de/
 */

if ( ! defined( 'POST_COLOR_DIRECTORY' ) ) {
    define( 'POST_COLOR_DIRECTORY', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'POST_COLOR_DIRECTORY_URI' ) ) {
    define( 'POST_COLOR_DIRECTORY_URI', plugin_dir_url( __FILE__ ) );
}

/**
 * Load translation file.
 */
function post_color_t9n() {
	load_theme_textdomain( 'post-color', POST_COLOR_DIRECTORY . 'languages' );
}
add_action( 'plugins_loaded', 'post_color_t9n' );

/**
 * Since this plugin is not listed on https://wordpress.org/plugins/
 * we remove any update notification in case of _name overlaps_.
 */
add_filter( 'site_transient_update_plugins', function( $value ) {
    if ( isset( $value->response[$plugin_file = plugin_basename( __FILE__ )] ) ) {
        unset( $value->response[$plugin_file] );
    }

    return $value;
} );

/**
 * Change details link to GitHub repository.
 */
add_filter( 'plugin_row_meta', function( $links, $file ) {
	if ( __FILE__ == $file ) {
		$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $file );

		$links[2] = '<a href="' . $plugin_data['PluginURI'] . '">' . __( 'Plugin-Seite aufrufen' ) . '</a>';
	}

	return $links;
}, 10, 2 );

// include inc files
require POST_COLOR_DIRECTORY . '/inc/settings.php';
require POST_COLOR_DIRECTORY . '/inc/gutenberg.php';
require POST_COLOR_DIRECTORY . '/inc/css.php';