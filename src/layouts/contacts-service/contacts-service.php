<section data-src="#" class="contacts-service container lazy">
  <h2 class="contacts-service__title">Ремонт оборудования (сервисный центр)</h2>
  <p class="contacts-service__descr">НПП МЕТА осуществляет гарантийный и послегарантийный ремонт поставляемого оборудования.</p>
  <p class="contacts-service__descr">Из ремонта оборудование возвращается в фирменной упаковке. В случае отсутсвия надлежайщей упаковки, ее стоимость будет включена в стоимость ремонта, в том числе гарантийного.</p>
  <p class="contacts-service__descr">Оборудование принимается в ремонт только при наличии заполненной заявки.</p>
  <div class="contact">
    <p class="address address_red">Санкт-Петербург, В.О., 5 линия, д. 68, корпус 2 (крайняя парадная, 2 этаж, код 40)</p>
  </div>
  <div class="contact">
    <a href="tel:<?php echo $tel_repair_dry ?>" class="tel tel_red"><?php echo $tel_repair ?> доб. 212</a>
  </div> <?php
  $filepath = get_home_path() . 'assets/docs/zayavka.doc';
  $fileurl = $site_url . '/assets/docs/zayavka.doc';
  
  $filesize = filesize( $filepath );

  if ( $filesize >= 1000000 ) {
    $filesize = round( $filesize / 1024 / 1024, 2 ) . ' Мб';
  } else {
    $filesize = round( $filesize / 1024, 2 ) . ' Кб';
  } ?>

  <a href="<?php echo $fileurl ?>" target="_blank" class="doc">
    <img src="#" alt="Документ" data-src="<?php echo $template_directory ?>/img/icon-doc.svg" class="doc__img lazy">
    <div class="doc__text">
      <span class="doc__title">Заявка на сервисное обслуживание</span>
      <span class="doc__size">doc, <?php echo $filesize ?></span>
    </div>
  </a>
</section>