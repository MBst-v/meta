<?php

function print_catalogue( $posts=null, $block_class=null, $is_slick=false ) {
  global $template_directory;
  // По умолчанию, все изображения будут lazyload
  $lazy = ' lazy';
  $img_src = 'src="#" data-src=';

  if ( $is_slick ) {
    $lazy = '';
    $img_src = 'src="#" data-lazy=';
  }

  if ( $_POST ) {
    // При пост-запросах отменяем lazyload
    $lazy = '';
    $img_src = 'src=';
  } else {
    foreach ( $posts as $post ) :
      // Название
      $post_title = get_the_title( $post );
      // Картинка или заглушка
      $post_thumb = get_the_post_thumbnail_url( $post );

      if ( !$post_thumb ) {
        $post_thumb = $template_directory . '/img/img-placeholder.svg';
      }
      // Формируем отрывок
      $post_excerpt = get_field( 'card_descr', $post );
      if ( !$post_excerpt ) {
        $post_excerpt = get_field( 'descr', $post );
      }
      $post_excerpt = get_excerpt( [
        'maxchar'   =>  100,
        'ignore_more' => true,
        'autop' => false,
        'text' =>  $post_excerpt
      ] );
      // url ссылки
      $permalink = get_the_permalink( $post );
      // Устанавливаем необходимый класс
      if ( $block_class ) {
        $product_class = $block_class . '__product product';
      } else {
        $product_class = 'product';
      };

      $img_attr = $img_src . '"' . $post_thumb .'"';

      if ( $is_post_query ) {
        $response .= '<a href="' . $permalink . '" class="' . $product_class . '">
        <img ' . $img_attr . ' alt="' . $post_title . '" class="product__img' . $lazy . '">
        <span class="product__title">' . $post_title . '</span>
        <p class="product__descr">' . $post_excerpt . '</p>
        <span class="product__link">Подробнее...</span>
      </a>';
      } else { ?>
        <a href="<?php echo $permalink ?>" class="<?php echo $product_class ?>">
          <img <?php echo $img_attr ?> alt="<?php echo $post_title ?>" class="product__img<?php echo $lazy ?>">
          <span class="product__title"><?php echo $post_title ?></span>
          <p class="product__descr"><?php echo $post_excerpt ?></p>
          <span class="product__link">Подробнее...</span>
        </a> <?php
      }
    endforeach;
  }

  if ( $_POST ) {
    die();
  }
}