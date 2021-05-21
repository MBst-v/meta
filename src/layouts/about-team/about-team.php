<?php
$sect = get_field( 'team' );
$sect_title = $sect['sect_title'];
$sect_team = $sect['team'];

if ( $sect && $sect_title && $sect_team ) : ?>

  <section class="team container">
    <h2 class="team__title"><?php echo $sect_title ?></h2>
    <div id="team-slider"> <?php
      foreach ( $sect_team as $char ) : ?>
        <div class="char">
          <img src="#" alt="" data-src="<?php echo $char['img'] ?>" class="char__img lazy">
          <span class="char__title"><?php echo $char['title'] ?></span>
          <span class="char__pos"><?php echo $char['position'] ?></span>
        </div> <?php
      endforeach ?>
      <div class="team-slider__nav slider-nav"></div>
    </div>
  </section> <?php
endif ?>