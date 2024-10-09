<?php
/*
  Plugin Name: Real Estate
  Description: Real Estate Plugin 
  Version: 1.0
  Author: Vlasiuk Vasyl
  Author URI: http://aletheme.com
  License: GPLv2 or later
  Text Domain: realestate
*/

if (!defined('ABSPATH')) die;

class RealEstate {

  public function register() {
    add_action('init', [$this, 'custom_post_type']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    add_action('wp_ajax_search_estates', [$this, 'search_real_estate']);
    add_action('wp_ajax_nopriv_search_estates', [$this, 'search_real_estate']);
    add_shortcode('real_estate_filter', [$this, 'render_filter_shortcode']);
    add_action('widgets_init', [$this, 'register_real_estate_widget']);
  }

  public function enqueue_scripts() {
    wp_enqueue_script('real-estate-ajax', plugins_url('./js/ajax.js', __FILE__), ['jquery'], null, true);
    wp_localize_script('real-estate-ajax', 'realEstateAjax', [
      'ajax_url' => admin_url('admin-ajax.php')
    ]);
  }

  //* Register CPT/Taxonomies
  public function custom_post_type() {
    register_post_type('real-estate', [
      'public'      => true,
      'has_archive' => true,
      'menu_icon'   => 'dashicons-admin-multisite',
      'rewrite'     => ['slug' => 'real-estate'],
      'label'       => esc_html__('Real Estate', 'realestate'),
      'supports'    => ['title', 'editor', 'thumbnail']
    ]);

    $args = array(
      'hierarchical'      => true,
      'labels'            => [
        'name'              => _x('Regions', 'taxonomy general name', 'realestate'),
        'singular_name'     => _x('Region', 'taxonomy singular name', 'realestate'),
        'search_items'      => __('Search Regions', 'realestate'),
        'all_items'         => __('All Regions', 'realestate'),
        'parent_item'       => __('Parent Region', 'realestate'),
        'parent_item_colon' => __('Parent Region:', 'realestate'),
        'edit_item'         => __('Edit Region', 'realestate'),
        'update_item'       => __('Update Region', 'realestate'),
        'add_new_item'      => __('Add New Region', 'realestate'),
        'new_item_name'     => __('New Region Name', 'realestate'),
          'menu_name'         => __('Regions', 'realestate'),
      ],
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array('slug' => 'real-estate/region'),
    );
    register_taxonomy('region', 'real-estate', $args);
  }

  //* Form Output
  public function render_filter_form() {
    ob_start();
    ?>
    <form action="" method="GET" class="real-estate-filter mb-4">
      <div class="mb-3">
        <label for="property-name" class="form-label"><?php _e('Назва будинку', 'realestate'); ?></label>
        <input type="text" id="property-name" name="property-name" class="form-control" />
      </div>

      <div class="d-flex mb-2">
        <div class="col-4">
          <select id="floors" name="floors" class="form-select">
            <option value="0"><?php _e('Кількість поверхів', 'realestate'); ?></option>
            <?php for ($i = 1; $i <= 20; $i++) : ?>
              <option value="<?= $i; ?>"><?= $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-4">
          <input type="radio" name="building-type" value="panel" id="building-type-panel" />
          <label class="mr-3" for="building-type-panel"><?php _e('Панель', 'realestate'); ?></label>
          <input type="radio" name="building-type" value="brick" id="building-type-brick" />
          <label class="mr-3" for="building-type-brick"><?php _e('Цегла', 'realestate'); ?></label>
          <input type="radio" name="building-type" value="foam" id="building-type-foam" />
          <label for="building-type-foam"><?php _e('Піноблок', 'realestate'); ?></label>
        </div>
        <div class="col-4">
          <select id="ecology" name="ecology" class="form-select">
            <option value="0"><?php _e('Екологічність', 'realestate'); ?></option>
            <?php for ($i = 1; $i <= 5; $i++) : ?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary"><?php _e('Фільтрувати', 'realestate'); ?></button>
    </form>
    <?php
    return ob_get_clean();
  }

  //* Render Filter
  public function render_filter_shortcode() {
    return $this->render_filter_form();
  }

  //* Register Widget
  public function register_real_estate_widget() {
    register_widget('RealEstate_Widget');
  }

  //* Ajax Search
  public function search_real_estate() {

    if (isset($_GET['formData'])) {
      parse_str($_GET['formData'], $form_data);

      $property_name = $form_data['property-name'];
      $building_type = $form_data['building-type'];
      $floors = $form_data['floors'];
      $ecology = $form_data['ecology'];
    }

    $args = [
      'post_type'      => 'real-estate',
      'posts_per_page' => 5,
      'paged'          => isset($_GET['page']) ? intval($_GET['page']) : 1,
      'post_status'    => 'publish',
    ];

    if (!empty($property_name)) {
      $args['s'] = $property_name;
    }

    $meta_query = [];

    if (!empty($building_type)) {
      $meta_query[] = [
        'key'     => 'building_type',
        'value'   => $building_type,
        'compare' => '='
      ];
    }

    if (!empty($floors)) {
      $meta_query[] = [
        'key'     => 'floors_numbers',
        'value'   => $floors,
        'compare' => '='
      ];
    }

    if (!empty($ecology)) {
      $meta_query[] = [
        'key'     => 'eco_friendliness',
        'value'   => $ecology,
        'compare' => '='
      ];
    }

    if (!empty($meta_query)) {
      $args['meta_query'] = $meta_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
      ob_start();
      while ($query->have_posts()) : $query->the_post(); 
        $image = get_field('image', get_the_ID());
      ?>

        <article class="col-4 mb-3">
          <h2><?php the_title(); ?></h2>
          <a href="<?php the_permalink(); ?>">
            <img src="<?= $image['url']; ?>" alt="Image">
          </a>
          <p><?php the_excerpt(); ?></p>
        </article>

      <?php 
      endwhile;

      $total_pages = $query->max_num_pages;

      wp_reset_postdata();
      $response = ob_get_clean();
      wp_send_json_success([
        'html' => $response,
        'total_pages' => $total_pages
      ]);
    } else {
      wp_send_json_error(__('No properties found.', 'realestate'));
    }

    wp_die();
  }

  static function activation() {
    flush_rewrite_rules();
  }
  static function deactivation() {
    flush_rewrite_rules();
  }
}

class RealEstate_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      'real_estate_widget', 
      __('Real Estate Filter', 'realestate'), 
      ['description' => __('A widget to filter real estate listings.', 'realestate')]
    );
  }

  public function widget($args, $instance) {
    echo $args['before_widget'];
    echo $args['before_title'] . __('Real Estate Filter', 'realestate') . $args['after_title'];
    // Output the form using the same method
    echo (new RealEstate())->render_filter_form();
    echo $args['after_widget'];
  }

  public function update($new_instance, $old_instance) {
    return $new_instance;
  }
}

if (class_exists('RealEstate')) {
  $realEstate = new RealEstate();
  $realEstate->register();
}

register_activation_hook(__FILE__, array($realEstate, 'activation'));
register_deactivation_hook(__FILE__, array($realEstate, 'deactivation'));