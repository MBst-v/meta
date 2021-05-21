<section class="consult">
  <div class="consult__text container lazy" data-src="url(<?php echo $template_directory ?>/img/bg-logo.svg)">
    <h2 class="consult__title"><?php echo $section['sect_title'] ?></h2>
    <p class="consult__descr"><?php echo $section['sect_descr'] ?></p>
  </div>
  <div data-src="#" class="consult-form-wrap container lazy"> <?php
    echo do_shortcode( '[contact-form-7 id="151" html_class="consult-form" html_id="consult-form"]' ) ?>
  </div>
</section>