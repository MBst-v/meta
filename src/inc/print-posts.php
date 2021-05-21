<?php
if ( isset( $_POST ) && $_POST['action'] === 'print_posts' ) {
  add_action( 'wp_ajax_nopriv_print_posts', 'print_posts' ); 
  add_action( 'wp_ajax_print_posts', 'print_posts' );

  $posts = get_posts( [
    'numberposts' => $_POST['numberposts'],
    'offset' => $_POST['offset']
  ] );
  print_posts( $posts );
}

function print_posts( $posts=null ) {
  global $post, $template_directory;

  foreach ( $posts as $post )  :
    setup_postdata( $post );
    $post_excerpt = get_excerpt( [
      'maxchar'   =>  120,
      'autop' => false,
      'ignore_more' => true
    ] );
    $post_href = get_the_permalink();
    $post_datetime = get_the_date( 'Y-m-d' );
    $post_date = get_the_date( 'd F Y' ) ?><a href="<?php echo $post_href ?>" class="post"> <?php
      if ( has_post_thumbnail() ) : ?>
        <img src="<?php the_post_thumbnail_url() ?>" alt="" class="post__img"> <?php
      else : ?>
        <img src="<?php echo $template_directory ?>/img/img-placeholder.svg" class="post__img" /> <?php
      endif ?>
      <span class="post__title"><?php the_title() ?></span>
      <p class="post__descr"><?php echo $post_excerpt ?></p>
      <time datetime="<?php echo $post_datetime ?>" class="post__date"><?php echo $post_date ?></time>
      <span class="post__more">Подробнее...</span>
    </a><?php
  endforeach;
  unset( $post_datetime );
  unset( $post_date );
  unset( $post_excerpt );
  if ( isset( $_POST ) && $_POST['action'] === 'print_posts' ) {
    die();
  }
}