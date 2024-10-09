<?php 
/**
 * Template Name: Buildings
 */

get_header(); ?>

<div class="container">
  <h1><?php the_title(); ?></h1>

  <!-- Filtres -->
  <?= do_shortcode('[real_estate_filter]'); ?>

  <!-- Post Grid -->
  <div id="property-results" class="row"></div>

  <!-- Load More -->
  <button id="load-more" class="btn btn-primary" style="display: none;">Показати більше</button>
</div>

<?php get_footer(); ?>