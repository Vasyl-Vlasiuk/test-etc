<?php 
  $name = get_field('house_name');
  $location = get_field('location');
  $building_type = get_field('building_type');
  $floors_numbers = get_field('floors_numbers');
  $eco_friendliness = get_field('eco_friendliness');
  $image = get_field('image');
  $facilities = get_field('facilities');

get_header(); ?>

<div class="container mt-4">
  <div class="row">
    <div class="col-4">
      <!-- Зображення -->
      <?php if ($image): ?>
        <div class="mb-3">
          <h5 class="fw-bold mb-3">Зображення:</h5>
          <img src="<?= $image['url']; ?>" alt="Зображення будинку" class="img-fluid" id="building-image">
        </div>
      <?php endif; ?>
    </div>

    <div class="col-8">
      <!-- Назва будинку -->
      <?php if ($name): ?>
        <div class="mb-3">
          <h5 class="fw-bold"><?php _e( 'Назва будинку:', 'understrap_child' ) ?></h5>
          <p id="house-name"><?= $name; ?></p>
        </div>
      <?php endif; ?>
    
      <!-- Координати місцезнаходження -->
      <?php if ($location): ?>
        <div class="mb-3">
          <h5 class="fw-bold"><?php _e( 'Координати місцезнаходження:', 'understrap_child' ) ?></h5>
          <p id="location-coordinates"><?= $location; ?></p>
        </div>
      <?php endif; ?>
    
      <!-- Кількість поверхів -->
      <?php if ($floors_numbers): ?>
        <div class="mb-3">
          <h5 class="fw-bold"><?php _e( 'Кількість поверхів:', 'understrap_child' ) ?></h5>
          <p id="floors"><?= $floors_numbers; ?></p>
        </div>
      <?php endif; ?>
    
      <!-- Тип будівлі -->
      <?php if (!empty($building_type)): ?>
        <div class="mb-3">
          <h5 class="fw-bold"><?php _e( 'Тип будівлі:', 'understrap_child' ) ?></h5>
          <p id="building-type"><?= $building_type['label']; ?></p>
        </div>
      <?php endif; ?>
    
      <!-- Екологічність -->
      <?php if ($eco_friendliness): ?>      
        <div class="mb-3">
          <h5 class="fw-bold"><?php _e( 'Екологічність:', 'understrap_child' ) ?></h5>
          <p id="ecology-rating"><?= $eco_friendliness; ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <!-- Приміщення -->
  <?php if ( $facilities ): ?>
    <div class="mt-4">
      <h5 class="fw-bold mb-3">Приміщення:</h5>
      <div class="row">
          <?php foreach( $facilities as $i=>$facility ) : 
            $i++;
            $area = $facility['area'];
            $room_numbers = $facility['room_numbers'];
            $balcony = $facility['balcony'];
            $bathroom = $facility['bathroom'];
            $img = $facility['image'];
          ?>
          <div class="col-4 mb-4">
            <img src="<?= $img['url']; ?>" alt="Зображення приміщення" class="img-fluid">
            <h6 class="fw-bold"><?php _e( "Приміщення $i", 'understrap_child' ) ?>:</h6>
            <p><?php _e( 'Площа:', 'understrap_child' ); echo ' ' . $area; ?></p>
            <p><?php _e( 'Кількість кімнат:', 'understrap_child' ); echo ' ' . $room_numbers; ?></p>
            <p><?php _e( 'Балкон:', 'understrap_child' ); echo $balcony === 'yes' ? ' так' : ' ні'; ?></p>
            <p><?php _e( 'Санвузол:', 'understrap_child' ); echo $bathroom === 'yes' ? ' так' : ' ні';; ?></p>
            
          </div>
          <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>


<?php get_footer(); ?>