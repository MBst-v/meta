<?
function the_breadcrumb( $settings ) {
 
  // получаем номер текущей страницы
  $pageNum = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
 
  $separator = ' / ';

  // создаем все переменые-аргументы
  $container_start = $settings['container_start'];
  $container_end = $settings['container_end'];
  $links_after = $settings['links_after'];
  $links_before = $settings['links_before'];
  $link_after = $settings['link_after'];
  $link_before = $settings['link_before'];
  $link_class = $settings['link_class'];
  $current_link_class = $settings['current_link_class'];
  $after_links = $settings['after_links'];       //  внутри контейнера и после ссылок
    // container > links + after_links

  if ( $link_class ) {
    $class = 'class="' . $link_class . '"';
  }


  // если главная страница сайта, то ничего не делаем
  if ( is_front_page() ) {
    return;

  } else { // если не главная страница, то создаем конейнер и т.д.

    // выводим начало тега общего контейнера для хлебных крошек
    if ( $container_start ) {
      echo $container_start;
    }
    // выводим начало тега контейнера только для списка крошек
    if ( $links_before ) {
      echo $links_before;
    }

    // выводим ссылку на главную страницу
    echo "{$link_before}<a href=' " . site_url() . " ' {$class}><span class='breadcrumbs__text'>Главная</span></a>{$link_after}";
    echo $separator;

    if (  is_single() ) { // если страница с сзаписью, то ищем ее категории
      $current_category = get_the_category()[0];
      $parent_category = get_term( $current_category->parent );

      // выводим оодительскую категорию
      if ( $parent_category ) {
        echo "{$link_before}<a href=' " . get_category_link( $parent_category ) . " ' {$class}><span class='breadcrumbs__text'>{$parent_category->name}</span></a>{$link_after}";
        echo $separator;
      }

      // выводим категорию
      echo "{$link_before}<a href=' " . get_category_link( $current_category ) . " ' {$class}><span class='breadcrumbs__text'>{$current_category->name}</span></a>{$link_after}";
      echo $separator;

      // выводим название статьи
      $class = 'class="' . $link_class . ' current"';
      echo "{$link_before}<a href='#' {$class}><span class='breadcrumbs__text'>" . get_the_title() . "</span></a>{$link_after}";

      // выводим закрывающий тег обертки-ссылок
      if ($links_after) {
        echo $links_after;
      }

      // выводим еще какой-то элемент
      if ( $after_links ) {
        echo $after_links;
      }
      
      // выводим закрывающий тег обертки
      if ( $container_end ) {
        echo $container_end;
      }
 
    } elseif ( is_page() ) { // если страница
      $current_page_id = get_post(0)->ID;
      $current_page_parents = get_ancestors( $current_page_id, 'page' );

      if ( $current_page_parents ) {  // если есть родительские страницы, то будем их выводить (кроме главной)
        foreach ( $current_page_parents as $parent_page_id ) {

          $page = get_post( $parent_page_id );
          $page_name = $page->post_name;  // index

          if ( $page_name !== 'index' ) {
            $page_title = $page->post_title;
            $page_link = get_permalink( $parent_page_id );

            echo "{$link_before}<a href='{$page_link}' $class>$page_title</a>{$link_after}";
          }
          
        }
      }

      if ( $current_link_class ) {
        $class = 'class="' . $link_class . ' ' . $current_link_class . '"';
      }

      echo "{$link_before}<a href='#' {$class}>" . get_the_title() . "</a>{$link_after}"; // выводим текущую страницу

      // выводим закрывающий тег обертки-ссылок
      if ( $links_after ) {
        echo $links_after;
      }

      // выводим еще какой-то элемент
      if ( $after_links ) {
        echo $after_links;
      }

      // выводим закрывающий тег обертки
      if ( $container_end ) {
        echo $container_end;
      }
 
    } elseif ( is_category() ) {  // если страница категории
      $current_category = get_category( get_query_var('cat') );
      $parent_category = get_term( $current_category->parent );

      // выводим категорию-родитель
      if ( ! is_wp_error( $parent_category ) ) {
        if ( is_category($parent_category) ) {
          $class = 'class="' . $link_class . ' current"';
        }
        echo "{$link_before}<a href='" . get_category_link( $parent_category ) . "' {$class}><span class='breadcrumbs__text'>{$parent_category->name}</span></a>{$link_after}";
      }

      // выводим категорию
      if ( is_wp_error( $parent_category ) || ! is_category($parent_category) ) {
        $class = 'class="' . $link_class . ' current"';
        echo "{$link_before}<a href='" . get_category_link( $current_category ) . "' {$class}><span class='breadcrumbs__text'>{$current_category->name}</span></a>{$link_after}";
      }

      // выводим закрывающий тег обертки-ссылок
      if ($links_after) {
        echo $links_after;
      }

      // выводим еще какой-то элемент
      if ($after_links) {
        echo $after_links;
      }

      // выводим закрывающий тег обертки
      if ($container_end) {
        echo $container_end;
      }
    }
  }
}