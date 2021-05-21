<?php
/*
  Template name: Онлайн-подбор
*/
get_header();

require 'template-parts/online-matching-steps.php' ?>

<section class="online-matching-sect container loading" id="online-matching-sect">
  <section class="online-matching-block">

    <div class="online-matching-block__text" id="step-text-block">
      <h1 class="online-matching-block__title">Онлайн-подбор оборудования систем оповещения и&nbsp;управления эвакуацией</h1>
      <p class="online-matching-block__descr">С помощью нашего сервиса вы сможете подобрать необходимое оборудование и&nbsp;получить готовую спецификацию и&nbsp;схему подключения в&nbsp;формате&nbsp;.dwg.</p>
      <p class="online-matching-block__descr">Если вам необходимо рассчитать расстановку громкоговорителей на&nbsp;планах, воспользуйтесь <a href="<?php echo $template_directory ?>/calculate-power.xls" target="_blank" class="link link_blue">таблицей расчета мощности громкоговорителей</a> или&nbsp;обратитесь к&nbsp;нашим проектировщикам, которые сделают это абсолютно бесплатно.</p>
    </div>

    <div class="online-matching">

      <ul data-src="#" class="online-matching__breadcrumbs breadcrumbs lazy" id="breadcrumbs">
        <li class="breadcrumbs__li current" data-step="0">Система оповещения</li>
      </ul>
      <form action="<?php echo $site_url ?>/wp-admin/admin-ajax.php" method="POST" class="online-matching__steps" id="steps-form">
        <div class="online-matching__step-title" id="step-title"><span class="online-matching__step-title-number">1.</span> <span class="online-matching__step-title-text">Выберите систему оповещения:</span></div>
        <div class="online-matching__step" id="step-1"> <?php 
          foreach ( $systems as $system ) : ?>
            <div class="online-matching__system">
              <img src="#" alt="<?php echo $system['title'] ?>" data-src="<?php echo $system['img'] ?>" class="online-matching__system-img lazy">
              <div class="online-matching__sytem-text">
                <span class="online-matching__system-title"><?php echo $system['title'] ?></span>
                <p class="online-matching__system-descr"><?php echo $system['descr'] ?></p>
                <ul class="online-matching__system-props"> <?php
                  foreach ( $system['list'] as $li ) : ?>
                    <li class="online-matching__system-li"><?php echo $li ?></li> <?php
                  endforeach ?>
                </ul>
                <button class="online-matching__system-btn btn btn_blue">Выбрать систему<span class="loader loader_blue hidden"><span class="loader__circle"></span></span></button>
                <input type="radio" name="system" value="<?php echo $system['title'] ?>" hidden>
              </div>
            </div> <?php
          endforeach ?>
        </div>
      </form>

    </div>

    <div class="online-matching__result" hidden>
      <h2 class="online-matching__result-title">Исходные данные</h2>

      <div class="online-matching__result-params" id="result-params"></div>

      <div class="online-matching__result-equpiment-block">
        <h2 class="online-matching__result-equpiment-title">Рекомендованное оборудование</h2>
        <div class="online-matching__result-equpiment" id="result-products"></div>
      </div>

      <div class="online-matching__result-docs-schemes">
        <h2 class="online-matching__result-docs-schemes-title">Документация и схемы</h2>
        <div class="online-matching__result-docs" id="result-docs"></div>
        <div class="online-matching__result-schemes" id="result-schemes">
          <div class="online-matching__result-schemes-arrows" id="result-schemes-arrows"></div>
        </div>
      </div>

    </div>

  </section>

  <section data-src="#" class="online-matching-contacts lazy">
    <h2 class="online-matching-contacts__title">Контакты</h2>
    <div class="online-matching-contacts__contact contact">
      <a href="tel:<?php echo $tel_dry ?>" class="tel tel_blue"><?php echo $tel ?></a>
      <span class="contact__subtitle">Бесплатный телефон по России</span>
    </div>
    <div class="online-matching-contacts__contact contact">
      <a href="tel:<?php echo $tel_marketing_dry ?>" class="tel tel_blue"><?php echo $tel_marketing ?></a>
      <span class="contact__subtitle">Телефон в г.&nbsp;Санкт&#8209;Петербурге</span>
    </div>
    <div class="online-matching-contacts__contact contact">
      <a href="mailto:<?php echo $email ?>" class="email email_blue"><?php echo $email ?></a>
    </div>
    <button type="button" class="online-matching-contacts__btn btn btn_red" id="consult-btn">Получить консультацию</button>
    <button type="button" class="online-matching-contacts__btn btn btn_red" id="order-btn" hidden>Заказать решение</button>
    <div class="online-matching-contacts__result-btns">
      <button type="button" id="reset-btn" hidden><svg class="reset-arrow" width="14" height="8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M.646 3.646a.5.5 0 000 .708l3.182 3.182a.5.5 0 10.708-.708L1.707 4l2.829-2.828a.5.5 0 10-.708-.708L.646 3.646zM13.5 3.5H1v1h12.5v-1z" fill="currentColor"/></svg>Начать сначала</button>
      <button type="button" id="print" onclick="print()" hidden>Распечатать<svg class="print-icon" width="13" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.38 10.152H4.625a.433.433 0 100 .867H8.38a.433.433 0 000-.867zM8.38 8.785H4.625a.433.433 0 000 .867H8.38a.433.433 0 000-.867z" fill="currentColor"/><path d="M11.989 3.4H10.61V.892a.433.433 0 00-.433-.433H2.823a.433.433 0 00-.433.433V3.4H1.01C.454 3.4 0 3.854 0 4.411v4.36c0 .557.454 1.01 1.011 1.01H2.39v2.327c0 .24.194.433.433.433h7.354c.239 0 .433-.194.433-.433V9.782h1.379c.557 0 1.011-.454 1.011-1.011V4.41c0-.557-.454-1.011-1.011-1.011zM3.257 1.325h6.486V3.4H3.257V1.325zm6.486 10.35H3.257V8.129h6.486v3.546zm.434-5.73H9.074a.433.433 0 010-.867h1.103a.433.433 0 010 .867z" fill="currentColor"/></svg></button>
    </div>
  </section>

  <div class="loader loader_white hidden">
    <div class="loader__circle"></div>
  </div>
</section>

<?php
get_footer();