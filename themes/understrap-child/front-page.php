<?php get_header(); ?>

<div class="container mt-5">
  <h1><?php _e('Blog', 'realestate'); ?></h1>

  <?php 
    $args = [
      'post_type'      => 'post',
      'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);
    if ($query->have_posts()):
      while($query->have_posts()): $query->the_post();
        get_template_part('template-parts/post-card');
      endwhile;
    else:
      echo '<p>' . __('No properties found.', 'realestate') . '</p>';
    endif;
    wp_reset_postdata();
  
  ?>
</div>

<?php get_footer(); ?>