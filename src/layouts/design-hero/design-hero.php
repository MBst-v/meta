<?php $design_hero = get_field( 'design_hero' ) ?>
<section class="design-sect container">
  <img src="#" alt="" data-src="<?php echo $design_hero['img'] ?>" class="design-sect__img lazy">
  <h1 class="design-sect__title"><?php echo $design_hero['sect_title'] ?></h1> <?php
  foreach ($design_hero['text'] as $p) : ?>
    <p class="design-sect__descr"><?php echo $p['p'] ?></p> <?php
  endforeach ?>
</section>