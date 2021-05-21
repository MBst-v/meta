<?php

$equipments_page_name = 'equipments';
$solutions_page_name = 'solutions';

$this_page_name = $post->post_name; // Имя страницы (equipmentS или solutionS)
$this_page_type = substr( $this_page_name, 0, -1 ); // Имя типа записи (equipment или solution)
$this_category_type = $this_page_type . '_category'; // Имя категории (equipment_category или solution_category)

$other_page_name = $this_page_name === 'equipments' ? 'solutions' : 'equipments';
$other_page_type = substr( $other_page_name, 0, -1 );
$other_category_type = $other_page_type . '_category';

// $numberposts = 12;
$numberposts = -1;
$tax_query = '';

$sect_fields = get_field( 'production_sect' );
$sect_title = $sect_fields['sect_title'];
$sect_descr = $sect_fields['sect_descr'];

$first_btn_current_class = $this_page_name === 'equipments' ? ' is-active' : '';
$second_btn_current_class = $this_page_name === 'solutions' ? ' is-active' : '';


if ( isset( $_GET ) && $_GET['cat'] ) {
  $tax_query = [
    [
      'taxonomy' => $this_category_type,
      'terms' => $_GET['cat']
    ]
  ];

  $term = get_term( $_GET['cat'] );

  $sect_title = $term->name;

  if ( $term->description ) {
    $sect_descr = $term->description;
  }

  $posts_count = $term->count;
} else {
  $posts_count = (int)wp_count_posts( $this_page_type )->publish;
}

$loadmore_hidden_class = $numberposts > $posts_count ? ' hidden' : '';

// Таксономии, относящиеся к текущей странице (оборудования или решения)
$equipments_terms = get_terms( [
  'taxonomy' => 'equipment_category',
  'hide_empty' => false,
  'meta_key' => 'cat_show_in_filter',
  'meta_value' => true
] );

// Запрашиваем другие таксономии (для переключателя в фильтре)
$solutions_terms = get_terms( [
  'taxonomy' => 'solution_category',
  'hide_empty' => false,
  'meta_key' => 'cat_show_in_filter',
  'meta_value' => true
] );

// Записи для текущей категории
$posts = get_posts( [
  'post_type' => $this_page_type,
  'numberposts' => $numberposts,
  'tax_query' => $tax_query
] ) ?>

<section class="production container">
  <div class="production__filter popup" id="filter">
    <div class="filter__cnt">
      <img src="#" alt="" data-src="<?php echo $template_directory ?>/img/icon-close.svg" class="filter__close lazy">
      <span class="filter__title">Фильтр</span>
      <div class="filter__buttons" role="tablist">
        <button type="button" class="filter__switch-btn<?php echo $first_btn_current_class ?>" aria-selected="<?php echo $equipments_btn_aria ?>" id="tab-1" tabindex="<?php echo $equipments_btn_tabindex ?>" role="tab" aria-controls="panel-1">Оборудование</button>
        <button type="button" class="filter__switch-btn<?php echo $second_btn_current_class ?>" aria-selected="<?php echo $solutions_btn_aria ?>" id="tab-2" tabindex="<?php echo $solutions_btn_tabindex ?>" role="tab" aria-controls="panel-2">Решения</button>
      </div>
      <div class="filter__categories">
        <div class="filter__category<?php echo $first_btn_current_class ?>" id="panel-1" role="tabpanel" tabindex="<?php echo $equipments_btn_tabindex ?>" aria-hidden="<?php echo $solutions_btn_aria ?>"> <?php
          if ( $this_page_name === 'equipments' && isset( $_GET ) && !$_GET['cat'] ) {
            $current_class = ' current';
          } else {
            $current_class = '';
          } ?>
          <a href="<?php echo $site_url . '/' . $equipments_page_name ?>" class="filter__link<?php echo $current_class ?>">Все оборудование</a> <?php
          foreach ( $equipments_terms as $term ) :
            if ( $this_page_name === 'equipments' && isset( $_GET ) && $_GET['cat'] == $term->term_id ) {
              $current_class = ' current';
            } else {
              $current_class = '';
            } ?>
            <a href="<?php echo $site_url . '/' . $equipments_page_name . '/?cat=' . $term->term_id ?>" class="filter__link<?php echo $current_class ?>"><?php echo $term->name . '&nbsp;(' . $term->count . ')' ?></a> <?php
          endforeach ?>
        </div>
        <div class="filter__category<?php echo $second_btn_current_class ?>" id="panel-2" role="tabpanel" tabindex="<?php echo $solutions_btn_tabindex ?>" aria-hidden="<?php echo $equipments_btn_aria ?>"> <?php
          if ( $this_page_name === 'solutions' && isset( $_GET ) && !$_GET['cat'] ) {
            $current_class = ' current';
          } else {
            $current_class = '';
          } ?>
          <a href="<?php echo $site_url . '/' . $solutions_page_name ?>" class="filter__link<?php echo $current_class ?>">Все решения</a> <?php
          foreach ( $solutions_terms as $term ) : 
            if ( $this_page_name === 'solutions' && isset( $_GET ) && $_GET['cat'] == $term->term_id ) {
              $current_class = ' current';
            } else {
              $current_class = '';
            } ?>
            <a href="<?php echo $site_url . '/' . $solutions_page_name . '/?cat=' . $term->term_id ?>" class="filter__link<?php echo $current_class ?>"><?php echo $term->name ?></a> <?php
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
    <div class="production__catalogue"> <?php
    // Вывод продуктов каталога с классом 'production__product product'
     print_catalogue( $posts, 'production' ) ?>
    </div>
  </div>
  <!-- <button type="button" class="production__loadmore<?php #echo $loadmore_hidden_class ?>" id="loadmore">Показать еще...</button> -->
</section>