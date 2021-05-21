<?php

$queried_taxonomy = get_queried_object();



if ( $queried_taxonomy->ID ) {
  $this_taxonomy = $queried_taxonomy->post_name; // equipments или solutions
  $this_taxonomy_id = $queried_taxonomy->ID;
  $this_taxonomy_slug = $this_taxonomy;
  $other_taxonomy = $this_taxonomy === 'equipments' ? 'solutions' : 'equipments';
  $this_post_type = substr( $this_taxonomy, 0, -1 ); // Отрезаем букву s на конце
} else {
  $this_taxonomy = $queried_taxonomy->taxonomy; // equipments или solutions
  $this_taxonomy_id = $queried_taxonomy->term_id;
  $this_taxonomy_slug = $queried_taxonomy->term_slug;
  $other_taxonomy = $this_taxonomy === 'equipments' ? 'solutions' : 'equipments';
  $this_post_type = substr( $this_taxonomy, 0, -1 ); // Отрезаем букву s на конце
}

$current_page = get_page_by_path( $this_taxonomy );


// $numberposts = 12;
// $numberposts = -1;
$tax_query = '';

$sect_fields = get_field( 'production_sect', $current_page->ID );
$sect_title = $sect_fields['sect_title'];
$sect_descr = $sect_fields['sect_descr'];

// Таксономии, которые относятся к текущей странице (equipments или solutions)

$this_page_terms = get_terms( [
  'taxonomy' => $this_taxonomy,
  'meta_query' => [
    [
      'key' => 'cat_show_in_filter',
      'value' => true
    ]
  ],
  'orderby' => 'meta_value_num',
  'meta_key' => 'cat_filter_index'
] );

// получаем данные о выбранной категории
if ( $this_taxonomy_slug === $this_taxonomy ) {
  $tax_query = '';
  $posts_count = (int)wp_count_posts( $this_post_type )->publish;
} else {
  $tax_query = [
    [
      'taxonomy' => $this_taxonomy,
      'terms'    => [$this_taxonomy_id]
    ]
  ];

  $term = get_term( $this_taxonomy_id );

  $sect_title = $term->name;

  if ( $term->description ) {
    $sect_descr = $term->description;
  }

  $posts_count = $term->count;
}

// $loadmore_hidden_class = $numberposts > $posts_count ? ' hidden' : '';

if ( $wp_query->query['paged'] ) {
  $paged = $wp_query->query['paged'];
} else if ( get_query_var( 'paged' ) ) {
$paged = get_query_var( 'paged' );
} else {
  $paged = 1;
}

// Записи для текущей категории
$the_query = new WP_Query( [
  'post_type' => $this_post_type,
  'paged' => $paged,
  'tax_query' => $tax_query,
  'meta_key' => 'index',
  'orderby'  => [ 'meta_value_num' => 'ASC' ]
] ) ?>

<section class="production container">
  <div class="production__filter popup" id="filter">
    <div class="filter__cnt">
      <button type="button" class="filter__close">
        <svg class="filter__close-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <line x1="1.06066" y1="1.93934" x2="22.0607" y2="22.9393" stroke="currentColor" stroke-width="3"/>
          <line x1="1.93934" y1="22.9393" x2="22.9393" y2="1.93934" stroke="currentColor" stroke-width="3"/>
        </svg>
      </button>
      <span class="filter__title">Фильтр</span>
      <div class="filter__buttons">
        <a href="<?php echo $site_url ?>/equipments/" class="filter__parent-category-link<?php echo $this_taxonomy === 'equipments' ? ' current' : '' ?>">Оборудование</a>
        <a href="<?php echo $site_url ?>/solutions/" class="filter__parent-category-link<?php echo $this_taxonomy === 'solutions' ? ' current' : '' ?>">Решения</a>
      </div>
      <div class="filter__categories">
        <div class="filter__category">
          <a href="<?php echo $site_url . '/' . $this_taxonomy ?>/" class="filter__link<?php echo $this_taxonomy === $this_taxonomy_slug ? ' current' : '' ?>"><?php echo $this_taxonomy === 'equipments' ? 'Все оборудование' : 'Все решения' ?></a> <?php
            foreach ( $this_page_terms as $term ) : ?>
              <a href="<?php echo get_term_link( $term->term_id ) ?>" class="filter__link<?php echo $this_taxonomy !== $this_taxonomy_slug && $this_taxonomy_id === $term->term_id ? ' current' : '' ?>"><?php echo $term->name . '&nbsp;(' . $term->count . ')' ?></a> <?php
            endforeach ?>
        </div>
      </div>
    </div>
  </div>
  <div class="production__catalogue-wrap">
    <h1 class="production__title text_red"><?php echo $sect_title ?></h1> <?php
    if ( $sect_descr ) : ?>
      <p class="production__descr"><?php echo $sect_descr ?></p> <?php
    endif ?>
    <button type="button" id="filter-open-btn">Фильтр</button>
    <div class="production__catalogue <?php echo $this_taxonomy_slug ?>"> <?php
    // Вывод продуктов каталога с классом 'production__product product'
     print_catalogue( $the_query->posts, 'production' ) ?>
    </div>
    <nav class="production__pagination"> <?php
    $pagination_prev_arrow = '<svg class="page-numbers-arrow" width="7" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 12L1 6.5 6.5 1" stroke="currentColor"/></svg>';

    $pagination_next_arrow = '<svg class="page-numbers-arrow" width="8" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1l5.5 5.5L1 12" stroke="currentColor"/></svg>';

    $paginate = paginate_links( [
      'base' => '%_%',
      'format' => '?paged=%#%',
      'current' => max( 1, $paged ),
      'total' => $the_query->max_num_pages,
      'prev_text'    => __( $pagination_prev_arrow . 'Назад' ),
      'next_text'    => __( 'Дальше' . $pagination_next_arrow )
    ] );

    // Иногда создаются ссылки с пустыми href. Подстваим им нужную ссылку.
    $paginate = preg_replace_callback ( '/href="">(?<num>[0-9])/', function( $matches ) {
      return 'href="?paged=' . $matches['num'] . '">' . $matches['num'];
    }, $paginate );

    echo $paginate ?>

    </nav>
  </div>
  <!-- <button type="button" class="production__loadmore<?php #echo $loadmore_hidden_class ?>" id="loadmore">Показать еще...</button> -->
</section>