<section class="product-props container"> <?php

  $important_text = get_field( 'important', $post );
  $props_table = get_field( 'props_table', $post );
  $functions = get_field( 'functions', $post );
  $docs = get_field( 'product_docs', $post );
  $schemes = get_field( 'schemes', $post );
  $solution_schemes = get_field( 'solution_schemes', $post );
  $solution_props = get_field( 'solution_props', $post );
  $solution_equipments = get_field( 'equipments', $post );
  $solution_descr = get_field( 'solution_descr', $post );
  $note = get_field( 'note', $post );

  if ( $important_text ) : ?>
    <div class="product-props__important">
      <span class="product-props__important-start">Важно!</span>
       <p class="product-props__important-text"><?php echo str_replace( ['<p>', '</p>'], '', $important_text ) ?></p>
    </div> <?php
  endif;

  $product->print_video();

  if ( $props_table ) {
    $table_title = 'Технические характеристики';
    // Выводим таблицу характеристик
    if ( !empty( $props_table ) ) {
      echo '<div class="product-props__table-block">';
      if ( !empty( $table_title ) ) {
        echo '<span class="product-table__title text_red">' . $table_title . '</span>';
      }
      echo '<div class="product-props__table-wrap">';
      echo '<table class="product-props__table product-table" border="0">';
      if ( !empty( $props_table['header'] ) ) {
        echo '<thead class="product-table__hdr">';
          echo '<tr class="product-table__tr">';
            foreach ( $props_table['header'] as $th ) {
              echo '<th class="product-table__th">';
                echo $th['c'];
              echo '</th>';
            }
          echo '</tr>';
        echo '</thead>';
      }
      echo '<tbody class="product-table__body">';
        foreach ( $props_table['body'] as $tr ) {
          echo '<tr class="product-table__tr">';
            foreach ( $tr as $td ) {
              echo '<td class="product-table__td">';
                echo $td['c'];
              echo '</td>';
            }
          echo '</tr>';
        }
      echo '</tbody>';
      echo '</table></div></div>';
    }
  }

  if ( $schemes || $functions ) : ?>
    <div class="product-props__functions-and-schemes"> <?php
      if ( $functions ) : ?>
        <div class="product-props__functions">
          <span class="product-functions__title">Функциональные возможности</span> <?php
          echo str_replace( [
            '<p>',
            '<ul>',
            '<ol>',
            '<li>'
          ], [
            '<p class="product__p">',
            '<ul class="product__ul">',
            '<ol class="product__ol">',
            '<li class="product__li">'
          ], $functions ) ?>
        </div> <?php
      endif ;

      if ( $schemes ) :
        $schemes_count = count( $schemes );
        $lazy_class = $schemes_count > 1 ? '' : ' lazy';
        $data_attr = $schemes_count > 1 ? 'data-lazy' : 'data-src' ?>
        <div class="product-props__schemes" id="product-schemes"> <?php
          foreach ( $schemes as $scheme ) : ?>
            <a data-fancybox="schemes" data-caption="<?php echo $scheme['title'] ?>" href="<?php echo $scheme['img'] ?>" class="product-props__scheme product-scheme">
              <figure class="product-scheme__fig">
                <img src="#" alt="<?php echo $scheme['title'] ?>" <?php echo $data_attr . '="' . $scheme['img'] . '"' ?> class="product-scheme__img <?php echo $lazy_class ?>">
                <figcaption class="product-scheme__title"><?php echo $scheme['title'] ?></figcaption>
              </figure>
            </a> <?php
          endforeach ?>
          <div id="product-schemes__arrows"></div>
        </div> <?php
        unset( $lazy_class );
        unset( $data_attr );
      endif ?>
    </div> <?php
  endif;

  if ( $solution_props ) : ?>
    <div class="solution-props">
      <span class="solution-props__title">Подробные характеристики</span> <?php
      echo str_replace( [
        '<p>',
        '<ul>',
        '<ol>',
        '<li>'
      ], [
        '<p class="product__p">',
        '<ul class="product__ul">',
        '<ol class="product__ol">',
        '<li class="product__li">'
      ], $solution_props ) ?>
    </div> <?php
  endif;

  if ( $solution_equipments ) : ?>
    <div class="solution-equipments">
      <div class="solution-equipments__title-block">
        <span class="solution-equipments__title">Товары решения</span>
        <div class="solution-equipments__nav"></div>
      </div>
      <div class="solution-equipments__slider" id="solution-equipments"> <?php
        // slick = true
        print_catalogue( $solution_equipments, 'solution-equipments', true ) ?>
        <div class="solution-equipments__nav"></div>
      </div>
    </div> <?php
  endif;

  if ( $solution_descr ) : ?>
    <div class="solution-descr">
      <span class="solution-descr__title">Описание решения</span> <?php
      echo str_replace( [
        '<p>',
        '<ul>',
        '<ol>',
        '<li>'
      ], [
        '<p class="product__p">',
        '<ul class="product__ul">',
        '<ol class="product__ol">',
        '<li class="product__li">'
      ], $solution_descr ) ?>
    </div> <?php
  endif;

  if ( $solution_schemes ) :
    if ( $solution_schemes['text'] || $solution_schemes['images'] ) :
      $solution_schemes_text = $solution_schemes['text'];
      $solution_schemes_images = $solution_schemes['images'];
      $lazy_class = $solution_schemes_count > 1 ? '' : ' lazy';
      $data_attr = $solution_schemes_count > 1 ? 'data-lazy' : 'data-src' ?>
      <div class="solution-schemes">
        <div class="solution-schemes__title-block">
          <span class="solution-schemes__title">Схема применения</span>
          <div class="solution-schemes__nav"></div>
        </div> <?php
        if ( $solution_schemes_text ) : ?>
          <div class="solution-schemes__text"> <?php
            echo str_replace( [
              '<p>',
              '<ul>',
              '<ol>',
              '<li>'
            ], [
              '<p class="product__p">',
              '<ul class="product__ul">',
              '<ol class="product__ol">',
              '<li class="product__li">'
            ], $solution_schemes_text ) ?>
          </div> <?php
        endif;
        if ( $solution_schemes_images ) : ?>
          <div class="solution-schemes__schemes" id="solution-schemes"> <?php
            foreach ( $solution_schemes_images as $scheme ) : ?>
              <a data-fancybox="schemes" data-caption="<?php echo $scheme['title'] ?>" href="<?php echo $scheme['img'] ?>" class="solution-schemes__scheme solution-scheme">
                <figure class="solution-scheme__fig">
                  <img src="#" alt="<?php echo $scheme['title'] ?>" <?php echo $data_attr . '="' . $scheme['img'] . '"' ?> class="solution-scheme__img <?php echo $lazy_class ?>">
                  <figcaption class="solution-scheme__title"><?php echo $scheme['title'] ?></figcaption>
                </figure>
              </a> <?php
              endforeach;
              unset( $lazy_class );
              unset( $data_attr ) ?>
              <div class="solution-schemes__nav"></div>
          </div> <?php
        endif ?>
      </div> <?php
    endif;
  endif;

  if ( $note ) : ?>
    <div class="product-props__note">
      <span class="product-props__note-start">Примечание:</span>
       <p class="product-props__note-text"><?php echo $note ?></p>
    </div> <?php
  endif;
  $product->print_docs() ?>
</section>