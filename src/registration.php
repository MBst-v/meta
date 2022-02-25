<?php
/*
Template name: Запись на обучение
*/
get_header();

$title = get_field('title', $post);
$img   = get_field('image', $post);
$descr = get_field('descr', $post);
?>

<section class="registr container">
  <h1 class="registr__title"><?= $title ?></h1>

  <div class="registr__img-wrapper">
    <img src="<?= $img ?>" alt="<?= $title ?>" class="registr__img">
  </div>

  <div class="registr__descr"><?= $descr ?></div>

  <div class="registr__form">
  <script>!function(a,m,o,c,r,m){a[o+c]=a[o+c]||{setMeta:function(p){this.params=(this.params||[]).concat([p])}},a[o+r]=a[o+r]||function(f){a[o+r].f=(a[o+r].f||[]).concat([f])},a[o+r]({id:"879463",hash:"a2d35a2a257b3e2e70fa59df47665ff0",locale:"ru"}),a[o+m]=a[o+m]||function(f,k){a[o+m].f=(a[o+m].f||[]).concat([[f,k]])}}(window,0,"amo_forms_","params","load","loaded");</script><script id="amoforms_script_879463" async="async" charset="utf-8" src="https://forms.amocrm.ru/forms/assets/js/amoforms.js?1644395944"></script>
  </div>
</section>

<?php get_footer(); ?>