<section data-src="#" class="w2b-contacts container lazy">
  <h2 class="w2b-contacts__title text_blue">ЗАО <q>НПП МЕТА</q></h2>
  <p class="w2b-contacts__descr">САНКТ-ПЕТЕРБУРГ ЗАО&nbsp;<q>НПП МЕТА</q> СПб, В.О., 5&nbsp;линия, д.&nbsp;68, корпус&nbsp;3, литера&nbsp;Г.<!-- <br> GPS: N 59°57'24, E 30°16'12.<br> Заезд с 6-й линии во двор направо, напротив бизнес-центра <q>Сенатор</q> и ресторана <q>Васаби</q>. <br><span class="link_blue">Схема проезда</span></p> -->
  <div class="w2b-contacts__contacts">
    <div class="contact">
      <a href="tel:<?php echo $tel_dry ?>" class="tel tel_red"><?php echo $tel ?></a>
      <span class="contact__subtitle">Бесплатный телефон по России</span>
    </div>
    <div class="contact">
      <span class="contact__suptitle">Отдел продаж</span>
      <a href="tel:<?php echo $tel_marketing_dry ?>" class="tel tel_red"><?php echo $tel_marketing ?></a>
    </div>
    <div class="contact contact_email">
      <a href="mailto:<?php echo $email ?>" class="email email_red"><?php echo $email ?></a>
    </div>
  </div>
  <div data-src="#" data-coords="<?php echo $coords ?>" data-zoom="<?php echo $zoom ?>" data-address="<?php echo $address ?>" class="w2b-contacts__map lazy" id="map"></div>
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