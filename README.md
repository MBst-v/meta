# Сайт Мета
## Описание проекта
Еще один сайт на WordPress.
Хостинг с поддержкой HTTP2. CSS и JS файлы не будут собираться в один.
Для генерации `faviocns` используется сервис [Favicon Generator. For real.](https://realfavicongenerator.net)
1. [Структура сайта](#1)
    1. [PHP файлы](#php)
        1. [Странцы](#pages)
        2. [Части шаблона](#parts)
        3. [Functions.php](#functions)
    2. [CSS файлы](#1)
    3. [SCSS файлы](#1)
    3. [JS файлы](#1)


## Структура сайта:

### PHP файлы:
Состав **.php** файлов проекта представляет собой *страницы*, *части шаблона* и включения в файл *functions.php*.

#### Страницы:

1. **about.php** - Страница о компании.
2. *about.php* > **where-to-buy.php** - Страница где купить.
3. *about.php* > **contacts.php** - Страница контакты.
4. **category.php** - Страница с новостями.
5. **design.php** - Страница проектирование.
6. **docs.php** - Страница документация.
7. **equipments.php** - Страница наше оборудование.
8. **index.php** - Главная страница.
9. **solutions.php** - Страница готовые решения для объектов.
  ***URL** - ready-made-solutions*
10. **single.php** - Страница с новостью.
11. **signle-equipment.php** - Страница с товаром (оборудование).
12. **single-solution.php** - Страница с товаром (решения).
13. ***page.php*** - Новая созданная страница, для которой по умолчанию подключаются файлы style.css и все скрипты. Файлы стилей для данной страницы содержат описание внешнего вида только общих для всех страниц элементов. По сути пустая страница (пока что).
14. **online-matching.php** - Страница онлайн-подбор.
15. **404.php** - Страница 404.

#### Части шаблона (template-parts):
Каждая часть в большинстве случаев представляет собой отдельную секцию, например `hero-section`, `contacts-section`, `about-section` и т.д. Все они попадают в папку `template-parts/` и включаются в страницы при помощи php `require` или wp `get_template_part()`.
Каждая страница имеет следующий вид:
```php
# index.php
get_header();
require 'template-parts/hero.php';
require 'template-parts/about.php';
require 'template-parts/contacts.php';
get_footer();
```
Принадлежность к странице выделяется префиксом:
```php
# about.php
get_header();
require 'template-parts/about-hero.php';
require 'template-parts/about-about.php';
require 'template-parts/about-contacts.php';
get_footer();
```
Все *src*-файлы находятся в отдельных папках и содержат **.scss** файлы, помимо основного **.php** файла. Например:
```
  source
    -layouts
      -contacts
        -contacts.php
        -contacts.scss
        -contacts.576.scss
        -contacts.768.scss
        -contacts.1024.scss
        -contacts.1440.scss
```
Принадлежность частей шаблона (включения require):
```
src/index.php
  header
  template-parts/index-hero.php
  template-parts/index-equipment.php
  template-parts/index-solutions.php
  template-parts/index-consult.php
  template-parts/index-about.php
  template-parts/index-promo.php
  footer

src/about.php
  header
  template-parts/about-hero.php
  template-parts/about-team.php
  footer

src/where-to-buy.php
  header
  template-parts/w2b-hero.php
  template-parts/w2b-contacts.php
  template-parts/w2b-partners.php
  footer

src/contacts.php
  header
  template-parts/contacts-hero.php
  template-parts/contacts-contacts.php
  template-parts/contacts-delivery.php
  template-parts/contacts-service.php
  template-parts/contacts-callback.php
  footer

src/404.php
  header
  template-parts/hero-404.php
  footer

src/online-matching.php
  header
  template-parts/online-matching.php
  footer

src/docs.php
  header
  template-parts/docs-hero.php
  footer

src/design.php
  header
  template-parts/design-hero.php
  footer

src/equipments.php
  header
  template-parts/production.php
  footer

src/single-equipment.php
  header
  template-parts/product-hero.php
  template-parts/product-props.php
  template-parts-props/product-tech-props.php
  template-parts/product-descr.php
  template-parts/product-functions.php
  template-parts/product-docs.php
  template-parts/product-schemes.php
  template-parts/product-related.php
  footer

src/solutions.php
  header
  template-parts/production.php
  footer

src/single-solution.php
  header
  template-parts/product-hero.php
  template-parts/product-props.php
  template-parts-props/product-tech-props.php
  template-parts/product-descr.php
  template-parts/product-functions.php
  template-parts/product-docs.php
  template-parts/product-schemes.php
  template-parts/product-related.php
  footer

src/footer.php
  header
  template-parts/mobile-menu.php
  template-parts/overlay.php
  template-parts/thanks-popup.php
  template-parts/order-popup.php
  template-parts/consult-popup.php
  footer
```

#### Functions.php и включаения (inc):
Часто файл `functions.php` получается большим, поэтому можно его разделить на маленькие файлы, каждый из которых содержит отдельные функции, например:
* *inc/disable-wp-scripts-and-styles.php* - отключение стандартных стилей и скриптов WP, WP Emoji, Gutenberg; стилей Contact Form7, генерацию лишних тегов.
* *inc/enqueue-styles-and-scripts.php* - подключение стилей и скриптов со всеми нужными настройками.
* *inc/menus.php* - регистрация нужных сайту меню (обычно в шапке, в подвале и мобильное).
* *inc/options-fields.php* - регистрация дополнительных полей в админке (настройки->общее), например, номер телефона, E-mail сайта и т.д. Для вывода в контактах.
* *inc/theme-support-and-thumbnails.php* - включение нужных опций в теме (thumbnails и др), запрет генерации ненужных размеров миниатюр.

### Общие секции
Все секции на всех страницах будут сделаны через ACF. Это позволит заказчику поменять текст или изображения практически в любом месте самостоятельно и без особоых усилий.
Повторяющиеся/похожие секции на всех страницах:
* header
* mobile-menu
* map (карта "где купить?")
* contacts
* footer

### CSS файлы:
Для каждой страницы подключается файл ***style.css*** и его медиа-версии.
Т.к. повторяющихся секций очень мало, то почти для всех страниц будет **свой** css файл:
1. ***style.css***
    * Подключатеся на всех страницах
2. ***index.css***
    * index.php
    * 404.php
3. ***single.css***
    * category.php
    * single.php
4. ***about.css***:
    * about.php
    * where-to-buy.php
    * contacts.php
5. ***docs.css***
    * docs.php
    * design.php
6. ***equipment.css***
    * equipment.php
    * solutions.php
    * signle-equipment.php
    * single-solutions.php
    * online-matching.php
7. ***hover.css***
  * Подключатеся на всех страницах по медиа-запросу hover || miw1024p

Для всех вышеуказанных css файлов, кроме hover, будут созданы их медиа-версии, которые будут подключаться к страницам по медиа-запросам в теге link.

### SCSS Файлы:
#### Общие файлы:
**Включения в style.css**:
1. reset.scss.
2. colors.scss.
3. grid.scss (сетка для класса .container).
4. mixins.scss.
5. variables.scss.
6. fonts.scss (@font-face).
7. animations.scss (описание @keyframes).
8. interface.scss (описание внешнего вида общих элементов, которые не входят ни в один из пунктов ниже).
9. buttons.scss (описание общего вида кнопок, их модификаций)
10. sliders.scss (описание внешнего вида стрелок- и кнопок-переключаетелей, общие стили для слайдеров).
11. forms.scss (описание внешнего полей ввода, радиокнопок, чекбоксов).
12. popups.scss (описание внешнего вида всплывающих окон).
13. header.scss (описание внешнего вида шапки сайта).
14. map.scss (карта).
15. contacts.scss (контакты).
16. double-form.scss (двойные формы).
17. footer.scss (описание внешнего вида подвала сайта).

### Прочее:
#### Шрифты:
Montserrat-Regular
Montserrat-Medium
Montserrat-SemiBold
Montserrat-Bold
SegoeUI-SemiBold

#### Цвета:
$black: #25282B
$white: #fff
$grey: #787B7E
$lightgrey: #D5D4D0
$lightblue: #D6E2EB
$blue: #155EA4
red: #C92A39
  