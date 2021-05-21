<?php
get_header();
// global $wp_query;
  // var_dump( $wp_query );
require 'template-parts/hero-404.php';

get_footer();
## Выводит на экран список всех хуков WordPress и функций к ним прикрепленных. 
## @param строка $hook_name Название хука список фукнций которого нужно вывести.
## @ver 2.0
// function hooks_list( $hook_name = '' ){
//   global $wp_filter;
//   $wp_hooks = $wp_filter;

//   // для версии 4.4 - переделаем в массив
//   if( is_object( reset($wp_hooks) ) ){
//     foreach( $wp_hooks as & $object ) $object = $object->callbacks;
//     unset($object);
//   }

//   if( $hook_name ){
//     $hooks[ $hook_name ] = $wp_hooks[ $hook_name ];

//     if( ! is_array($hooks[$hook_name]) ){
//       trigger_error( "Nothing found for '$hook_name' hook", E_USER_WARNING );
//       return;
//     }
//   }
//   else {
//     $hooks = $wp_hooks;
//     ksort( $wp_hooks );
//   }

//   $out = '';
//   foreach( $hooks as $name => $funcs_data ){
//     ksort( $funcs_data );
//     $out .= "\nхук\t<b>$name</b>\n";
//     foreach( $funcs_data as $priority => $functions ){
//       $out .= "$priority";
//       foreach( array_keys($functions) as $func_name ) $out .= "\t$func_name\n";
//     }
//   }

//   echo '<'.'pre>'. $out .'</pre'.'>';
// }hooks_list();