<?php

function wpbootstrap_scripts_with_jquery()
{
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );




/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

    register_sidebar( array(
        'name'          => 'Home right sidebar',
        'id'            => 'home_right_1',
        'before_widget' => '<div c;ass="sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="sidebar-title">',
        'after_title'   => '</h2><hr>',
    ) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );



add_theme_support( 'post-thumbnails' );
add_image_size( 'post-preview', 370, 222 );
add_image_size( 'post-feature-small', 800, 480 );
add_image_size( 'post-feature', 1000, 600, true );
add_image_size( 'post-feature-large', 1200, 720, true );

?>