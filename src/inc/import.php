<?php
// Добавляем кнопку для импорта в админ панель
add_action( 'admin_bar_menu', function() {
  global $wp_admin_bar;
  $wp_admin_bar->add_menu( [
    'id'    => 'import-btn',
    'title' => __('Импорт товаров'),
    'href'  => ''
  ] );
}, 100 );

add_action( 'wp_ajax_nopriv_import', 'import' ); 
add_action( 'wp_ajax_import', 'import' );

$parsedown = new Parsedown();

function remove_spaces( $input ) {
  $output = str_replace( "\"\n\"", "\",\"", $input );
  $output = str_replace( ["\r\n", "\r", "\n", "\t"], '', $output );
  return $output;
}

// Делаем первую букву заглавной
function my_mb_ucfirst( $str ) {
  $fc = mb_strtoupper( mb_substr( $str, 0, 1 ) );
  return $fc . mb_substr( $str, 1 );
}

// Будем приводить текст в красивый html
function beautify_text( $text=null ) {
  if ( $text ) {
    // Уюираем незапланированые разрывы строк между словами
    $text = preg_replace( '/(?<=[аА-яЯ])\s*\n\s*(?=[аА-яЯ])/', ' ', $text );
    // Убираем лишние переносы строк после запятых и после запятых с пробелом
    $text = preg_replace('/,\s*\n/', ', ', $text );
    // Добавляем пробелы после затяпых
    $text = preg_replace( '/,(?!\s)/', ', ', $text );
    // Добавляем пробелы после сокразений пункт п.
    $text = preg_replace( '/\sп\.(?!\s)/', ' п.&nbsp;', $text );
    // Добавляем неразрывный пробел после исп.
    $text = preg_replace( '/\sисп\.\s?(?=[аАaA-яЯzZ])/', ' исп.&nbsp;', $text );
    // Заменяем все обычные дефисы на неразрывные
    $text = preg_replace( '/-/', '&#8209;', $text );
    // Неразрывные пробелы перед союзами
    $text = preg_replace( '/(?<=\s)(и|с|для|под|при|от|по|а|из|в|у|не|на|к|из)\s/', '$1&nbsp;', $text );
    // Ставим неразрывные пробелы после ГОСТ
    $text = preg_replace( '/(ГОСТ)\s?/', '$1&nbsp;', $text );
    // Ставим неразрывные пробелы после Р
    $text = preg_replace( '/(?<=\s)(Р)\s?/', '$1&nbsp;', $text );
    // Ставим неразрывные пробелы после СП
    $text = preg_replace( '/(СП)\s?/', '$1&nbsp;', $text );
    // Ставим неразрывный пробел после МЕТА..., за которой идут цифры
    $text = preg_replace( '/(МЕТА)\s?(?=[0-9])/', '$1&nbsp;', $text );
    // Ставим неразрывный пробел после Р (ГОСТ Р ...)
    $text = preg_replace( '/(Р)\s(?=[0-9])/', '$1&nbsp;', $text );
    // Ставим знак градуса
    $text = preg_replace( '//', '°', $text );
    return $text;
  }
}

function beautify_product_title( $text ) {
  if ( $text ) {
    $text = preg_replace( '/\sисп\.\s?(?=[аАaA-яЯzZ])/', ' исп.&nbsp;', $text );
    if ( $text === 'МЕТА 3522 - 6_10_14' ) {
      $text = str_replace( '_', '/', $text );
    }
    return $text;
  }
}

function import() {
  if ( isset( $_FILES['csv'] ) ) {

    error_reporting( E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED );
    ini_set( 'display_errors', 1 );

    $products = csv_to_array( $_FILES['csv']['tmp_name'] );
    $site_path = get_home_path(); // ../../meta/
    $post_type = $_POST['post_type'];
    // $numberposts = $_POST['numberposts'];
    $offset = $_POST['offset'];

    // Получаем уже существующее оборудование для сравнения
    $exists_products = get_posts( [
      'post_type' => $post_type,
      'numberposts' => -1
    ] );

    $exists_categories = get_terms( [
      'taxonomy' => $post_type . 's',
      'hide_empty' => false
    ] );

    $i = 0;
    $products = array_slice( $products, $offset );
    $uploaded_posts = [];
    $updated_posts = [];

    // var_dump( $products );
    // die();
    foreach ( $products as $product ) {
      $product_title = trim( $product['Название'] );

      // if ( $product_title !== 'МЕТА 3522 - 6/10/14' ) {
      //   continue;
      // } else {
      //   $product_title = str_replace( '/', '_', $product_title );
      // }


      // Ищем папку с файлами
      // Сначала обычный вариант, как в таблице
      $product_directory = $site_path . 'assets/Оборудование Мета/' . $product_title;

      // Затем вариант с uppercase
      if ( !file_exists( $product_directory ) ) {
        $product_directory = $site_path . 'assets/Оборудование Мета/' . mb_strtoupper( $product_title );
      }
      // Затем вариант с lowercase
      if ( !file_exists( $product_directory ) ) {
        $product_directory = $site_path . 'assets/Оборудование Мета/' . mb_strtolower( $product_title );
      }
      // Затем вариант с большой первой буквой
      if ( !file_exists( $product_directory ) ) {
        $product_directory = $site_path . 'assets/Оборудование Мета/' . my_mb_ucfirst( $product_title );
      }

      // Если папка не найдена, то записываем в ответ
      if ( !file_exists( $product_directory ) ) {
        $response['not_found'][] = $product_directory;
        continue;
      }

      $product_files = parse_product_files( $product_directory );

      $product_ACF_fields = parse_data_for_ACF_fields( $product, $exists_categories, $product_files );

      // Ищем продукт в существующих на сайте записях и если найден, то чистим метаполя и медиафайлы
      $exist_product_id = check_and_clear_product( $exists_products, $product_title );


      // Если запись обновлена, то записываем респонс и идем дальше
      if ( $exist_product_id ) {

        // Обновляем запись (в основном для заголовка)
        // $post_data = [
        //   'ID'              => $exist_product_id,
        //   'post_title'      => beautify_product_title( $product_title ),
        //   'post_type'       => $post_type,
        //   'post_content'    => '',
        //   'post_status'     => 'publish',
        //   'post_author'     => 1,
        //   'post_category'   => []
        // ];

        // wp_insert_post( $post_data );

        // Заполним все поля у записи заново, вставим все документы и картинки
        $uloaded_files = fill_fields( $exist_product_id, $product_title, $product_ACF_fields, null, $product_files );

        // $uloaded_files['table'] = $product_files['props_table'];

        // Ставим таксономии
        // wp_set_post_terms( $exist_product_id, $product_ACF_fields['categories_ids'], 'equipments' );

        $updated_posts[] = [
          'id' => $exist_product_id,
          'Название' => beautify_product_title( $product_title ),
          'Распознанные категории' => [
            'names' => $product_ACF_fields['categories_names'],
            'ids' => $product_ACF_fields['categories_ids']
          ],
          'Файлы' => $uloaded_files
        ];

        // var_dump('Обновляю');

        // Иначе будем создавать новую запись
      } else {
        continue;
        // var_dump('Добавляю');
        // Данные записи


        $post_data = [
          'post_title'      => beautify_product_title( $product_title ),
          'post_type'       => $post_type,
          'post_content'    => '',
          'post_status'     => 'publish',
          'post_author'     => 1,
          // Категории будем добавлять через ACF
          'post_category'   => []
        ];

        // Вставляем запись в бд
        $product_id = wp_insert_post( $post_data );

        $uloaded_files = fill_fields( $product_id, $product_title, $product_ACF_fields, null, $product_files );

        $uloaded_files[] = ['table' => $product_files['props_table']];

        // Ставим таксономии
        wp_set_post_terms( $product_id, $product_ACF_fields['categories_ids'], 'equipments' );

        $uploaded_posts[] = [
          'id' => $exist_product_id,
          'Название' => beautify_product_title( $product_title ),
          'Распознанные категории' => [
            'names' => $product_ACF_fields['categories_names'],
            'ids' => $product_ACF_fields['categories_ids']
          ],
          'Файлы' => $uloaded_files
        ];

      }

      if ( $i === 19 ) {
        break;
      }
      $i++;
    }
    $response['total'] = count( $products );
    $response['uploaded'] = $uploaded_posts;
    $response['updated'] = $updated_posts;
    $response['post_type'] = $post_type;
    echo json_encode( $response );
    // var_dump( $response );
    die();
  }
}

// Функция разбора csv файла в массив [0] => ['key' => 'value'] and etc
function csv_to_array( $filename='', $delimiter=',' ) {
  if( !file_exists($filename) || !is_readable($filename) )
      return false;

  $header = null;
  $data = [];

  if ( ($handle = fopen( $filename, 'r' )) !== false ) {
    while ( ($row = fgetcsv( $handle, 1000, $delimiter )) !== false ) {
      if ( !$header ) {
        $header = $row;
      } else {
        $data[] = array_combine( $header, $row );
      }
    }
    fclose( $handle );
  }
  return $data;
}

function parse_product_files( $product_directory='' ) {
  $product_directory_files = filter_folder( scandir( $product_directory ) );

  if ( $product_directory_files ) {
    for ( $i = 0, $len = count( $product_directory_files ); $i < $len; $i++ ) {
      $file = $product_directory_files[ $i ];

      if ( $file === 'gallery' ) {
        $gallery_path = $product_directory . '/gallery';
        $images_in_folder = filter_folder( scandir( $gallery_path ) );
        foreach ( $images_in_folder as $img_file ) {
          $img_file_path = $gallery_path . '/' . $img_file;
          $product_images[] = parse_file( $img_file, $img_file_path );
        }
        unset( $img_file_path );
      } else if ( $file === 'docs' ) {
        $docs_path = $product_directory . '/docs';
        $product_docs_fles = filter_folder( scandir( $docs_path ) );

        foreach ( $product_docs_fles as $j => $folder_name ) {
          $doc_path = $product_directory . '/docs/' . $folder_name;
          $docs_files = filter_folder( scandir( $doc_path ) );

          if ( $docs_files ) {
            foreach ($docs_files as $k => $file_name) {
              $doc_file_path = $doc_path . '/' . $file_name;
              $product_docs[ $folder_name ][] = parse_file( $file_name, $doc_file_path );
              unset( $doc_file_path );
            }
          }

          unset( $doc_path );
          unset( $docs_files );
        }
      } else if ( mb_stripos( $file, 'технические характеристики' ) !== false && mb_stripos( $file, '.csv' ) !== false ) {
        // Получаем уже готовый к вставке в acf макет таблицы
        $props_table = parse_tech_table( $product_directory . '/' . $file );
      } else if ( exif_imagetype( $product_directory . '/' . $file ) !== false ) {
        $schemes[] = parse_file( $file, $product_directory . '/' . $file );
      }
    }

    return [
      'props_table' => $props_table,
      'images' => $product_images,
      'docs' => $product_docs,
      'schemes' => $schemes
    ];
  } else {
    return null;
  }

}

function filter_folder( $array=null ) {
  if ( is_null( $array ) ) {
    return null;
  }

  for ( $i = 0, $len = count( $array ); $i < $len; $i++ ) { 
    if ( $array[ $i ][0] == '.') {
      array_splice( $array, $i, 1 );
      $i--;
    }
  }

  return $array;
}

function parse_file( $filename, $filepath ) {
  $file_props[] = [
    'title' => $filename,
    'path' => $filepath,
    'type' => wp_check_filetype( $filepath ),
  ];

  return $file_props;
}

function parse_tech_table( $filepath ) {
  if ( !$filepath ) {
    return null;
  } else {
    $array_table = csv_to_array( $filepath );
    $count = count( $array_table );

    $table_header = array_keys( $array_table[0] );

    // if ( $count === 1 ) {
    //   $table_header = array_keys( $array_table[0] );
    // } else {
    //   $table_header = $array_table[0];
    //   $table_header = array_keys( $table_header );
    // }

    for ( $i = 0, $len = count( $table_header ); $i < $len; $i++ ) { 
      $table_hdr[] = ['c' => beautify_text( $table_header[ $i ] )];
    }

    foreach ( $array_table as $row ) {
      foreach ( $row as $cell ) { 
        $table_body_cells[] = ['c' => beautify_text( $cell )];
      }
      $table_body[] = $table_body_cells;
      unset( $table_body_cells );
    }

    return [
      'h' => $table_hdr,
      'b' => $table_body
    ];
  }
}

// Функция удаления запятых, проеблов и приведения строки к нижнему регистру
function clean_string( $str='' ) {
  if ( $str ) {
    return mb_strtolower( str_replace( [',', ' ', '&nbsp;', '$#8209;'], ['', '', '', ''], $str ) ) ;
  } else {
    return false;
  }
}

/*
 Функция поиска категорий:

 1) Вначале берем всю переданную строку $categories и сравниваем ее с каждой существующей категорией
 2) Рекурсивно запускаем эту же функцию, но теперь отрезаем часть строки (последнюю категорию после запятой)
 3) В вызванной рекурсивно функции сравниваем вырезанную строку с существующими категориями
 4) Склеиваем вырезанную строку с вырезанной строкой до этого (это уже второй рекурсивный вызов)
 5) И сравниваем склееную строку с существующими категориями (это позволит распознать категории, которые содержат в себе запятую)
 6) Собираем все значения в массив ids и names
 7) Убираем все повторяющиеся значения

 P.S. Все строки для сравнения приводятся к нижнему регистру, очищаются от пробелов и запятых
*/
function find_categories( $first, $categories, $exists_categories, $part=null ) {
  // var_dump('first', $first);
  // var_dump('categories', $categories);
  // var_dump('exists_categories', $exists_categories);
  // var_dump('part', $part);
  // return;
  // Сначала сравниваем всю строку
  if ( $first === true ) {
    $clean_part_of_categories = clean_string( $categories );
    $remaining_part_of_categories = $categories;
  } else {
  // Теперь отрезаем часть строки и приводим в должный вид
    $part_of_categories = preg_replace( '/.*(?=\,\s?)/', '', $categories);
    $remaining_part_of_categories = str_replace( $part_of_categories, '', $categories );
    $clean_remaining_part_of_categories = clean_string( $remaining_part_of_categories );
    $clean_part_of_categories = clean_string( $part_of_categories );
    if ( $part ) {
        $clean_part = $clean_part_of_categories . clean_string( $part ); 
    }
  }
  
  // Сравниваем с сущесвтующими категориями
  foreach ( $exists_categories as $exists_cat) {
    if ( $part && $clean_part === clean_string( $exists_cat->name ) || clean_string( $exists_cat->name ) === $clean_part_of_categories || $clean_remaining_part_of_categories && clean_string( $exists_cat->name ) === $clean_remaining_part_of_categories ) {
      $terms['ids'][] = $exists_cat->term_id;
      $terms['names'][] = $exists_cat->name;
    }
  }
  
  // Вызов с другими параметрами
  if ( $remaining_part_of_categories ) {
    $new_terms = find_categories( false, $remaining_part_of_categories, $exists_categories, $part_of_categories );
  }
  
  // Запись в конечный массив
  if ( $new_terms['ids'] && $terms['ids'] ) {
    $ids = array_merge( $terms['ids'], $new_terms['ids'] );
    $names = array_merge( $terms['names'], $new_terms['names'] );
  } else if ( !$new_terms['ids'] && $terms['ids'] ) {
    $ids = $terms['ids'];
    $names = $terms['names'];
  } else if ( $new_terms['ids'] && !$terms['ids'] ) {
    $ids = $new_terms['ids'];
    $names = $new_terms['names'];
  }
  
  // Возврат уникальных массивов
  return [
    'ids' => array_unique( $ids ),
    'names' => array_unique( $names )
  ];
}

function search_permalinks() {

}

function parse_data_for_ACF_fields( $product=null, $exists_categories=null, $product_files=null ) {
  global $parsedown;

  $product_title = beautify_product_title( $product['Название'] );
  $product_index = trim( $product['№ п/п'] );
  $full_title = my_mb_ucfirst( beautify_text( $product['Название полное'] ) );
  $full_descr = beautify_text( Parsedown::instance()->text( $product['Полное описание'] ) );
  $functions_of_system = beautify_text( Parsedown::instance()->text( $product['Функциональные возможности системы'] ) );
  $product_category = trim( preg_replace( '/\n/', '', $product['Категории'] ) );
  $important = beautify_text( Parsedown::instance()->text( $product['Важно'] ) );
  $note = beautify_text( Parsedown::instance()->text( $product['Примечание'] ) );

  $full_descr = preg_replace_callback( '/<a href="(?<href>.*?)\"/', function( $matches ) {
    if ( $matches['href'] ) {
      $title = str_replace( [
        ' ',
        '_',
        '&#8209;'
      ], [
        '',
        ' ',
        '-'
      ], $matches['href'] );
      
      // Ищем по названию запись
      $product = get_posts( [
        'post_type' => 'equipment',
        'title' => $title
      ] )[0];
      
      if ( $product ) {
        $permalink = get_post_permalink( $product->ID );    
      } else {
        // Если записи нет, то ищем категорию
        $term = get_term_by( 'slug', $title, 'equipments' );

        if ( $term ) {
          $permalink = get_term_link( $term );    
        }
      }

      if ( $permalink ) {
        return '<a href="' . $permalink . '"';
      } else {
        return $matches[0];
      }
    }
  }, $full_descr );

  // var_dump( $product_title );
  // die();

  // Разбираем категории
  $categories = find_categories( true, $product_category, $exists_categories );

  // Возвращаем удобный массив свойств, по которым будем заполнять acf и т.п.
  return [
    'title' => $product_title,
    'index' => $product_index,
    'full_descr' => $full_descr,
    'full_title' => $full_title,
    'card_descr' => $product['Краткое описание'],
    'categories_ids' => $categories['ids'],
    'categories_names' => $categories['names'],
    'functions' => $functions_of_system,
    'props_table' => $product_files['props_table'],
    'important' => $important,
    'note' => $note
  ];
}

function check_and_clear_product( $exists_products, $product_title ) {
  $product_title = mb_strtolower( clean_string( $product_title ) );
  foreach ( $exists_products as $exists_product ) {
    // Элемент, который мы пытаемся добавить, по названию совпал с тем, что уже есть в БД
    if ( mb_strtolower( clean_string( $exists_product->post_title ) ) === $product_title ) {
      // Запросим вложения для этого продукта (документы, картинки)
      $exists_attachements = get_posts( [
        'post_type' => 'attachment',
        'numberposts' => -1,
        'post_parent' => $exists_product->ID
      ] );

      // Если они есть, то безвозвратно и физически удалим их с сайта
      if ( $exists_attachements ) {
        foreach ( $exists_attachements as $exists_attach ) {
          wp_delete_attachment( $exists_attach->ID, true );
        }
      }

      // Удаляем связь с миниатюрой
      // delete_post_thumbnail( $exists_product );

      // Очищаем остальные ACF поля
      // Также очищаются категории
      delete_field( 'gallery', $exists_product->ID );
      // delete_field( 'full_title', $exists_product->ID );
      // delete_field( 'index', $exists_product->ID );
      // delete_field( 'full_descr', $exists_product->ID );
      // delete_field( 'functions', $exists_product->ID );
      delete_field( 'field_5fc39b9a53dd1', $exists_product->ID ); // product docs
      // delete_field( 'card_descr', $exists_product->ID );
      // delete_field( 'field_5fc38211a60ed', $exists_product->ID ); // props table
      // delete_field( 'categories', $exists_product->ID );
      // delete_field( 'important', $product_id );
      // delete_field( 'note', $product_id );
      delete_field( 'schemes', $product_id );


      return $exists_product->ID;
    }
  }
  return false;
}

function fill_fields( $product_id=null, $product_title=null, $product_props=null, $post_categories=null, $product_files=null ) {
  if ( is_null( $product_id) ) {
    return false;
  }

  // Вставим изображения и миниатюру
  $attachment_data = insert_attachments( $product_title, $product_id, $product_files );

  $images_data = $attachment_data['gallery'];

  $docs_data = $attachment_data['docs'];

  $schemes_data = $attachment_data['schemes'];

  $gallery = $images_data; // Для вставки в acf

  $response = $attachment_data['response'];

  // var_dump( $docs_data );


  // update_field( 'full_title', $product_props['full_title'], $product_id );

  // update_field( 'index', $product_props['index'], $product_id );

  // update_field( 'categories', $product_props['categories_ids'], $product_id );

  update_field( 'gallery', $images_data, $product_id );

  // update_field( 'card_descr', $product_props['card_descr'], $product_id );

  // update_field( 'full_descr', $product_props['full_descr'], $product_id );

  // update_field( 'functions', $product_props['functions'], $product_id );

  // update_field( 'important', $product_props['important'], $product_id );

  // update_field( 'note', $product_props['note'], $product_id );

  // Только СОЗДАЕМ поле таблицы
  // update_field( 'props_table', $product_props['props_table'], $product_id );

  update_field( 'schemes', $schemes_data, $product_id );

  update_field( 'field_5fc39b9a53dd1', $docs_data, $product_id );

  // Для вставки таблицы (acf table field) нужны немного другие поля
  $acftf = [
    'acftf' => [
      'v' => '1.3.10'
    ],
    'p' => [
      'o' => [
        'uh' => 1
      ],
      'ca' => false
    ],
    'c' => [
      'c' => '',
      'p' => '',
      'p' => ''
    ]
  ];

  // Заполняем поле вручную
  // update_post_meta( $product_id, 'props_table', array_merge( $acftf, $product_props['props_table'] ) );

  // $elements_count = count( $elements );
  // $left_elements_count = $elements_count - $i;

  // $response = 'Импортированно ' . $i ' шт.';
  

  // if ( $elements_count - $left_elements_count  > 0 ) {
  //   $response .= ' Осталось импортировать: ' . $elements_count - $left_elements_count;
  // } else {
  //   $response .= ' Импорт законечен.';
  // }

  return $response;
}

// Функция для поиска и вставки картинок в галерею и миниатюру
// возвращает массив id вставленных картинок и массив их url
function insert_attachments( $product_name, $product_id, $product_files ) {
  if ( !is_null( $product_name ) ) {
  /*
  Будем искать изображения для галереи
    переносить их в нужную папку
    связывать с записью и вставлять в бд
    устанавливать миниатюру записи
    формировать массив id для вставки в acf
  */
    // var_dump( $product_files['images'] );

    // Путь к папке с медиа
    $wp_upload_dir = wp_upload_dir();
    // Папка для вставки файлов
    $upload_dir = $wp_upload_dir['path'] ? $wp_upload_dir['path'] : $wp_upload_dir['url'];

    // Счетчик для правильной вставки thumbnail
    $img_count = 0;
    foreach ( $product_files['images'] as $img ) {
      $img_path = $img[0]['path'];

      // Имя файла с типом
      // $basename = basename( $img_path );
      $basename = preg_replace( '/.*\//', '', $img_path );

      $transilt_basename = cyr_to_lat( $basename );

      $title = preg_replace( '/\.[^.]+$/', '', $basename );

      $translit_title = cyr_to_lat( $title );

      // Будущее размещение файла
      $filename = $upload_dir . '/' . $transilt_basename;

      // Создаем файл с картинкой в новом месте
      file_put_contents( $filename, file_get_contents( $img_path ) );

      // Подготовим массив с необходимыми данными для вставки в бд
      $attachment = [
        'guid'           => $wp_upload_dir['url'] . '/' . $transilt_basename, 
        'post_mime_type' => $img[0]['type']['type'],
        'post_title'     => $translit_title,
        'post_content'   => '',
        'post_status'    => 'inherit'
      ];

      // Вставляем запись в бд и связываем с текущей записью через $post->ID
      $attach_id = wp_insert_attachment( $attachment, $filename, $product_id );

      // wp_generate_attachment_metadata() зависит от этого файла
      require_once( ABSPATH . 'wp-admin/includes/image.php' );

      // Создадим нарезки thumbnail и прочие метаданные в бд
      $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
      wp_update_attachment_metadata( $attach_id, $attach_data );

      if ( mb_stripos( $img[0], 'thumbnail' ) !== false ) {
        set_post_thumbnail( $product_id, $attach_id );
        $post_thumbnail_index = $img_count;
      }

      $gallery[] = $attach_id;

      $response['gallery'][] = [
        'initial_path' => $img_path,
        'basename' => $basename,
        'basename_translit' => $transilt_basename,
        'title' => $title,
        'title_translit' => $translit_title,
        'file' => $filename
      ];

      $img_count++;
    }
    $thumb = array_splice( $gallery, $post_thumbnail_index, 1 );
    // Вставляем вначало массива вырезанный элемент с индексом, который мы установили для thumbnail
    array_unshift( $gallery, $thumb[0] );

    foreach ( $product_files['docs'] as $docs_folder_name => $doc_files ) {
      // Сначала вставим все документы и соберем их ID
      foreach ( $doc_files as $file ) {
        $filepath = $file[0]['path'];

        // $basename =  basename( $filepath );
        $basename =  preg_replace( '/.*\//', '', $filepath );

        $transilt_basename = cyr_to_lat( $basename );

        $title = preg_replace( '/\.[^.]+$/', '', $basename );

        $translit_title = cyr_to_lat( $title );

        // Будущее размещение файла
        $filename = $upload_dir . '/' . cyr_to_lat( $product_name ) . '-' . $transilt_basename;

        // Создаем файл с картинкой в новом месте
        file_put_contents( $filename, file_get_contents( $filepath ) );

        // Подготовим массив с необходимыми данными для вставки в бд
        $attachment = [
          'guid'           => $wp_upload_dir['url'] . '/' . $transilt_basename, 
          'post_mime_type' => $file[0]['type']['type'],
          'post_title'     => $translit_title,
          'post_content'   => '',
          'post_status'    => 'inherit'
        ];

        // Вставляем запись в бд и связываем с текущей записью через $post->ID
        $attach_id = wp_insert_attachment( $attachment, $filename, $product_id );

        // wp_generate_attachment_metadata() зависит от этого файла
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Создадим нарезки thumbnail и прочие метаданные в бд
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        $tmp_docs[] = [
          'title' => $title,
          'file' => $attach_id
        ];
        $response_tmp_docs[] = [
          'initial_path' => $filepath,
          'basename' => $basename,
          'basename_translit' => $transilt_basename,
          'title' => $title,
          'title_translit' => $translit_title,
          'file' => $filename
        ];
      }

      if ( $docs_folder_name === 'Документация' ) {
        $docs_descr = 'Сертификаты, паспорт товара и прочие необходимые документы.';
      } else if ( $docs_folder_name === 'Прочее' || $docs_folder_name === 'Дополнительная информация' ) {
        $docs_descr = 'Руководства по проектированию и схемы подключения оборудования.';
      } else if ( $docs_folder_name === 'Специализированное программное обеспечение' ) {
        $docs_descr = '';
      } else {
        $docs_descr = '';
      }
      $docs[] = [
        'title' => $docs_folder_name,
        'descr' => $docs_descr,
        'files' => $tmp_docs
      ];
      $response['docs'][] = [
        'folder' => $docs_folder_name,
        'docs' => $response_tmp_docs
      ];
      unset( $tmp_docs );
      unset( $acf_fc_layout );
    }

    foreach ( $product_files['schemes'] as $scheme ) {
      $img_path = $scheme[0]['path'];

      // Имя файла с типом
      // $basename = basename( $img_path );

      $basename = preg_replace( '/.*\//', '', $img_path );

      $transilt_basename = cyr_to_lat( $basename );

      $title = preg_replace( '/\.[^.]+$/', '', $basename );

      $translit_title = cyr_to_lat( $title );

      // Будущее размещение файла
      $filename = $upload_dir . '/' . $transilt_basename;

      // Создаем файл с картинкой в новом месте
      file_put_contents( $filename, file_get_contents( $img_path ) );

      // Подготовим массив с необходимыми данными для вставки в бд
      $attachment = [
        'guid'           => $wp_upload_dir['url'] . '/' . $transilt_basename, 
        'post_mime_type' => $scheme[0]['type']['type'],
        'post_title'     => $translit_title,
        'post_content'   => '',
        'post_status'    => 'inherit'
      ];

      // Вставляем запись в бд и связываем с текущей записью через $post->ID
      $attach_id = wp_insert_attachment( $attachment, $filename, $product_id );

      // wp_generate_attachment_metadata() зависит от этого файла
      require_once( ABSPATH . 'wp-admin/includes/image.php' );

      // Создадим нарезки thumbnail и прочие метаданные в бд
      $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
      wp_update_attachment_metadata( $attach_id, $attach_data );

      $schemes[] = [
        'title' => $title,
        'img' => $attach_id
      ];
      $response['other'][] = [
        'initial_path' => $img_path,
        'basename' => $basename,
        'basename_translit' => $transilt_basename,
        'title' => $title,
        'title_translit' => $translit_title,
        'file' => $filename
      ];
    }

    return [
      'gallery' => $gallery,
      'docs' => $docs,
      'schemes' => $schemes,
      'response' => $response
    ];
  }
}

function cyr_to_lat( $input=false ) {
  if ( $input ) {
    $cyr = [
      ',', ' ', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
      'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
    ];
    $lat = [
      '', '-', 'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'Zh', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Shch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya',
      'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', 'y', 'y', 'y', 'e', 'yu', 'ya'
    ];
    return str_replace( $cyr, $lat, $input );
  }
}