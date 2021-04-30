<?php

/**
 * Register meta and enqueue styles and scripts.
 */
function post_color_register() {
    // automatically load dependencies and version
    $asset_file = include(POST_COLOR_DIRECTORY . '/build/index.asset.php');

    wp_register_script(
        'post-color-js',
        POST_COLOR_DIRECTORY_URI . '/build/index.js',
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_style(
        'post-color-css',
        POST_COLOR_DIRECTORY_URI . '/css/gutenberg.panel.css',
        array(),
        filemtime(POST_COLOR_DIRECTORY . '/css/gutenberg.panel.css')
    );

    register_block_type(
        'acv/post-color',
        array(
            'editor_script' => 'post-color-js',
            'editor_style' => 'post-color-css',
        )
    );

	foreach ( post_color_setting('post-types' ) as $post_type )
        register_post_meta(
            $post_type,
            '_post-color',
            array(
                'show_in_rest'  => array(
                    'schema' => array(
                        'type' => 'object',
                        'properties' => array(
                            'background' => array(
                                'type' => 'string',
                            ),
                            'text' => array(
                                'type' => 'string',
                            )
                        ),
                    ),
                ),
                'single' => true,
                'type' => 'object',
                'auth_callback' => function () {
                    return current_user_can('edit_posts' );
                }
            )
        );
}
add_action( 'init', 'post_color_register', 1982 );

function post_color_rest() {
    register_rest_route('post-color/v1', '/getSettings', [
        'method' => 'GET',
        'permission_callback' => function () {
            return current_user_can('edit_posts' );
        },
        'callback' => function() {
            return rest_ensure_response( post_color_settings() );
        }
    ] );


    register_rest_route('post-color/v1', '/getSetting/(?P<setting>.+)', [
        'method' => 'GET',
        'permission_callback' => function () {
            return current_user_can('edit_posts' );
        },
        'callback' => function( $data ) {
            return rest_ensure_response( post_color_setting( $data['setting'] ) );
        }
    ] );
}
add_action( 'rest_api_init', 'post_color_rest' );

add_action( 'after_setup_theme', 'post_color_block_colors', 11 );
function post_color_block_colors() {
    $settings = post_color_settings();

    if ( !$settings['block'] || !$settings['custom'] )
        add_theme_support( 'disable-custom-colors' );

    add_theme_support( 'editor-color-palette', $settings['block'] ? array_map( function( $hex ) {
        return array( 'name' => $hex, 'slug' => ltrim( $hex, '#' ), 'color' => $hex );
    }, post_color_setting( 'colors' ) ) : [] );
}
