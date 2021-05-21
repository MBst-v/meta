<?php
function get_excerpt( $args = '' ){
  global $post;

  if( is_string($args) )
    parse_str( $args, $args );

  $rg = (object) array_merge( array(
    'maxchar'     => 350,
    'text'        => '', 
    'autop'       => true,
    'save_tags'   => '',
    'more_text'   => 'Читать дальше...',
    'ignore_more' => false
  ), $args );

  $rg = apply_filters( 'kama_excerpt_args', $rg );

  if( ! $rg->text )
    $rg->text = $post->post_excerpt ?: $post->post_content;

  $text = $rg->text;
  // убираем блочные шорткоды: [foo]some data[/foo]. Учитывает markdown
  $text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text );
  // убираем шоткоды: [singlepic id=3]. Учитывает markdown
  $text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text );
  $text = trim( $text );

  // <!--more-->
  if( ! $rg->ignore_more  &&  strpos( $text, '<!--more-->') ){
    preg_match('/(.*)<!--more-->/s', $text, $mm );

    $text = trim( $mm[1] );

    $text_append = ' <a href="'. get_permalink( $post ) .'#more-'. $post->ID .'">'. $rg->more_text .'</a>';
  }
  // text, excerpt, content
  else {
    $text = trim( strip_tags($text, $rg->save_tags) );

    // Обрезаем
    if( mb_strlen($text) > $rg->maxchar ){
      $text = mb_substr( $text, 0, $rg->maxchar );
      $text = preg_replace( '~(.*)\s[^\s]*$~s', '\\1...', $text ); // кил последнее слово, оно 99% неполное
    }
  }

  // сохраняем переносы строк. Упрощенный аналог wpautop()
  if( $rg->autop ){
    $text = preg_replace(
      array("/\r/", "/\n{2,}/", "/\n/",   '~</p><br ?/?>~'),
      array('',     '</p><p>',  '<br />', '</p>'),
      $text
    );
  }

  $text = apply_filters( 'kama_excerpt', $text, $rg );

  if( isset($text_append) )
    $text .= $text_append;

  return ( $rg->autop && $text ) ? "<p>$text</p>" : $text;
}