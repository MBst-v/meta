<?php

add_filter( 'upload_mimes', function( $existing_mimes=[] ) {
  $existing_mimes['dwg'] = 'image/vnd.dwg';
  return $existing_mimes;
} );