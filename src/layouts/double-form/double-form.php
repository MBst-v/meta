<?php 
  
  if ( $page_style === 'product' ) {
    $form_title = $post_type === 'equipment' ? 'товар' : 'решение';
    $forms = [
      0 => [
        'title' => 'Заказать ' . $form_title,
        'code' => '[contact-form-7 id="375" html_class="order-form" html_id="order-form"]',
        'input' => '<input type="text" name="product" style="display:none" value="' . $post->post_title . ', ' . $form_title . '" form="order-form">'
      ],
      1 => [
        'title' => 'Технический вопрос',
        'code' => '[contact-form-7 id="377" html_class="ask-form" html_id="ask-form"]',
        'input' => '<input type="text" name="product" style="display:none" value="' . $post->post_title . ', ' . $form_title . '" form="order-form">'
      ]
    ];
  } else if ( is_page_template( 'design.php' ) ) {
    $forms = [
      0 => [
        'title' => 'Проектирование',
        'code' => '[contact-form-7 id="382" html_class="ask-form" html_id="design-form"]'
      ],
      1 => [
        'title' => 'Консультация',
        'code' => '[contact-form-7 id="380" html_class="ask-form" html_id="consult-form"]'
      ]
    ];
  } else {
    $forms = null;
  }

  if ( $forms ) : ?>
    <div data-src="#" class="double-form-sect container lazy" id="double-form-sect">
      <div class="double-form-block">
        <div class="double-form-headings" role="tablist">
          <button type="button" class="double-form-title is-active" aria-selected="true" id="tab-1" tabindex="0" role="tab" aria-controls="panel-1"><?php echo $forms[0]['title'] ?></button>
          <button type="button" class="double-form-title" aria-selected="false" id="tab-2" tabindex="-1" role="tab" aria-controls="panel-2"><?php echo $forms[1]['title'] ?></button>
        </div>
        <div class="double-form-wrap is-active" id="panel-1" role="tabpanel" tabindex="0" aria-hidden="false"> <?php
          if ( $forms[0]['input'] ) {
            echo $forms[0]['input'];
          } 
          echo do_shortcode( $forms[0]['code'] ) ?>
        </div>
        <div class="double-form-wrap" id="panel-2" role="tabpanel" tabindex="0" aria-hidden="true"> <?php
          if ( $forms[1]['input'] ) {
            echo $forms[1]['input'];
          }
          echo do_shortcode( $forms[1]['code'] ) ?>
        </div>
      </div>
      <section class="double-form-contacts">
        <h2 class="double-form-contacts__title">Контакты</h2>
        <div class="contact double-form-contacts__contact_tel">
          <a href="tel:<?php echo $tel_dry ?>" class="tel tel_red"><?php echo $tel ?></a>
          <span class="contact__subtitle">Бесплатный телефон по России</span>
        </div>
        <div class="contact double-form-contacts__contact_support-tel">
          <span class="contact__suptitle">Отдел продаж</span>
          <a href="tel:<?php echo $tel_marketing_dry ?>" class="tel tel_red"><?php echo $tel_marketing ?></a>
        </div>
        <div class="contact double-form-contacts__contact_email">
          <a href="mailto:<?php echo $email ?>" class="email email_red"><?php echo $email ?></a>
        </div>
        <div class="contact double-form-contacts__contact_address">
          <p class="address address_red"><?php echo $address ?>
          </p>
        </div>
      </section>
    </div> <?php
  endif ?>