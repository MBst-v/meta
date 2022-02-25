Из объекта structure получаем переменные и строим из них файлы и папки для сайта.

## Страницы:
Все страницы создаются из массива `pages`. Нужно указывать их полный путь и тип файла, если нужно. По умолчанию ставится `.html`. Например:
```javascript
let structure = {
  pages: [
    'src/header.php',
    'src/footer.php',
    'src/index.php'
  ]
}
```
В папке `src/` будут созданы 3 **php-файла**.

Для заполнения страниц сниппетами, нужно создать соотвествующие файлы в папке, которую определяет переменная `pagesSnippetsSrc`, например:
```javascript
let structure = {
  pages: [
    'src/header.php',
    'src/footer.php',
    'src/index.php'
  ],
  pagesSnippetsSrc: './scripts/snippets/'
}
```
Gulp в вышеуказанной папке будет искать файлы с таким же названием, какие страницы мы передали, например он найдет файл `./scripts/snippets/header.php`, возьмет весь его контент, который мы подготовили заранее и вставит в новый файл `src/header.php`.

Для передачи каких-то сниппетов **явно**, можно указать их в объекте `pagesContent`. Тогда Gulp будет искать указанные файлы, брать из них контент и вставлять. Я этим делаю только `functions.php`, например:
```javascript
let structure = {
  pages: [
    'src/header.php',
    'src/footer.php',
    'src/index.php'
  ],
  pagesSnippetsSrc: './scripts/snippets/',
  pagesContent: {
    'src/functions.php': [
      'scripts/snippets/php/disable-standart-js-css.php',
      'scripts/snippets/php/disable-cf7.php',
      'scripts/snippets/php/theme-supports.php',
      'scripts/snippets/php/enqueue.php',
      'scripts/snippets/php/contacts-options.php',
      'scripts/snippets/php/menu.php'
    ]
  }
}
```
Указаные сниппеты вставятся в новый файл и удалятся лишние открытя и закрытия php. Также сразу подключатся файлы скриптов и стилей. Для нужных страниц и размеров экранов.
Если создается файл `header.html`, то в него тоже подключаются все стили (mobile first) и скрипты с defer и без.

Через объект `phpRequire` можно подключить все возможные подключения php-файлов. По умолчанию подключает php.
Через объект `htmlInclides` можно подключить все подключения html-файлов. По умолчанию подключает html.
Пример:
```javascript
let structure = {
  '...',
  phpRequire: {
    'src/header.php': [
      'src/layouts/mobile-menu/mobile-menu'
    ],
    'src/footer.php': [
      'src/layouts/thanks-popup',
      'src/layouts/order-popup',
      'src/layouts/callback-popup',
      'src/layouts/overlay',
    ],
    'src/index.php': [
      'src/layouts/hero/hero',
      'src/layouts/targets/targets',
      'src/layouts/application/application',
      'src/layouts/features/features',
      'src/layouts/partners/partners',
      'src/layouts/form/form',
      'src/layouts/stages/stages',
      'src/layouts/callback/callback',
      'src/layouts/links/links'
    ],
  },
  '...',
  htmlInclude: {
    'src/header.html': [
      'src/layouts/mobile-menu.html',
      'src/layouts/nav.html'
    ]
  }
}
```

Если в массиве `.scss` у элемента массива в скобках есть какие-то идентификаторы, значит в файле `functions.php` подключения стилей будут с проверкой условий страниц, например:
```javascript
let structure = {
  '...',
  scss: [
    'src/scss/style',
    'src/scss/pages/index/index (front,404)',
    'src/scss/pages/services/services (services,service)',
    'src/scss/pages/news/news (single,category)',
    'src/scss/pages/about/about (about)',
    'src/scss/!hover'
  ],
  '...',
}
```
Преобразуется в:
```php
enqueue_style( 'style', $screen_widths );

if ( is_front_page() || is_404() ) {
  enqueue_style( 'index', $screen_widths );
} else if ( is_page_template( 'services.php' ) || is_page_template( 'service.php' ) ) {
  enqueue_style( 'services', $screen_widths );
} else if ( is_page_template( 'news.php' ) || is_single() || is_category() ) {
  enqueue_style( 'news', $screen_widths );
} else if ( is_page_template( 'about.php' ) ) {
  enqueue_style( 'about', $screen_widths );
}
```