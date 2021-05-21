<?php
  $numberposts = 9;
  $count_posts = wp_count_posts()->publish;
  $posts = get_posts( [
    'numberposts' => $numberposts
  ] );
  if ( $count_posts > $numberposts ) {
    $loadmore_attr = '';
  } else {
    $loadmore_attr = ' hidden';
  } ?>
<section class="news-sect sect" id="news-sect" data-posts-count="<?php echo $count_posts ?>" data-numberposts="<?php echo $numberposts ?>" data-page-uri="<?php the_permalink( $post ) ?>">
  <h1 class="news-sect__title">Новости компании</h1>
  <p class="news-sect__descr">Последние новости о&nbsp;нашей компании, индустрии и&nbsp;продукции.</p>
  <div class="news"> <?php
    if ( $posts ) {
      print_posts( $posts );
    } else {
      echo "<p class=\"news__not-found\">Записей не найдено</p>";
    } ?>
  </div>
  <button type="button" class="news-sect__loadmore loadmore" id="loadmore-btn"<?php echo $loadmore_attr ?>>Показать еще...</button>
</section>