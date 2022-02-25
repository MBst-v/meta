<?php
/*
Template name: Онлайн обучение
*/
get_header();
  $title = get_field('title', $post);
  $descr = get_field('descr', $post);
  $img = get_field('img', $post);
  $link = get_field('link', $post);
?>

<section class="online-studing container">
  <div class="online-studing__text">
    <h1 class="online-studing__title"><?= $title ?></h1>
    <div class="online-studing__descr"><?= $descr ?></div>
  </div>

  <a href="<?= $link ?>" class="online-studing__pic">
    <img src="<?= $img ?>" alt="<?= $title ?>" class="online-studing__img">
  </a>
</section>

<?php get_footer(); ?>