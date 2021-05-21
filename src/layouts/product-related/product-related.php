<?php
$products = get_posts( [
  'numberposts' => 4,
  'post_type' => $post_type,
  'orderby' => 'rand',
  'exclude' => $post->ID
] );
if ( $products ) : ?>
  <section class="related-products container">
    <h2 class="related-products__title text_red">Другие товары</h2>
    <a href="<?php echo $site_url ?>/equipments/" class="related-products__link link">Все товары</a>
    <div class="related-products__wrap"> <?php
    // Вывод продуктов каталога с классом 'related-products__product product'
      print_catalogue( $products, 'related-products' ) ?>
    </div>
  </section> <?php
endif ?>