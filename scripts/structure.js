let path = require('path'),
  // destFolder = './test/',
  destFolder = path.relative('gulpfile.js', '/Applications/MAMP/htdocs/meta/wp-content/themes/meta/'),
  jsSrc = 'src/js/',
  componentsSrc = 'src/js/components/',
  structure = {
  wordpress: true, // false by default
  destFolder: destFolder,
  // destFolder: path.relative('gulpfile.js', '/Applications/MAMP/htdocs/gazobetonstroi/wp-content/themes/gazobetonstroi/'),
  // destFolder: path.relative('gulpfile.js', 'C:/OSPanel/domains/gazobetonstroi/wp-content/themes/gazobetonstroi/'),
  htmlSrc: './src/*.html',
  htmlDest: destFolder,

  layoutsSrc: './src/layouts/**/*.php',
  layoutsDest: destFolder + 'layouts/',

  imagesSrc: './src/img/*',
  imagesDest: destFolder +  'img/',

  fontsSrc: './src/fonts/*',
  fontsDest: destFolder +  'fonts/',

  jsonSrc: './src/*.json',
  jsonDest: destFolder,

  pagesSnippetsSrc: './scripts/snippets/',
  cssSnippetsSrc: './scripts/snippets/css/',

  pagesContent: {
  },

  screenWidth: ['0', '420', '576', '768', '1024', '1440'],
  containerWidth: ['280', '536', '688', '940', '1200'],
  // .html by default
  pages: [
    'src/index.php',
    'src/header.php',
    'src/footer.php',
    'src/functions.php',

    'src/about.php',
    'src/contacts.php',
    'src/where-to-buy.php',

    'src/online-matching.php', // Страница онлайн-подбор

    'src/docs.php', // Страница документация
    'src/design.php', // Страница проектирование

    'src/404.php',   // Страница 404

    'src/page.php', // обычная страница для всех

    'src/category.php', // Страница новостей
    'src/single.php',   // Страница новости

    'src/equipments.php',  // Страница оборудование
    'src/single-equipment.php',   // Страница с товаром (оборудование)

    'src/solutions.php',  // Страница решения
    'src/single-solution.php',   // Страница с товаром (решение)
  ],
  // template-parts
  layouts: [
  // .php by default
  // Для файлов с ! не создаются scss файлы
    'src/layouts/header/header',
    'src/layouts/map/map',
    'src/layouts/contacts/contacts',
    'src/layouts/double-form/double-form',
    'src/layouts/footer/footer',

    // index
    'src/layouts/index-hero/index-hero', // Главная секция
    'src/layouts/index-equipment/index-equipment', // Секция оборудование
    'src/layouts/index-solutions/index-solutions', // Секция решения (такая же как оборудование)
    'src/layouts/index-consult/index-consult', // Нужна консультация?
    'src/layouts/index-about/index-about', // О компании
    'src/layouts/index-promo/index-promo', // Хотите быть в курсе последних новостей и акций

    // about
    'src/layouts/about-hero/about-hero', // Главная секция
    'src/layouts/about-team/about-team', // Наши сотрудники

    // about > where-to-buy
    'src/layouts/w2b-hero/w2b-hero', // Главная секция
    'src/layouts/w2b-contacts/w2b-contacts', // Контакты
    'src/layouts/w2b-partners/w2b-partners',  // Дилеры и партнеры

    // about > contacts
    'src/layouts/contacts-hero/contacts-hero', // Главная секция
    'src/layouts/contacts-contacts/contacts-contacts', // Секция контакты
    'src/layouts/contacts-delivery/contacts-delivery', // Секция самовывоз и доставка
    'src/layouts/contacts-service/contacts-service', // Секция сервисный центр
    'src/layouts/contacts-callback/contacts-callback', // Секция напишите нам

    // news
    'src/layouts/news/news',

    // single
    'src/layouts/article/article',

    // 404
    'src/layouts/hero-404/hero-404',

    // online-matching
    'src/layouts/online-matching/online-matching',

    // docs
    'src/layouts/docs-hero/docs-hero',

    // design
    'src/layouts/design-hero/design-hero',

    // equipments, solutions
    'src/layouts/production/production',

    // single-equipment, single-solution
    'src/layouts/product-hero/product-hero', // Главная секция
    'src/layouts/product-props/product-props', // Подробные хар-ки
    'src/layouts/product-tech-props/product-tech-props', // Технические хар-ки
    'src/layouts/product-descr/product-descr', // Описание решения
    'src/layouts/product-functions/product-functions', // Фукнциональные возможности
    'src/layouts/product-docs/product-docs', // Документация
    'src/layouts/product-schemes/product-schemes', // Схемы
    'src/layouts/product-related/product-related', // Похожие товары и похожие решения

    // other
    'src/layouts/mobile-menu/mobile-menu',
    'src/layouts/overlay/overlay',
    'src/layouts/thanks-popup/thanks-popup',
    'src/layouts/order-popup/order-popup',
    'src/layouts/consult-popup/consult-popup'
  ],
  phpInc: [
    'scripts/snippets/inc/disable-wp-scripts-and-styles.php',
    'scripts/snippets/inc/enqueue-styles-and-scripts.php',
    'scripts/snippets/inc/menus.php',
    'scripts/snippets/inc/options-fields.php',
    'scripts/snippets/inc/theme-support-and-thumbnails.php'
  ],
  phpRequire: {
    // if wordpress: true, в каждый вставится wp_header и wp_footer
    // .php by default
    'src/index.php': [
      'template-parts/index-hero',
      'template-parts/index-equipment',
      'template-parts/index-solutions',
      'template-parts/index-consult',
      'template-parts/index-about',
      'template-parts/index-promo'
    ],
    'src/about.php': [
      'template-parts/about-hero.php',
      'template-parts/about-team.php'
    ],
    'src/where-to-buy.php': [
      'template-parts/w2b-hero.php',
      'template-parts/w2b-contacts.php',
      'template-parts/w2b-partners.php'
    ],
    'src/contacts.php': [
      'template-parts/contacts-hero.php',
      'template-parts/contacts-contacts.php',
      'template-parts/contacts-delivery.php',
      'template-parts/contacts-service.php',
      'template-parts/contacts-callback.php'
    ],
    'src/404.php': [
      'template-parts/hero-404.php'
    ],
    'src/online-matching.php': [
      'template-parts/online-matching.php'
    ],
    'src/docs.php': [
      'template-parts/docs-hero.php'
    ],
    'src/design.php': [
      'template-parts/design-hero.php'
    ],
    'src/equipments.php': [
      'template-parts/production.php'
    ],
    'src/single-equipment.php': [
      'template-parts/product-hero.php',
      'template-parts/product-props.php',
      'template-parts-props/product-tech-props.php',
      'template-parts/product-descr.php',
      'template-parts/product-functions.php',
      'template-parts/product-docs.php',
      'template-parts/product-schemes.php',
      'template-parts/product-related.php'
    ],
    'src/solutions.php': [
      'template-parts/production.php'
    ],
    'src/single-solution.php': [
      'template-parts/product-hero.php',
      'template-parts/product-props.php',
      'template-parts-props/product-tech-props.php',
      'template-parts/product-descr.php',
      'template-parts/product-functions.php',
      'template-parts/product-docs.php',
      'template-parts/product-schemes.php',
      'template-parts/product-related.php'
    ],
    'src/footer.php': [
      'template-parts/mobile-menu.php',
      'template-parts/overlay.php',
      'template-parts/thanks-popup.php',
      'template-parts/order-popup.php',
      'template-parts/consult-popup.php'
    ]
  },
  htmlInclude: {

  },
  mainScss: 'style',
  // .scss by default
  // будет вставлено в главный файл стилей
  generalCss: [
    'src/scss/general/buttons/buttons',
    'src/scss/general/popups/popups',
    'src/scss/general/sliders/sliders',
    'src/scss/general/forms/forms',
    'src/scss/general/interface/interface'
  ],
  scss: [
  // ! - запрещает создавать размеры для файлов
  // по умолчанию .scss
  // в скобках можно написать для каких страниц будет работать стиль
    // и если wordpress === true, то стили будут подключены через is_page_template
    // в остальных случаях текст в скобках игнорируется
    // single - is_single(), 404 - is_404(), front - is_front_page(), category - is_category()
    'src/scss/style', //
    'src/scss/index (front, 404)', //
    'src/scss/single (category, single)', //
    'src/scss/about (about, where-to-buy, contacts)', //
    'src/scss/docs (docs, design)',
    'src/scss/product (equipments, solutions, single-equipment, single-solution, online-matching)',
    'src/scss/!hover'
  ],
  fontsSrc: 'src/fonts/',
  fontsLibs: 'scripts/libs/fonts/',
  scssAssets: {
    // animations extract from scripts/libs/css/animations.js
    'src/scss/assets/animations': [
      // 'fadeIn',
      // 'fadeOut',
      'spin',
      'translateToBottom'
    ],
    'src/scss/assets/colors': {
      'black': '#25282B',
      'white': '#fff',
      'grey': '#787B7E',
      'lightgrey': '#D5D4D0',
      'lightblue': '#D6E2EB',
      'blue': '#155EA4',
      'red': '#C92A39'
    },
    'src/scss/assets/fonts': [
      'Montserrat-Regular',
      'Montserrat-Medium',
      'Montserrat-SemiBold',
      'Montserrat-Bold',
      'SegoeUI-SemiBold'
    ],
    /*
      regular - normal
      black - 900
      bold - bold
      semibold - 600 
      medium - 500
    */
    'src/scss/assets/grid': '',
    'src/scss/assets/mixins': '',
    'src/scss/assets/reset': '',
    'src/scss/assets/variables': ''
  },
  // fullAssets - будут вставлены в mainScss
  // semiAssets - будут всталвлены во все файлы
  scssImports: {
    'fullAssets': [
      'src/scss/assets/animations',
      'src/scss/assets/fonts',
      'src/scss/assets/grid',
      'src/scss/assets/reset',
      'src/scss/assets/colors',
      'src/scss/assets/mixins',
      'src/scss/assets/variables'
    ],
    'semiAssets': [
      'src/scss/assets/colors',
      'src/scss/assets/mixins',
      'src/scss/assets/variables'
    ],
    'src/scss/style': [
    // ! - запрещает создавать много файлов с ширинами экранов
    // по умолчанию ищет .scss файлы
      'src/scss/general/buttons/buttons',
      'src/scss/general/popups/popups',
      'src/scss/general/sliders/sliders',
      'src/scss/general/forms/forms',
      'src/scss/general/interface/interface',

      // Общие секции-блоки
      'src/layouts/header/header',
      'src/layouts/map/map',
      'src/layouts/contacts/contacts',
      'src/layouts/double-form/double-form',
      'src/layouts/footer/footer'
    ],
    // index, 404
    'src/scss/index': [
      'src/layouts/index-hero/index-hero',
      'src/layouts/index-equipment/index-equipment',
      'src/layouts/index-solutions/index-solutions',
      'src/layouts/index-consult/index-consult',
      'src/layouts/index-about/index-about',
      'src/layouts/index-promo/index-promo',
      'src/layouts/hero-404/hero-404'
    ],
    // about
    // about > where-to-buy
    // about > contacts
    'src/scss/about': [
      'src/layouts/about-hero/about-hero',
      'src/layouts/about-team/about-team',
      'src/layouts/w2b-hero/w2b-hero',
      'src/layouts/w2b-contacts/w2b-contacts',
      'src/layouts/w2b-partners/w2b-partners',
      'src/layouts/contacts-hero/contacts-hero',
      'src/layouts/contacts-contacts/contacts-contacts',
      'src/layouts/contacts-delivery/contacts-delivery',
      'src/layouts/contacts-service/contacts-service',
      'src/layouts/contacts-callback/contacts-callback'
    ],
    // single
    // category
    'src/scss/single': [
      'src/layouts/news/news',
      'src/layouts/article/article'
    ],
    // docs
    // design
    'src/scss/docs': [
      'src/layouts/docs-hero/docs-hero',
      'src/layouts/design-hero/design-hero'
    ],
    // equipment
    // solutions
    // single-equipment
    // single-solution
    // online-matching
    'src/scss/product': [
      'src/layouts/product-hero/product-hero',
      'src/layouts/product-props/product-props',
      'src/layouts/product-tech-props/product-tech-props',
      'src/layouts/product-descr/product-descr',
      'src/layouts/product-functions/product-functions',
      'src/layouts/product-docs/product-docs',
      'src/layouts/product-schemes/product-schemes',
      'src/layouts/product-related/product-related',
      'src/layouts/production/production',
      'src/layouts/online-matching/online-matching'
    ]
  },
  jsLibsSrc: './scripts/libs/js/',
  jsSnippetsSrc: './scripts/snippets/js/',
  jsPolyfillsSrc: './scripts/snippets/polyfills/',
  jsSrc: jsSrc,
  componentsSrc: componentsSrc,
  js: {
    componentsSrc: [
// компоненты будут собираться в файл с восклицательным знаком
      '!main.js',
      'utils.js',
      'menu.js',
      'popups.js',
      'forms.js',
      'telMask.js',
      'sliders.js'
    ],
    jsSrc: [
      'slick.min.js [defer]',
      'lazy.min.js [defer]',
      'MobileMenu.min.js [defer]',
      'Popup.min.js [defer]',
      'svg4everybody.min.js [defer]',
      'main.js [defer]'
    ],
    'polyfills': [
      'intersectionObserverPolyfill.js',
      'customEventsPolyfill.js',
      // 'closestPolyfill'
    ]
  }
}

module.exports = structure;