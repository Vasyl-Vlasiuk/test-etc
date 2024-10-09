<?php
function understrap_child_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [ 'parent-style' ], wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'understrap_child_styles' );


function understrap_child_setup() {
  register_nav_menus(array(
    'header_menu' => __('Header Menu', 'understrap_child')
  ));
}
add_action('after_setup_theme', 'understrap_child_setup');