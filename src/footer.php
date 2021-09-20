<?php
global 
 $template_directory,
 $site_url;
wp_footer() ?>
<footer class="ftr container">
  <a href="<?php echo $site_url ?>/" class="ftr__logo" title="Перейти на главную">
    <img src="#" data-src="<?php echo $template_directory ?>/img/logo.svg" alt="" class="ftr__logo-img lazy">
  </a>
  <div class="ftr__copyright">2011-<?php echo date( 'Y' ) ?> &copy;<br class="br1"> Все права защищены.<br>НПП МЕТА</div> <?php
  wp_nav_menu( [
    'theme_location'  => 'footer_menu',
    'container'       => 'nav',
    'container_class' => 'ftr__nav',
    'menu_class'      => 'ftr__nav-list',
    'items_wrap'      => '<ul class="%2$s">%3$s</ul>'
  ] ) ?>
  <div class="ftr__bottom">
    <a href="<?php echo $site_url ?>/policy.pdf" rel="noopener noreferrer nofollow" target="_blank" class="ftr__policy text_underline" title="Посмотреть политику конфиденциальности">Политика конфиденциальности</a>
    <div class="ftr__dev">
    Дизайн и разработка – <a href="https://media-bay.ru" target="_blank" class="ftr__dev-link" title="Перейти на сайт разработчика">media bay</a>
    </div>
  </div>
</footer>
<div id="overlay"></div>
<div id="fake-scrollbar"></div> <?php
#require 'template-parts/overlay.php';
require 'template-parts/thanks-popup.php';
require 'template-parts/order-popup.php';
require 'template-parts/consult-popup.php';
if ( is_super_admin() || is_admin_bar_showing() ) {
  require 'template-parts/import-popup.php';
} ?>
<script>
  if ('serviceWorker' in navigator) {
   window.addEventListener('load', function() {  
     navigator.serviceWorker.register('/sw.js').then(
       function(registration) {
         // Registration was successful
         console.log('ServiceWorker registration successful with scope: ', registration.scope); },
       function(err) {
         // registration failed :(
         console.log('ServiceWorker registration failed: ', err);
       });
   });
  }
</script>
	</body>
</html>