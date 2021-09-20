<?php

function print_catalogue( $posts=null, $block_class=null, $is_slick=false ) {
  global $template_directory;
  // По умолчанию, все изображения будут lazyload
  $lazy = ' lazy';
  $img_src = 'src="#" data-src="';
  $source_src = 'srcset="#" data-srcset="';

  if ( $is_slick ) {
    $lazy = '';
    $img_src = 'src="#" data-lazy="';
    $source_src = 'srcset="#" data-lazy="';
  }

  if ( $_POST ) {
    // При пост-запросах отменяем lazyload
    $lazy = '';
    $img_src = 'src="';
    $source_src = 'srcset="';
  } else {
    foreach ( $posts as $post ) :
      // Название
      $post_title = get_the_title( $post );
      // Картинка или заглушка
      $post_thumb = get_the_post_thumbnail_url( $post );
      $post_thumb_id = get_post_thumbnail_id( $post );
      $card_thumb = wp_get_attachment_image_src( $post_thumb_id, 'card_thumbnail' )[0];

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

      $img_attr = $img_src . $post_thumb .'"';
      if ( $card_thumb ) {
        $source_attr = $source_src . $card_thumb . '"';
      }

      if ( $is_post_query ) {
        $response .= '<a href="' . $permalink . '" class="' . $product_class . '">
        <picture class="product__pic' . $lazy . '">';
        if ( $card_thumb ) {
          $response .= '<source type="image/jpeg" ' . $source_attr . '>';
        }
        $response .= '<img ' . $img_attr . ' alt="' . $post_title . '" class="product__img">';
        if ( $card_thumb ) {
          $response .= '</picture>';
        }
        $response .= '<span class="product__title">' . $post_title . '</span>
        <p class="product__descr">' . $post_excerpt . '</p>
        <span class="product__link">Подробнее...</span>
      </a>';
      } else { ?>
        <a href="<?php echo $permalink ?>" class="<?php echo $product_class ?>">
          <picture class="product__pic<?php echo $lazy ?>"> <?php
            if ( $card_thumb ) : ?>
              <source type="image/jpeg" <?php echo $source_attr ?>> <?php
            endif ?>
            <img <?php echo $img_attr ?> alt="<?php echo $post_title ?>" class="product__img">
          </picture>
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