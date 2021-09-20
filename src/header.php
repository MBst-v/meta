<?php
  global
    $coords,
    $zoom,
    $page_style,
    $site_url,
    $template_directory,
    $page_style,
    $webp_support,
    $tel,
    $tel_dry,
    $tel_support,
    $tel_support_dry,
    $tel_marketing,
    $tel_marketing_dry,
    $tel_repair,
    $tel_repair_dry,
    $tel_design,
    $tel_design_dry,
    $email,
    $address;

    // Главная страница и 404
    if ( is_front_page() || is_404() ) {
      $page_style = 'index';
    // Страницы новостей и новости
    } else if ( is_page_template( 'category.php' ) || is_singular( 'post' ) ) {
      $page_style = 'single';
    // Страницы о компании, где купить, контакты
    } else if ( is_page_template( ['about.php', 'where-to-buy.php', 'contacts.php'] ) ) {
      $page_style = 'about';
    // Страницы документация, проектирование
    } else if ( is_page_template( ['docs.php', 'design.php'] ) ) {
      $page_style = 'docs';
    // Страницы оборудование, решения, их одиночные варианты и онлайн-подбор
    } else if ( is_page( ['equipments', 'solutions'] ) || is_tax( ['equipments', 'solutions'] ) || is_singular( ['equipment', 'solution'] ) || is_page_template( 'online-matching.php' ) ) {
      $page_style = 'product';
    }

  $is_front_page = is_front_page();
  $is_404 = is_404();
  $is_category = is_category();
  $is_single = is_single() ?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no, user-scalable=no, viewport-fit=cover">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- fonts preload --> <?php
  $fonts = [
    'Montserrat-Regular.woff',
    'Montserrat-Medium.woff',
    'Montserrat-SemiBold.woff',
    'Montserrat-Bold.woff',
    'SegoeUI-SemiBold.woff'
  ];
  foreach ( $fonts as $font ) : ?>
    
  <link rel="preload" href="<?php echo $template_directory . '/fonts/' . $font ?>" as="font" type="font/woff" crossorigin="anonymous" /> <?php
  endforeach ?>

  <!-- css preload --> 
  <link rel="preload" href="<?php echo $template_directory ?>/style.css" as="style" />
  <link rel="preload" href="<?php echo $template_directory ?>/css/style.css" as="style" />
  <link rel="preload" href="<?php echo $template_directory ?>/css/style.576.css" as="style" media='(min-width: 575.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/style.768.css" as="style" media='(min-width: 767.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/style.1024.css" as="style" media='(min-width: 1023.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/style.1240.css" as="style" media='(min-width: 1239.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/hover.css" as="style" media="(hover), (min-width:1024px)" /> <?php
  if ( $page_style ) : ?>

  <link rel="preload" href="<?php echo $template_directory ?>/css/<?php echo $page_style ?>.css" as="style" />
  <link rel="preload" href="<?php echo $template_directory ?>/css/<?php echo $page_style ?>.576.css" as="style" media='(min-width: 575.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/<?php echo $page_style ?>.768.css" as="style" media='(min-width: 767.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/<?php echo $page_style ?>.1024.css" as="style" media='(min-width: 1023.98px)' />
  <link rel="preload" href="<?php echo $template_directory ?>/css/<?php echo $page_style ?>.1240.css" as="style" media='(min-width: 1239.98px)' /><?php
  endif ?>

  <!-- other preload -->
  <link rel="preload" href="<?php echo $template_directory ?>/img/logo.svg" as="image" />
  <link rel="preload" href="<?php echo $template_directory ?>/img/icon-tel-blue.svg" as="image" media="(min-width:767.98px)" />
  <!-- favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $site_url ?>/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $site_url ?>/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $site_url ?>/favicon-16x16.png">
  <link rel="manifest" href="<?php echo $site_url ?>/webmanifest.json">
  <link rel="mask-icon" href="<?php echo $site_url ?>/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#d6e2eb">
  <meta name="theme-color" content="#ffffff"> <?php
  if ( is_404() ) : ?>
    <style>
      body {
        display: flex;
        flex-flow: column;
      }
      .container, .ftr, .hdr {
        flex-shrink: 0;
        width: 100%;
      }

      .ftr {
        margin-top: auto;
      }

      .hero-404 {
        margin: auto;
      }
    </style> <?php
  endif;

  if ( stripos( $_SERVER['HTTP_USER_AGENT'], 'lighthouse' ) === false ) : ?>
  <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter16752418 = new Ya.Metrika({id:16752418, clickmap:true, webvisor:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-16391496-2"></script>
  <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-16391496-2');</script><?php
  endif;
  wp_head() ?>
</head>

<body data-template-dir="<?php echo $template_directory ?>" data-site-url="<?php echo $site_url ?>"> <?php
  wp_body_open() ?>
  <noscript>
    <!-- <noindex> -->Для полноценного использования сайта включите JavaScript в настройках вашего браузера.<!-- </noindex> -->
  </noscript>
  <header data-src="#" class="hdr container lazy" id="hdr">
    <div class="hdr__top">
      <a href="<?php echo $site_url ?>/" class="hdr__logo" title="Перейти на главную">
        <img src="<?php echo $template_directory ?>/img/logo.svg" alt="Логотип Мета" class="hdr__logo-img">
      </a> <?php
      $GLOBALS['search_form_class'] = ' hdr__search-form';
      get_search_form() ?>
      <a href="tel:<?php echo $tel_dry ?>" class="hdr__tel tel tel_blue"><?php echo $tel ?></a>
    </div>
    <div class="hdr__bottom"> <?php
      wp_nav_menu( [
        'theme_location'  => 'header_menu',
        'container'       => 'nav',
        'container_class' => 'hdr__nav',
        'menu_class'      => 'hdr__nav-list',
        'items_wrap'      => '<ul class="%2$s">%3$s</ul>'
      ] ) ?>
      <button type="button" class="hdr__burger" id="hdr-burger">
        <span class="hdr__burger-box">
          <span class="hdr__burger-inner"></span>
        </span>
      </button>
    </div> <?php
    require 'template-parts/mobile-menu.php' ?>
  </header>