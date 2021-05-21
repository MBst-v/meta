<?php global $template_directory, $tel, $tel_dry ?>
<aside class="menu" style="display:none">
  <div class="menu__cnt">
    <a href="/" class="menu__logo" title="На главную">
      <img src="<?php echo $template_directory ?>/img/logo.svg" alt="" class="menu__logo-img">
    </a> <?php
    $GLOBALS['search_form_class'] = ' menu__search-form';
    get_search_form() ?>
    <a href="tel:<?php echo $tel_dry ?>" class="menu__tel tel tel_blue"><?php echo $tel ?></a> <?php
    wp_nav_menu( [
      'theme_location'  => 'mobile_menu',
      'container'       => 'nav',
      'container_class' => 'menu__nav',
      'menu_class'      => 'menu__nav-list',
      'items_wrap'      => '<ul class="%2$s">%3$s</ul>'
    ] ) ?>
  </div>
</aside>