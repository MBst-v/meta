<section class="equipments-sect container">
  <h2 class="equipments-sect__title text_red"><?php echo $section['sect_title'] ?></h2>
  <div class="equipments"> <?php
    // Если категории установлены в админке вручную
    if ( $section['categories_by_user'] ) {
      $terms = $section['categories'];
    } else {
      // Иначе, все категории
      $terms = get_terms( [
        'taxonomy' => 'equipments',
        'hide_empty' => false,
        'meta_query' => [
          [
            'key' => 'cat_show_on_front_page',
            'value' => true
          ]
        ],
        'orderby' => 'meta_value_num',
        'meta_key' => 'cat_front_page_index'
      ] );
    }

    // Сортируем категории по индексу, установленному в админке
    usort( $terms, function( $a, $b ) {
      $a = get_field( 'cat_front_page_index', $a );
      $b = get_field( 'cat_front_page_index', $b );
      if ($a == $b) {
        return 0;
      };
      return ( $a < $b ) ? -1 : 1;
    } );

    // Окончания для вывода кол-ва
    $words = ['товар', 'товара', 'товаров'];

    // Выводим категории
    foreach ( $terms as $term ) :
      $i = $term->count;
      // Подбираем окончание кол-ва товаров
      $end = $words[($i % 100 > 4 && $i % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][($i % 10 < 5) ? $i % 10 : 5]];
      // Формируем строку кол-ва товаров
      $term_count = $i . ' ' . $end;
      $term_img = get_field( 'cat_img', $term ) ?>
      <a href="<?php echo get_term_link( $term ) ?>" class="equipment">
        <b class="equipment__title"><?php echo $term->name ?></b>
        <img src="#" alt="" data-src="<?php echo $term_img ?>" class="equipment__img lazy">
        <span class="equipment__count"><?php echo $term_count ?></span>
      </a> <?php
    endforeach ?>
    <a href="<?php echo $site_url ?>/equipments/" class="equipments__link"><span class="equipments__link-text">Весь</span><br> <span class="equipments__link-text">каталог</span></a>
  </div>
</section>