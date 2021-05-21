<?php 
$post_datetime = get_the_date( 'Y-m-d' );
$post_date = get_the_date( 'd F Y' );
$post_thumbnail = get_the_post_thumbnail_url() ?>
<article class="article">
  <h1 class="article__title"><?php the_title() ?></h1>
  <time datetime="<?php echo $post_datetime ?>" class="article__date"><?php echo $post_date ?></time> <?php
  if ( $post_thumbnail ) : ?>
    <img src="<?php echo $post_thumbnail ?>" alt="" class="article__thumbnail"> <?php
  endif;
  the_content() ?>
</article> <?php
  $posts = get_posts( [
    'numberposts' => 3,
    'orderby' => 'rand',
    'exclude' => get_the_ID()
  ] );
  if ( $posts ) : ?>
  <section class="other-posts container">
    <h2 class="other-posts__title">Другие новости</h2>
    <div class="news"> <?php
      print_posts( $posts ) ?>
    </div>
  </section> <?php
  endif ?>