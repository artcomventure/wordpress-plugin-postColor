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
    wp_localize_script( 'post-color-js', 'settings', post_color_settings() );

    wp_register_style(
        'post-color-css',
        POST_COLOR_DIRECTORY_URI . '/css/gutenberg.panel.css',
        array(),
        filemtime(POST_COLOR_DIRECTORY . '/css/gutenberg.panel.css')
    );

    register_block_type(
        'znovu/post-color',
        array(
            'editor_script' => 'post-color-js',
            'editor_style' => 'post-color-css',
        )
    );

    register_post_meta(
        'page',
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

add_action( 'init', 'post_color_register' );
