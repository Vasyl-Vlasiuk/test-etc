<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<header id="wrapper-navbar">
    <nav id="main-nav" class="navbar navbar-expand-md navbar-dark bg-primary" aria-labelledby="main-nav-label">

      <h2 id="main-nav-label" class="screen-reader-text">
        <?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
      </h2>


      <div class="container">

        <?php get_template_part( 'global-templates/navbar-branding' ); ?>

        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <?php
        wp_nav_menu(
          [
            'theme_location'  => 'header_menu',
            'container_class' => 'collapse navbar-collapse',
            'menu_class'      => 'navbar-nav ml-auto',
            'fallback_cb'     => '',
            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
          ]
        );
        ?>
    </nav><!-- #main-nav -->
	</header><!-- #wrapper-navbar -->
