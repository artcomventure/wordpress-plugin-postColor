<?php

/**
 * Register `post-color` setting.
 */
function post_color_register_setting() {
	register_setting( 'post-color', 'post-color' );
}
add_action( 'admin_init', 'post_color_register_setting' );

/**
 * Register admin menu item and settings page.
 */
function post_color_add_settings_page() {
	add_options_page(
		__( 'Post Colors', 'post-color' ),
		__( 'Post Colors', 'post-color' ),
		'manage_options',
		'post-color-settings',
		'post_color_settings_page'
	);
}
add_action( 'admin_menu', 'post_color_add_settings_page' );

/**
 * Get post-color setting(s).
 *
 * @param null $setting
 * @return mixed
 */
function post_color_settings( $setting = null ) {
	$settings = get_option( 'post-color', array() );
	if ( !is_array( $settings ) ) $settings = array();

	$settings += array(
		'post-types' => [],
		'background' => [],
		'text' => [],
		'custom' => ''
	);

	if ( !$settings['post-types'] )
        $settings['post-types'] = array_column( post_color_available_post_types(), 'name' );

	if ( $setting ) {
		if ( isset($settings[$setting]) ) return $settings[$setting];
		return null;
	}

	return $settings;
}

/**
 * Get post-color setting.
 *
 * @param $setting
 * @return mixed
 */
function post_color_setting( $setting ) {
	return post_color_settings( $setting );
}

/**
 * Settings page markup.
 */
function post_color_settings_page() {
	wp_enqueue_script( 'post-color-settings-js', POST_COLOR_DIRECTORY_URI . 'js/settings.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-slider' ) );
	wp_enqueue_style( 'post-color-settings-css', POST_COLOR_DIRECTORY_URI . 'css/settings.css', array( 'wp-color-picker' ) );

	include( POST_COLOR_DIRECTORY . 'inc/settings.page.php' );
}

/**
 * Get all available post types.
 */
function post_color_available_post_types() {
    $post_types = array_intersect_key(
        get_post_types( array( 'public' => TRUE ), 'objects' ),
        array_flip( get_post_types_by_support( array( 'custom-fields' ) ) )
    );

    return $post_types;
}

/**
 * Get color picker html.
 *
 * @param $scope
 * @param string $value
 *
 * @return string
 */
function get_post_color_picker_input( $scope, $value = '' ) {
	return '<input type="text" name="post-color[' . $scope . '][]" class="color-picker" value="' . $value . '" />';
}

function post_color_picker_input( $scope, $value = '' ) {
	echo get_post_color_picker_input( $scope ?: $_GET['scope'], $value );
	if ( wp_doing_ajax() ) wp_die();
}

add_action( 'wp_ajax_add-post-color', 'post_color_picker_input' );

/**
 * Remove empty settings.
 *
 * @param array $values
 *
 * @return array
 */
function post_color_settings_pre_update( $values ) {
	foreach ( $values as $key => $value ) {
		if ( !is_array( $value ) ) continue;
		$values[$key] = array_filter( $value );
	}

	return $values;
}
add_filter( 'pre_update_option_post-color', 'post_color_settings_pre_update' );
