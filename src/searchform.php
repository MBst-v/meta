<?php
  global $template_directory, $site_url, $search_form_class ?>
<form role="search" method="POST" action="<?php echo $site_url ?>/wp-admin/admin-ajax.php" class="search-form<?php echo $search_form_class ?>">
  <img src="#" alt="Иконка лупы" data-src="<?php echo $template_directory ?>/img/icon-search.svg" class="search-icon lazy">
  <input type="text" value="<?php echo get_search_query() ?>" name="s" placeholder="Поиск" class="search-inp">
  <div class="search-result hidden"></div>
</form> <?php
unset( $search_form_class );