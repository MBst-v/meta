<section data-src="#" class="contacts-page container lazy">
  <h2 class="contacts-page__title text_blue">Контакты</h2>
  <p class="contacts-page__descr"><?php echo $address ?><!-- Офис и производство: г.&nbsp;СПб, В.О., 5&nbsp;линия, д.&nbsp;68, корпус&nbsp;3, литера&nbsp;Г.<br> GPS: N&nbsp;59°57'24, E&nbsp;30°16'12.<br> Заезд с 6-й линии во двор направо, напротив бизнес-центра <q>Сенатор</q> и ресторана <q>Васаби</q>. <br><button type="button" id="route-btn" class="link_blue">Схема проезда</button> --></p>
  <div class="contacts-page__contacts">
    <div class="contact">
      <a href="tel:<?php echo $tel_dry ?>" class="tel tel_red"><?php echo $tel ?></a>
      <span class="contact__subtitle">Бесплатный телефон по России</span>
    </div>
    <div class="contact">
      <a href="tel:<?php echo $tel_marketing_dry ?>" class="tel tel_red"><?php echo $tel_marketing ?></a>
      <span class="contact__subtitle">Телефон в г.&nbsp;Санкт&#8209;Петербурге</span>
    </div>
    <div class="contact contact_email">
      <a href="mailto:<?php echo $email ?>" class="email email_red"><?php echo $email ?></a>
    </div>
    <!-- <div class="contact">
      <span class="contact__suptitle">Тех. поддержка</span>
      <a href="tel:<?php #echo $tel_support_dry ?>" class="tel tel_red"><?php #echo $tel_support ?></a>
    </div> -->
    <!-- <div class="contact">
      <span class="contact__suptitle">Сервисный отдел</span>
      <a href="tel:<?php #echo $tel_repair_dry ?>" class="tel tel_red"><?php #echo $tel_repair ?></a>
    </div> -->
    <!-- <div class="contact">
      <span class="contact__suptitle">Конструкторский отдел</span>
      <a href="tel:<?php #echo $tel_design_dry ?>" class="tel tel_red"><?php #echo $tel_design ?></a>
    </div> -->
  </div>
  <div class="contacts-page__working-hours">
    <p>Режим работы: понедельник&nbsp;пятница (за&nbsp;исключением общевыходных дней и&nbsp;праздников). Отгрузка со&nbsp;склада с&nbsp;9&#8209;30 до&nbsp;15&#8209;30. Время московское.</p>
    <p>Прием заявок, консультации с&nbsp;9&#8209;00 до&nbsp;17&#8209;30.</p>
    <p>Другие наши сайты: <a href="http://www.jd-media.ru" rel="nofollow noopener" class="link link_blue">www.jd&#8209;media.ru</a>, <a href="http://www.meta-msk.ru" rel="nofollow noopener" class="link link_blue">www.meta&#8209;msk.ru</a></p>
  </div>
  <div data-src="#" data-coords="<?php echo $coords ?>" data-zoom="<?php echo $zoom ?>" data-address="<?php echo $address ?>" class="contacts-page__map lazy" id="map"></div>
</section>
<script>
  function ymapsOnload() {
    ymaps.ready(function () {
      var coords = {
        a: mapBlock.getAttribute('data-coords').replace(/\,.*/,''),
        b: mapBlock.getAttribute('data-coords').replace(/.*\s|\,/,'')
      },
        myMap = new ymaps.Map('map', {
        center: [coords.a, coords.b],
        zoom: mapBlock.getAttribute('data-zoom'),
        controls: ['zoomControl']
      }, {
        searchControlProvider: 'yandex#search'
      }),
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),
        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
          balloonContent: mapBlock.getAttribute('data-address')
        }, {
          iconLayout: 'default#image',
          iconImageHref: '<?php echo $template_directory ?>/img/placemark.svg',
          iconImageSize: [26, 36]
        });

      myMap.geoObjects.add(myPlacemark);
      myMap.panes.get('ground').getElement().style.filter = 'grayscale(100%)';
    });
  }
</script>