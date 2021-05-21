<?php
function get_equipment_by_title( $text ) {
  return get_posts( ['post_type' => 'equipment', 'title' => $text] );
}