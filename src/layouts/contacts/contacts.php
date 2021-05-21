<section data-src="#" class="contacts-sect lazy">
  <section class="contacts sect">
    <h2 class="contacts__title">Контакты</h2>
    <div class="contacts__contacts-block">
      <div class="contatcs__telephones">
        <div class="contact contacts__contact_tel">
          <a href="tel:<?php echo $tel_dry ?>" class="tel tel_white">
            <?php echo $tel ?></a>
          <span class="contact__subtitle">Бесплатный телефон по России</span>
        </div>
        <div class="contact">
          <span class="contact__suptitle">Отдел продаж</span>
          <a href="tel:<?php echo $tel_marketing_dry ?>" class="tel tel_white">
            <?php echo $tel_marketing ?></a>
        </div>
      </div>
      <div class="contact contacts__contact_email">
        <a href="mailto:<?php echo $email ?>" class="email email_white">
          <?php echo $email ?></a>
      </div>
      <div class="contact contacts__contact_address">
        <p class="address address_white">
          <?php echo $address ?>
        </p>
      </div>
    </div>
  </section>
  <div class="contacts-form-wrap sect"> <?php
    echo do_shortcode( '[contact-form-7 id="7" html_class="contacts-form" html_id="contacts-form"]' ) ?>
  </div>
</section>