<?php
$sect = get_field( 'hero' );
$sect_title = $sect['sect_title'];
$sect_text = $sect['text'];
$sect_gallery = $sect['gallery'];
$sect_features = $sect['features'];
$show_gallery = $sect['show_gallery'];

if ( $show_gallery ) {
  $gallery_attr = ' style="display:none"';
} else {
  $gallery_attr = '';
} ?>

<section class="about container">
  <div id="about-gallery"<?php echo $gallery_attr ?>> <?php
    foreach ( $sect_gallery as $img ) : ?>
      <img src="#" alt="" data-src="<?php echo $img ?>" class="about__gallery-img lazy"> <?php
    endforeach ?>
    <div class="about__gallery-nav slider-nav"></div>
  </div>
  <h1 class="about__title"><?php echo $sect_title ?></h1>
  <div class="about__text"> <?php
    foreach ( $sect_text as $p ) : ?>
      <p class="about__descr"><?php echo $p['p'] ?></p> <?php
    endforeach ?> 
  </div>
  <div class="about__feats"> <?php
    foreach ( $sect_features as $feat ) : ?>
      <div class="feat">
        <img src="#" alt="" data-src="<?php echo $feat['img'] ?>" class="feat__img lazy">
        <span class="feat__title"><?php echo $feat['title'] ?></span>
      </div> <?php
    endforeach ?>
  </div> 
</section>