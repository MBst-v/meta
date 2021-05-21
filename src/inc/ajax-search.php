<?php

// Расширяем поиск по ACF полям
add_filter( 'posts_clauses', function( $clauses ){
  global $wpdb;

  if ( !$_POST['term'] ) {
    return $clauses;
  }

  $clauses['join'] .= " LEFT JOIN $wpdb->postmeta kmpm ON (ID = kmpm.post_id)";

  $clauses['where'] = preg_replace(
    "/OR +\( *$wpdb->posts.post_content +LIKE +('[^']+')/",
    "OR (kmpm.meta_value LIKE $1) $0",
    $clauses['where']
  );

  // Ищем в полях full_title и card_descr
  $clauses['where'] .= $wpdb->prepare(' AND kmpm.meta_key = %s', ['full_title', 'card_descr'] );

  $clauses['distinct'] = 'DISTINCT';

  0 && add_filter( 'posts_request', function( $sql ){   die( $sql );  } );

  return $clauses;
} );

function ajax_search() {
  global $template_directory;
  // Параметры поискового запроса
  $query = new WP_Query( [
    's' => $_POST['term'],
    'posts_per_page' => -1,
    'suppress_filters' => false
  ] );
  if ( $query->have_posts() ) :
    while ( $query->have_posts() ) :
      $query->the_post();
      $post_type = get_post_type();
      switch ( $post_type ) {
        case 'equipment':
          $post_type_ru = 'оборудование';
          break;
        case 'solution':
          $post_type_ru = 'решение';
          break;
        case 'page':
          $post_type_ru = 'страница';
          break;
        case 'post':
          $post_type_ru = 'новость';
          break;
        default:
          $post_type_ru = 'не&nbsp;определено';
          break;
      }
      // Формируем отрывок
      if ( $post_type === 'page') {
        $post_excerpt = 'Внутренняя страница сайта';
      } else {
        $post_excerpt = get_field( 'card_descr' );
        if ( !$post_excerpt ) {
          $post_excerpt = get_field( 'descr' );
        }
        $post_excerpt = get_excerpt( [
          'maxchar'   =>  100,
          'ignore_more' => true,
          'autop' => false,
          'text' =>  $post_excerpt
        ] );
      } ?>
      <a href="<?php the_permalink() ?>" class="search-result__item result-item"> <?php
        if ( has_post_thumbnail() ) : ?>
          <img src="<?php the_post_thumbnail_url() ?>" class="result-item__img" /> <?php
        else : ?>
          <img src="<?php echo $template_directory ?>/img/img-placeholder.svg" class="result-item__img" > <?php
        endif ?>
        <div class="result-item__text">
          <span class="result-item__title"><?php the_title() ?></span>
          <p class="result-item__descr"><?php echo $post_excerpt ?></p>
          <span class="result-item__type">Тип:&nbsp;<?php echo $post_type_ru ?></span>
        </div>
      </a> <?php
    endwhile;
  else : ?>
  <span class="search-result__not-found">Ничего не найдено</span> <?php
  endif;
  exit;
}

add_action( 'wp_ajax_nopriv_ajax_search', 'ajax_search' );
add_action( 'wp_ajax_ajax_search', 'ajax_search' );