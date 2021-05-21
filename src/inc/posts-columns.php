<?php

function manage_columns( $columns ) {
  $num = 1; // после какой по счету колонки вставлять новые

  $new_columns = [
    'title' => 'Название',
    'thumbnail' => 'Миниатюра',
    'modified' => 'Дата изменения',
    'date' => 'Дата публикации'
  ];

  return array_slice($columns, 0, $num) + $new_columns + array_slice($columns, $num);
}

function namage_custom_column( $colname, $post_id ) {
  $post_type = get_post_type( $post_id );

  switch ( $colname ) {
    case 'thumbnail':
      echo '<img src="' . get_the_post_thumbnail_url( $post_id ) . '" style="object-fit:contain;width:75px;height:75px">';
      break;
    case 'title':
      echo '<p>' . get_the_title( $post_id ) . '</p>';
      break;
    case 'modified':
      echo '<p>Изменено<br>' . get_the_modified_date( 'd.m.Y, G:i' ) . '</p>';
      break;
  }
}

function namage_sortable_columns( $sortable_columns ) {
  $sortable_columns['modified'] = ['modified_modified', false];
  return $sortable_columns;
}

// Создание новых колонок
add_filter( 'manage_equipment_posts_columns', 'manage_columns', 4 );
add_filter( 'manage_solution_posts_columns', 'manage_columns', 4 );

// Заполнение колонок нужными данными
add_action( 'manage_equipment_posts_custom_column', 'namage_custom_column', 5, 2);
add_action( 'manage_solution_posts_custom_column', 'namage_custom_column', 5, 2);

// добавляем возможность сортировать колонку
add_filter( 'manage_edit-equipment_sortable_columns', 'namage_sortable_columns' );
add_filter( 'manage_edit-solution_sortable_columns', 'namage_sortable_columns' );