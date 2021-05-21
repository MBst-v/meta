<?php

$extname_regExp = '/[^.]+$/';

$hero_slider = $section['slides'];

function get_image_src( $img ) {
  global $is_webp_support, $extname_regExp;

  if ( $img ) {
    $img_id = $img['ID'];
    $img_url = $img['url'];
    $img_path = get_attached_file( $img_id );

    if ( $is_webp_support ) {
      $img_webp_path = preg_replace( $extname_regExp, 'webp', $img_path );
      $is_webp_exists = file_exists( $img_webp_path );
    }

    if ( $is_webp_exists ) {
      $img_url = preg_replace( $extname_regExp, 'webp', $img_url );
    }

    return $img_url;
  } else {
    return false;
  }

}

foreach ( $hero_slider as $slide ) {
  $hero_img_url = get_image_src( $slide['img'] );
  $hero_bg_url = get_image_src( $slide['bg'] );

}

if ( $hero_slider ) : ?>

  <section class="index-hero" id="index-hero-slider"> <?php
    for ( $i = 0, $len = count( $hero_slider ); $i < $len; $i++ ) :
      $id = $hero_slider[ $i ]['id'];
      if ( $id ) {
        $id = ' data-id="' . $id . '"';
      }
      $hero_slide_title_tag = $i === 0 ? 'h1' : 'h2' ?>
      <!-- <div class="index-hero__slide lazy" data-src="url(<?php #echo $hero_slider[ $i ]['bg'] ?>)"> -->
      <div class="index-hero__slide lazy"<?php echo $id ?> data-src="url(<?php echo get_image_src( $hero_slider[ $i ]['bg'] ) ?>  )"> <?php
        echo "<{$hero_slide_title_tag} class='index-hero__title'>{$hero_slider[ $i ]['title']}</{$hero_slide_title_tag}>" ?>
        <p class="index-hero__descr"><?php echo $hero_slider[ $i ]['descr'] ?></p>
        <a href="<?php echo $hero_slider[ $i ]['link']['url'] ?>" class="index-hero__btn btn btn_blue"><?php echo $hero_slider[ $i ]['link']['title'] ?></a> <?php

        $hero_img = get_image_src( $hero_slider[ $i ]['img'] );

        if ( $hero_img ) : ?>
          <img src="#" alt="#" data-src="<?php echo $hero_img ?>" class="index-hero__img"> <?php
        endif ?>
      </div> <?php
      unset( $hero_img );
    endfor ?>
    <div class="index-hero__arrows"></div>
    <div class="index-hero__nav"></div>
  </section> <?php

endif ?>