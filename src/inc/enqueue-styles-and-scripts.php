<?php

// Функция подключения стилей
function enqueue_style( $style_name, $widths ) {
  global $template_directory;

  if ( is_string( $widths ) ) {
    if ( $style_name === 'hover' ) {
      wp_enqueue_style( "{$style_name}", $template_directory . "/css/{$style_name}.css", [], null, "(hover), (min-width:1024px)" );
    } else {
      wp_enqueue_style( "{$style_name}", $template_directory . "/css/{$style_name}.css", [], null );
    }
  } else {
    foreach ( $widths as $width ) {
      if ( $width !== "0" ) {
        $media = $width - 0.02;
         // если размер файла равен 0, то не подключаем его
        if ( filesize( get_template_directory() . '/css/' . $style_name . '.' . $width . '.css' ) === 0 ) {
          continue;
        }
        wp_enqueue_style( "{$style_name}-{$width}px", $template_directory . "/css/{$style_name}.{$width}.css", [], null, "(min-width: {$media}px)" );
      } else {
        wp_enqueue_style( "{$style_name}-page", $template_directory . "/css/{$style_name}.css", [], null );
      }
    }
  }
}

// Подключаем свои стили и скрипты
add_action( 'wp_enqueue_scripts', function() {
  global $template_directory, $page_style;
  $screen_widths = ['0', '420', '576', '768', '1024', '1240']; // на каких экранах подключать css

  wp_enqueue_style( 'theme-style', get_stylesheet_uri(), [], null );        // подключить стиль темы (default)

  // подключаем стили с помощью своей функции
  enqueue_style( 'style', $screen_widths );

  // Стиль для конкретной страницы (определяется в header.php)
  if ( $page_style ) {
    enqueue_style( $page_style, $screen_widths );
    wp_enqueue_script( "fancybox.min", $template_directory . "/js/fancybox.min.js", [], null );
  }

  if ( is_singular( ['equipment', 'solution'] ) || is_page( 'online-matching' ) ) {
    wp_enqueue_style( "fancybox", $template_directory . "/css/fancybox.min.css", [], null ); 
  }

  enqueue_style( 'hover', '' ); // подключаем стили для эффектов при наведении

  // Подключаем скрипты циклом
  $scripts = [
    // 'dompurify',
    // 'html2canvas.min',
    // 'jspdf.min',
		'slick.min',
		'lazy.min',
		'Popup.min',
		'svg4everybody.min',
    'fancybox.min',
    'tail.select.min',
		'main'
	];

  foreach ( $scripts as $script_name ) {
    wp_enqueue_script( "{$script_name}", $template_directory . "/js/{$script_name}.js", [], null );
  }

  // Отключаем стандартные jquery, jquery-migrate
  // лучше подключать свой jquery
  wp_deregister_script( 'jquery-core' );
  wp_deregister_script( 'jquery' );

  // Подключаем свой jquery 3.5.1
  wp_register_script( 'jquery-core', $template_directory . '/js/jquery.js', false, null, true );
  wp_register_script( 'jquery', false, ['jquery-core'], null, true );
  wp_enqueue_script( 'jquery' );

  if ( !is_singular( 'post' ) && !is_super_admin() && !is_admin_bar_showing() ) {
    wp_deregister_style( 'wp-block-library' );
  }

  // if ( !is_super_admin() && !is_admin_bar_showing() ) {
    // wp_deregister_script( 'wp-api-fetch' );
  // }

} );

// Убираем id и type в тегах script, добавляем нужным атрибут defer
  add_filter( 'script_loader_tag',   function( $html, $handle ) {

    // if ( !is_super_admin() && !is_admin_bar_showing() ) {
    //   switch ( $handle ) {
    //     case '':
    //     case 'wp-polyfill':
    //     case 'wp-hooks':
    //     case 'wp-i18n':
    //     case 'lodash':
    //     case 'wp-url':
    //     case 'wp-api-fetch':
    //       return '';
    //   }
    // }

    // var_dump( $handle );

    $defer_scripts = [
      // 'dompurify',
      // 'html2canvas.min',
      // 'jspdf.min',
			'slick.min',
			'lazy.min',
			'Popup.min',
			'svg4everybody.min',
      'fancybox.min',
      'tail.select.min',
      // 'wp-polyfill',
      // 'wp-hooks',
      // 'wp-i18n',
      // 'lodash',
      // 'wp-url',
      // 'wp-api-fetch',
			'main'
		];

    foreach( $defer_scripts as $id ) {
      if ( $id === $handle ) {
        $html = str_replace( ' src', ' defer src', $html );
      }
    }

    $html = str_replace( " id='$handle-js'", '', $html );
    $html = str_replace( " type='text/javascript'", '', $html );

     return $html;
  }, 10, 2);

// Убираем id и type в тегах style
  add_filter( 'style_loader_tag', function( $html, $handle ) {
    // Подключаем стили гутенберга только в админке
    if ( $handle === 'dnd-upload-cf7'/* || (!is_singular( 'post' ) && !is_admin()) && $handle === 'wp-block-library'*/ ) {
      return '';
    }
    $html = str_replace( " id='$handle-css' ", '', $html );
    $html = str_replace( " type='text/css'", '', $html );
    return $html;
  }, 10, 2 );