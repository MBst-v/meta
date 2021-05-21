<?php

$template_directory = get_template_directory_uri();
$template_dir = get_template_directory();
$site_url = site_url();

// Стиль для страницы, будет оперделяться в header.php
$page_style = null;

$address = get_option( 'contacts_address' );
$tel = get_option( 'contacts_tel' );
$tel_dry = preg_replace( '/\s/', '', $tel );
$tel_support = get_option( 'contacts_tel_support' );
$tel_support_dry = preg_replace( '/\s/', '', $tel_support );
$tel_marketing = get_option( 'contacts_tel_marketing' );
$tel_marketing_dry = preg_replace( '/\s/', '', $tel_marketing );
$tel_repair = get_option( 'contacts_tel_repair' );
$tel_repair_dry = preg_replace( '/\s/', '', $tel_repair );
$tel_design = get_option( 'contacts_tel_design' );
$tel_design_dry = preg_replace( '/\s/', '', $tel_design );
$email = get_option( 'contacts_email' );
$coords = get_option( 'contacts_coords' );
$zoom = get_option( 'contacts_zoom' );


add_filter( 'request', function( $query_string ) {

  if ( isset( $query_string['page'] ) ) {
    if ( '' != $query_string['page'] ) {
      if ( isset( $query_string['name'] ) ) {
        unset( $query_string['name'] );
      }
    }
  }
  return $query_string;
} );

add_action( 'pre_get_posts', function( $query ) {
  if ( $query->is_main_query() && !$query->is_feed() && !is_admin() ) {
    $query->set( 'paged', str_replace( '/', '', get_query_var( 'page' ) ) );
  }
} );


// Проверка поддержки webp браузером
if ( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false || strpos( $_SERVER['HTTP_USER_AGENT'], ' Chrome/' ) !== false ) {
  $is_webp_support = true; // webp поддерживается
} else {
  $is_webp_support = false; // webp не поддерживается
}


// Удаление разных скриптов и стилей от wp
// Отключаем гутенберг
// Отключаем emoji
// Отключаем весь css-файл CF7
// Отключаем генерацию некоторых лишнех тегов
require $template_dir . '/inc/disable-wp-scripts-and-styles.php';

// Регистрация новых типов записей и таксономий
require $template_dir . '/inc/register-post-and-tax.php';

// Дополнительные колонки у записей, оборудования и решений
require $template_dir . '/inc/posts-columns.php';

// Поддержки темой, настройка thumbnails
require $template_dir . '/inc/theme-support-and-thumbnails.php';

// Подключение стилей и скриптов, чистка лишнего в html-тегах, настройка атрибутов
require $template_dir . '/inc/enqueue-styles-and-scripts.php';

// Настройка доп. полей в панели настройки->общее
require $template_dir . '/inc/options-fields.php';

// Подключение и настройка меню, атрибутов, классов, id
require $template_dir . '/inc/menus.php';

// Заполнение acf полей, при создании товара
require $template_dir . '/inc/load-acf-repeater-fields.php';

// Функция формирования обрезанного текста
require $template_dir . '/inc/get-excerpt.php';

// Функция вывода товаров на страницу
require $template_dir . '/inc/print-catalogue.php';

// Разрешаем загрузку dwg
require $template_dir . '/inc/upload-dwg.php';

// Функции ajax-поиска
require $template_dir . '/inc/ajax-search.php';

// Функция вывода записей (новостей)
require $template_dir . '/inc/print-posts.php';

// Класс оборудвания/решения для удобства
require $template_dir . '/inc/class-product.php';

require $template_dir . '/inc/get-equipment-by-title.php';

// Шаги для онлайн-подбора
require $template_dir . '/inc/online-matching.php';

if ( is_super_admin() || is_admin_bar_showing() ) {
  // Функция иморта проектов из csv файла
  require $template_dir . '/inc/parseDown.php';
  require $template_dir . '/inc/import.php';
  // Функция вывода дополнительных параметров в админке
  // require $template_dir . '/inc/posts-columns.php';
}