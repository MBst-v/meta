<section class="about container">
  <div id="about-gallery"> <?php
    foreach ( $section['gallery'] as $img ) : ?>
      <img src="#" alt="" data-src="<?php echo $img ?>" class="about__gallery-img lazy"> <?php
    endforeach ?>
    <div class="about__gallery-nav slider-nav"></div>
  </div>
  <h2 class="about__title text_blue"><?php echo $section['sect_title'] ?></h2>
  <p class="about__descr"><?php echo $section['sect_descr'] ?></p>
  <a href="<?php echo $section['link']['url'] ?>" class="link link_blue"><?php echo $section['link']['title'] ?></a>
  <div class="about__feats"> <?php
    foreach ( $section['features'] as $feat ) : ?>
      <div class="feat">
        <img src="#" data-src="<?php echo $feat['img'] ?>" alt="" class="feat__img lazy">
        <span class="feat__title"><?php echo $feat['descr'] ?></span>
      </div> <?php
    endforeach ?>
  </div> <?php
  $clients = $section['partners'];
  if ( $clients ) : ?>
    <div id="about-partners"> <?php
      $terms = get_terms( [
        'taxonomy' => 'partners',
        'hide_empty' => false
      ] );
      foreach ( $terms as $term ) :
        $client_img = get_field( 'client_logo', $term ) ?>
        <img src="#" alt="" title="<?php echo $term->name ?>" data-src="<?php echo $client_img ?>" class="partner lazy"> <?php
      endforeach ?>
      <div class="about-partners__nav slider-nav"></div>
    </div> <?php
  endif ?>
</section>