<?php

add_filter( 'post_type_link', function( $permalink, $post ) {

  // Если нет шаблона %equipments% или %solutions%, то возвращаем ссылку
  if ( strpos( $permalink, '%equipments%' ) !== FALSE ) {
    $tax = 'equipments';
  } else if ( strpos( $permalink, '%solutions%' ) !== FALSE ) {
    $tax = 'solutions';
  } else {
    return $permalink;
  }

  // получаем элементы таксономии
  $taxonomies = get_the_terms( $post, $tax );
  // Берем первый элемент
  if( ! is_wp_error( $taxonomies ) && !empty( $taxonomies ) && is_object( $taxonomies[0] ) )
    $taxonomy_slug = $taxonomies[0]->slug;
  else {
    $taxonomy_slug = 'no-category';
  }

  return str_replace( '%'. $tax . '%', $taxonomy_slug, $permalink );
} , 1, 2 );


add_action( 'init', function() {

  // Новый тип записи - оборудование (одиночный товар)
  register_post_type( 'equipment', [
    'label'  => null,
    'labels' => [
      'name'               => 'Оборудование',
      'singular_name'      => 'Оборудование',
      'add_new'            => 'Добавить',
      'add_new_item'       => 'Добавление',
      'edit_item'          => 'Редактирование',
      'new_item'           => 'Новое ',
      'view_item'          => 'Смотреть',
      'search_items'       => 'Искать',
      'not_found'          => 'Не найдено',
      'not_found_in_trash' => 'Не найдено в корзине',
      'parent_item_colon'  => '',
      'menu_name'          => 'Оборудование',
    ],
    'description'         => '',
    'public'              => true,
    'show_in_menu'        => null,
    'show_in_rest'        => null,
    'rest_base'           => null,
    'menu_position'       => null,
    'menu_icon'           => null,
    'hierarchical'        => false,
    'supports'            => [ 'title', 'thumbnail' ],
    'taxonomies'          => [ 'equipments' ],
    'exclude_from_search' => false,
    'has_archive' => true,
    'rewrite' => [
      'slug' => 'equipments/%equipments%',
      'with_front' => true,
      'pages' => false
    ],
    'query_var' => false
  ] );

  // Новый тип записи - решения (группа товаров)
  register_post_type( 'solution', [
    'label'  => null,
    'labels' => [
      'name'               => 'Решения',
      'singular_name'      => 'Решение',
      'add_new'            => 'Добавить',
      'add_new_item'       => 'Добавление',
      'edit_item'          => 'Редактирование',
      'new_item'           => 'Новое ',
      'view_item'          => 'Смотреть',
      'search_items'       => 'Искать',
      'not_found'          => 'Не найдено',
      'not_found_in_trash' => 'Не найдено в корзине',
      'parent_item_colon'  => '',
      'menu_name'          => 'Решения',
    ],
    'description'         => '',
    'public'              => true,
    'show_in_menu'        => null,
    'show_in_rest'        => null,
    'rest_base'           => null,
    'menu_position'       => null,
    'menu_icon'           => null,
    'hierarchical'        => false,
    'supports'            => [ 'title', 'thumbnail' ],
    'taxonomies'          => [ 'solutions' ],
    // 'has_archive'         => false,
    'rewrite'             => [
      'slug' => 'solutions/%solutions%',
      'with_front' => false
    ],
    // 'query_var'           => true
  ] );

  // Категории товаров для решений
  register_taxonomy( 'solutions', ['solution'], [
    'label'                 => '',
    'labels'                => [
      'name'              => 'Категории',
      'singular_name'     => 'Категория',
      'search_items'      => 'Найти',
      'all_items'         => 'Все',
      'view_item '        => 'Показать',
      'parent_item'       => 'Родитель',
      'parent_item_colon' => 'Родитель:',
      'edit_item'         => 'Изменить',
      'update_item'       => 'Обносить',
      'add_new_item'      => 'Добавить',
      'new_item_name'     => 'Добавить',
      'menu_name'         => 'Категории',
    ],
    'hierarchical'          => true,
    'meta_box_cb'           => false
  ] );
  
  // Категории товаров для оборудования
  register_taxonomy( 'equipments', ['equipment'], [
    'label'                 => '',
    'labels'                => [
      'name'              => 'Категории',
      'singular_name'     => 'Категория',
      'search_items'      => 'Найти',
      'all_items'         => 'Все',
      'view_item '        => 'Показать',
      'parent_item'       => 'Родитель',
      'parent_item_colon' => 'Родитель:',
      'edit_item'         => 'Изменить',
      'update_item'       => 'Обносить',
      'add_new_item'      => 'Добавить',
      'new_item_name'     => 'Добавить',
      'menu_name'         => 'Категории',
    ],
    'hierarchical'          => true,
    'meta_box_cb'           => false
  ] );

  // Партнеры (то есть клиенты), которые можно вывести на страницах
  register_taxonomy( 'partners', ['page'], [
    'label'                 => '',
    'labels'                => [
      'name'              => 'Клиенты',
      'singular_name'     => 'Клиент',
      'search_items'      => 'Найти',
      'all_items'         => 'Все',
      'view_item '        => 'Показать',
      'parent_item'       => 'Родитель',
      'parent_item_colon' => 'Родитель:',
      'edit_item'         => 'Изменить',
      'update_item'       => 'Обносить',
      'add_new_item'      => 'Добавить',
      'new_item_name'     => 'Добавить',
      'menu_name'         => 'Клиенты',
    ],
    'hierarchical'          => false,
    'meta_box_cb'           => false
  ] );

});

