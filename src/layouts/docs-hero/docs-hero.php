<?php 
  $sect_title = get_field( 'sect_title' );
  $sect_descr = get_field( 'sect_descr' );
  $groups_docs = get_field( 'docs_repeater' ) ?>
<section class="docs-hero container">
  <h1 class="docs-hero__title"><?php echo $sect_title ?></h1>
  <p class="docs-hero__descr"><?php echo $sect_descr ?></p> <?php
  foreach ( $groups_docs as $group ) : ?>
    <section class="docs-sect">
      <h2 class="docs-sect__title"><?php echo $group['title'] ?></h2>
      <div class="docs-block"> <?php
        foreach ( $group['docs'] as $doc ) :
          $file = $doc['file'];
          $filename = $doc['title'];
          $filelink = $doc['private'] ? '#' : $file['url'];
          $filetype = $doc['private'] ? $doc['filetype'] : $file['subtype'];
          if ( strpos( $filetype, 'excel' ) !== false ) {
            $filetype = 'xls';
          } else if ( strpos( $filetype, 'jpeg' ) !== false ) {
            $filetype = 'jpg';
          } else if ( strpos( $filetype, 'dwg' ) !== false ) {
            $filetype = 'dwg';
          }

          $filesize = $file['filesize'];

          if ( $doc['private'] ) {
            $filesize = 'По запросу';
          } else if ( $filesize >= 1000000 ) {
            $filesize = round( $filesize / 1024 / 1024, 2 ) . ' Мб';
          } else {
            $filesize = round( $filesize / 1024, 2 ) . ' Кб';
          } ?>
        <a href="<?php echo $filelink ?>" target="_blank" class="doc">
          <img src="#" alt="" data-src="<?php echo $template_directory ?>/img/icon-<?php echo $filetype ?>.svg" class="doc__img lazy">
          <div class="doc__text">
            <span class="doc__title"><?php echo $filename ?></span>
            <span class="doc__size"><?php echo strtoupper( $filetype ) . ', ' . $filesize ?></span>
          </div>
        </a> <?php
        endforeach ?>
      </div>
    </section> <?php
  endforeach ?>
</section>