<section class="partners-sect container">
  <h2 class="partners-sect__title">Дилеры и партнеры</h2>
  <img src="<?php echo $template_directory ?>/img/map-static.svg" alt="" class="partners-sect__map"> <?php
  $cities = get_field( 'cities' );
  foreach ( $cities as $city ) :
    if ( $city['city_id'] ) {
      $id = ' id="' . $city['city_id'] . '"';
    } else {
      $id = '';
    } ?>
    <div class="partners-sect__city"<?php echo $id ?>>
      <span class="partner__city"><?php echo $city['city_title'] ?></span> <?php
      foreach ( $city['group'] as $element ) : ?>
        <div class="partner__block">
          <span class="partner__title"><?php echo $element['group_name'] ?></span> <?php
          foreach ( $element['group_elements'] as $el ) : ?>
            <p class="partner__descr"><?php echo str_replace(
              [
                '<p>',
                '</p>',
                '<a href="mailto:',
                '<a href="tel:',
                '<a href="http'
              ],
              [
                '',
                '',
                '<a class="link" href="mailto:',
                '<a class="link" href="tel:',
                '<a class="link_blue" target="_blank" rel="noopener nofollow" href="http'
              ], $el['element'] ) ?></p> <?php
          endforeach ?>
        </div> <?php
      endforeach;
  endforeach ?>
</section>