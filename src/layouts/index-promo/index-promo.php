<section class="promo container lazy" data-src="url(<?php echo $template_directory ?>/img/bg-logo.svg)">
  <h2 class="promo__title text_white"><?php echo $section['sect_title'] ?></h2>
  <p class="promo__descr"><?php echo $section['sect_descr'] ?></p>
  <div class="promo-form-wrap"> <?php
    echo do_shortcode( '[contact-form-7 id="91" html_class="promo-form" html_id="promo-form"]' ) ?>
  </div>
</section>