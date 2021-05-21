<?php
$product = new Product( $post );
$product->print_breadcrumbs() ?>
<section class="product-hero container <?php echo $post_type ?>s"> <?php
  $product->print_gallery();
  $product->print_text() ?>
</section>