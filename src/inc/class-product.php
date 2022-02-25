<?php

class Product {

  public function __construct( $post ) {
    $this->post = $post;
  }

  public function print_breadcrumbs() {
    global $site_url;
    $post_taxonomy_slug = $this->post->post_type . 's';
    // Получаем все таксономии для записи
    $taxonomies = get_the_terms(  $this->post->ID, $post_taxonomy_slug );

    // Берем только самую первую таксономию (т.к. она формируется у нас в url)
    if ( $taxonomies ) {
      $taxonomy_href = $post_taxonomy_slug . '/' . $taxonomies[0]->slug;
      $taxonomy_title = $taxonomies[0]->name;
    }

    // Название общей страницы с записями
    $post_taxonomy_name = $post_taxonomy_slug === 'equipments' ? 'Оборудование' : 'Решения';

    $breadcrumbs = [
      'Главная' => $site_url . '/',
      $post_taxonomy_name => $site_url . '/' . $post_taxonomy_slug . '/',
      $taxonomy_title => $site_url . '/' . $taxonomy_href . '/',
      $this->post->post_title => '#'
    ];

     ?>

    <ul data-src="#" class="product__breadcrumbs breadcrumbs container lazy"> <?php
      foreach ( $breadcrumbs as $title => $href ) :
        if ( $title && $href ) : ?>
          <li class="breadcrumbs__li"><a href="<?php echo $href ?>" class="breadcrumbs__link<?php echo $href === '#' ? ' current' : '' ?>"><?php echo $title ?></a></li> <?php
        endif;
      endforeach ?>
    </ul> <?php

  }

  public function print_video() {
    $product_videos = get_field( 'videos' );
    if ( $product_videos ) : ?>
      <div class="product-props__videos"> <?php
        foreach ( $product_videos as $video ) {
          echo $video['iframe'];
        } ?>
        <div class="product-videos__nav"></div>
      </div> <?php
    endif;
  }

  public function print_gallery() {
    global $template_directory;
    $image_cover = get_field( 'img_cover' );
    $product_gallery = get_field( 'gallery' ) ?>

    <div class="product-hero__gallery product-gallery" id="product-gallery"> <?php
      // Если галереи нет, то ставим одно изображение-заглушку
      if ( !$product_gallery ) {
        $product_gallery = [ $template_directory . '/img/img-placeholder.svg' ];
      }

      $fancybox_slides = ''; // Слайды основной галереии
      $not_fancybox_slides = ''; // Слайды маленькой галереи
      $gallery_count = count( $product_gallery );
      // Если слайд 1, то будем его грузить просто lazy, т.к. slick-slider не будет собран
      // а если слайдов больше 1, то будем делать lazyload методом slick-slider
      $lazy_class = $gallery_count > 1 ? '' : ' lazy';
      $data_attr = $gallery_count > 1 ? 'data-lazy' : 'data-src';

      // Растягивание изображений
      $img_cover_class = $image_cover ? ' object-fit-cover' : '' ?>

      <div class="product-gallery__slides" id="product-gallery-slides"> <?php
      // Перебираем слайды и формируем из них 2 строки
      // fancybox_slides - основной слайдер по 1 слайду, будет fancybox+slick-slider
      // not_fancybox_slides - слайдер-навигация по 4 слайда, будет обычный slick-slider
        foreach ( $product_gallery as $img ) {
          $img_tag = '<img src="#" alt="' . $post->title . '" ' . $data_attr . '="' . $img . '" class="product-gallery__img' . $lazy_class . $img_cover_class . '">';
          $fancybox_slides .= '<a href="' . $img . '" data-fancybox="images" class="product-gallery__slide">' . $img_tag . '</a>';
          $not_fancybox_slides .= '<div class="product-gallery__slide">' . $img_tag . '</div>';
        }
        echo $fancybox_slides ?>
      </div>
      <div class="product-gallery__arrows" id="product-gallery-arrows"></div>
      <div class="product-gallery__nav" id="product-gallery-nav"> <?php
        echo $not_fancybox_slides ?>
      </div>
    </div> <?php
  }

  public function print_text() {

    $product_title = get_field( 'full_title' );
    $product_full_descr = get_field( 'full_descr' ) ?>

    <div class="product-hero__text"> <?php
    // Если в ACF не задано название, то берем стандартное
      if ( !$product_title ) {
        $product_title = get_the_title();
      } ?>
      <h1 class="product-hero__title text_blue"><?php echo $product_title ?></h1> <?php
      // Выводим, проставляя классы для элементов распарсенного markdown
      if ( $product_full_descr ) {
        echo str_replace( [
          '<p>',
          '<ul>',
          '<li>'
        ], [
          '<p class="product-hero__descr">',
          '<ul class="product-hero__ul">',
          '<li class="product-hero__li">'
        ], $product_full_descr );
      } ?>
      <button type="button" onclick="scrollToTarget(event, '.double-form-sect')" class="product-hero__btn btn btn_blue">Заказать</button>
    </div> <?php

  }

  public function print_docs( $documents = null ) {

    global $template_dir, $template_directory;

    if ( is_null( $documents ) ) {
      $docs = get_field( 'product_docs' );
    } else {
      $docs = $documents;
    }

    if ( $docs ) {
      $html = '';

      foreach ( $docs as $docs_block ) {
        $docs_block_title = $docs_block['title'];
        $docs_block_descr = $docs_block['descr'];
        $docs_block_files = $docs_block['files'];

        $docs_html = '';

        foreach ( $docs_block_files as $doc ) {
          $file = $doc['file'];
          $filename = $doc['title'];
          $filelink = $file['url'];
          $filetype = $file['subtype'];
          // Если в админке не заполнини название, то берем название файла
          if ( !$filename ) {
            $filename = $file['title'];
          }
          // Устанавливаем короткое название для некоторых форматов
          if ( strpos( $filetype, 'excel' ) !== false ) {
            $filetype = 'xls';
          } else if ( strpos( $filetype, 'jpeg' ) !== false ) {
            $filetype = 'jpg';
          } else if ( strpos( $filetype, 'dwg' ) !== false ) {
            $filetype = 'dwg';
          }
          // Если иконки для конкретного типа фала не существует, то ставим заглушку
          $html_filetype = $filetype;
          $fileicon = $template_dir . '/img/icon-' . $filetype . '.svg';
          if ( ! file_exists( $fileicon ) ) {
            $filetype = 'file';
          }
          
          // Переводим размер файла в мегабайты или килобайты
          $filesize = $file['filesize'];
          if ( $filesize >= 1000000 ) {
            $filesize = round( $filesize / 1024 / 1024, 2 ) . ' Мб';
          } else {
            $filesize = round( $filesize / 1024, 2 ) . ' Кб';
          }

          $docs_html .= '
            <div class="doc-wrap">
              <a href="' . $filelink . '" target="_blank" class="doc">
                <img src="#" data-src="' . $template_directory . '/img/icon-' . $filetype . '.svg" alt="" class="doc__img lazy">
                <div class="doc__text">
                  <span class="doc__title">' . $filename . '.' . $html_filetype . '</span>
                  <span class="doc__size">' . $filesize . '</span>
                </div>
              </a>
            </div>
          ';
        }

        $html .= '
          <div class="product-props__docs product-docs">
            <div class="product-docs__text">
              <span class="product-docs__title">' . $docs_block_title . '</span>
              <p class="product-docs__descr">' . $docs_block_descr . '</p>
            </div>
            <div class="product-docs__files">' .
              $docs_html . '
            </div>
          </div>';
        unset( $docs_html );
      }

      if ( is_null( $documents ) ) {
        echo $html;
      } else {
        return urlencode( $html );
      }

    }
  }

}