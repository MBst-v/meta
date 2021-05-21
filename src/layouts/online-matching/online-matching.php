<?php
$steps_titles = [
  '1' => 'Выберите систему оповещения:',
  '2' => 'Выберите тип оповещения (согласно СП3.13130.2012):',
  '3' => 'Введите количество зон оповещения:',
  '4' => 'Выберите мощность оповещателей:',
  '5' => 'Выберите количество микрофонных пультов:',
  '6' => 'Выберите тип переговорных устройств:',
  '7' => 'Выберите количество переговорных устройств:'
];

$breadcrumbs = [
  '1' => 'Система оповещения',
  '2' => 'Тип оповещения',
  '3' => 'Зоны оповещения',
  '4' => 'Мощность оповещателей',
  '5' => 'Кол&#8209;во микрофоннных пультов',
  '6' => 'Тип переговорных устройств',
  '7' => 'Количество переговорных устройств',
  'result' => 'Результат'
];

if ( $_GET ) {
  if ( $_GET['system'] === 'Система речевого оповещения на базе МЕТА 17820/17821' ) {
    $steps_titles = [
      'Выберите систему оповещения',
      'Укажите необходимую мощность оповещателей',
      'Введите количество зон оповещения',
      'Выберите количество микрофонных пультов',
      'Выберите тип переговорных устройств',
      'Выберите количество переговорных устройств'
    ];

    $breadcrumbs = [
      'Система оповещения',
      'Мощность оповещателей',
      'Зоны оповещения',
      'Кол&#8209;во микрофоннных пультов',
      'Тип переговорных устройств',
      'Количество переговорных устройств'
    ];

    $steps = [
      1 => [
        'title' => 'Укажите необходимую мощность оповещателей',
        'breadcrumb' => 'Мощность оповещателей',
        'fields' => [
          0 => [
            'type' => 'number',
            'min' => 0,
            'max' => 2500,
            'placeholder' => 'Укажите общую мощность до 2500 Вт'
          ]
        ]
      ],
      2 => [
        'title' => 'Введите количество зон оповещения',
        'breadcrumb' => 'Зоны оповещения',
        'fields' => [
          0 => [
            'type' => 'number',
            'min' => 1,
            'max' => 40,
            'value' => 1,
            'placeholder' => 'Укажите общую мощность до 2500 Вт'
          ]
        ]
      ]
    ];
  }
}

if ( $_SERVER['QUERY_STRING'] ) {
  $query_string = '?' . $_SERVER['QUERY_STRING'];
} else {
  $query_string = '';
} ?>

<section class="online-matching-sect container">
  <section class="online-matching-block"> <?php
    // Если есть гет-запрос и он не результат подбора или нет гет-запроса вовсе
    if ( $_GET && $_GET['step'] !== 'result' || !$_GET )  : ?>
      <div class="online-matching-block__text" id="step-text-block">
        <h1 class="online-matching-block__title">Онлайн-подбор оборудования систем оповещения и&nbsp;управления эвакуацией</h1>
        <p class="online-matching-block__descr">С помощью нашего сервиса вы сможете подобрать необходимое оборудование и&nbsp;получить готовую спецификацию и&nbsp;схему подключения в&nbsp;формате&nbsp;.dwg.</p>
        <p class="online-matching-block__descr">Если вам необходимо рассчитать расстановку громкоговорителей на&nbsp;планах, воспользуйтесь <a href="#" target="_blank">таблицей расчета мощности громкоговорителей</a> или&nbsp;обратитесь к&nbsp;нашим проектировщикам, которые сделают это абсолютно бесплатно.</p>
      </div> <?php
    endif ?>
    <div class="online-matching">
      <ul data-src="#" class="online-matching__breadcrumbs breadcrumbs lazy" id="breadcrumbs"> <?php
      // Создаем хлебные крошки
        if ( $_GET ) {
          $max = $_GET['step'];
        } else {
          $max = 1;
        }
        $i = 0;
        foreach ( $breadcrumbs as $key => $value ) :
          if ( $i >= $max ) {
            break;
          } ?>
          <li class="breadcrumbs__li"><a href="/online-matching/<?php echo ($i == $max - 1) ? $query_string : '' ?>" rel="nofollow noopener" class="breadcrumbs__link"><?php echo $value ?></a></li> <?php
          $i++;
        endforeach ?>
      </ul> <?php
      // Если не финальный шаг
      if ( !$_GET || $_GET && $_GET['step'] !== 'result' ) :
        if ( $_GET && $_GET['step'] != 1 ) {
          $step_number = $_GET['step'];
          $step_title_text = $steps_titles[ $_GET['step'] - 1 ];
        } else {
          $step_number = 1;
          $step_title_text = 'Выберите систему оповещения:';
        } ?>
        <div class="online-matching__steps" id="steps">
          <div class="online-matching__step-title" id="step-title"><span class="online-matching__step-title-number"><?php echo $step_number ?>.</span> <span class="online-matching__step-title-text"><?php echo $step_title_text ?></span></div> <?php

          // Шаг 1
          if ( $_GET['step'] == 1 || !$_GET ) :
            require get_template_directory() . '/template-parts/online-matching-step-1.php' ?>
              <div class="online-matching__step current-step" id="step-1">
                <form action="online-matching" method="GET" class="online-matching__step-form" id="system-type-form"> <?php 
                  foreach ( $systems as $system ) : ?>
                    <div class="online-matching__system">
                      <img src="<?php echo $system['img'] ?>" alt="" class="online-matching__system-img">
                      <div class="online-matching__sytem-text">
                        <span class="online-matching__system-title"><?php echo $system['title'] ?></span>
                        <p class="online-matching__system-descr"><?php echo $system['descr'] ?></p>
                        <ul class="online-matching__system-props"> <?php
                          foreach ( $system['list'] as $li ) : ?>
                            <li class="online-matching__system-li"><?php echo $li ?></li> <?php
                          endforeach ?>
                        </ul>
                        <button class="online-matching__system-btn btn btn_blue">Выбрать систему</button>
                        <input type="checkbox" name="system" value="<?php echo $system['title'] ?>" hidden>
                      </div>
                    </div> <?php
                  endforeach ?>
                </form>
              </div> <?php
          elseif ( $_GET['step'] == 2 ) : ?>
            <div class="online-matching__step" id="step-2"> <?php

              if ( $_GET['system'] === 'Система речевого оповещения на базе МЕТА 17820/17821' ) : ?>

                <form action="<?php echo $query_string ?>" method="POST" class="online-matching__step-form" data-step-title="Укажите необходимую мощность оповещателей" data-step-breadcrumb="Мощность оповещателей">
                  <label class="online-matching__field">
                    <input type="number" min="0" max="2500" step="1" name="alarm-power" placeholder="Общая мощность оповещателей до 2500 Вт" class="online-matching__field-inp">
                    </span>
                  </label>
                  <button class="online-matching__submit btn btn_blue" onclick="submitStepTwo(event)">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
                </form> <?php

              elseif ( $_GET['system'] === 'Система оповещения обеспечения транспортной безопасности и СОУЭ' ) : ?>

                <form action="<?php echo $query_string ?>" method="POST" class="online-matching__step-form" data-step-title="Выберите тип оповещения (согласно СП3.13130.2012)" data-step-breadcrumb="Тип оповещения">
                  <label class="online-matching__radio">
                    <input type="radio" name="alert-type" value="3 тип оповещения" class="online-matching__radio-inp">
                    <span class="online-matching__radio-text">3&nbsp;тип&nbsp;оповещения</span>
                    <span class="online-matching__radio-hint hint">
                      <span class="hint__icon">i</span>
                      <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                    </span>
                  </label>
                  <label class="online-matching__radio">
                    <input type="radio" name="alert-type" value="4 тип оповещения" class="online-matching__radio-inp">
                    <span class="online-matching__radio-text">4&nbsp;тип&nbsp;оповещения</span>
                    <span class="online-matching__radio-hint hint">
                      <span class="hint__icon">i</span>
                      <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                    </span>
                  </label>
                  <label class="online-matching__radio">
                    <input type="radio" name="alert-type" value="5 тип оповещения" class="online-matching__radio-inp">
                    <span class="online-matching__radio-text">5&nbsp;тип&nbsp;оповещения</span>
                    <span class="online-matching__radio-hint hint">
                      <span class="hint__icon">i</span>
                      <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                    </span>
                  </label>
                  <button class="online-matching__submit btn btn_blue" onclick="submitStepTwo(event)">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
                </form> <?php
              else : ?>

                <form action="<?php echo $query_string ?>" method="POST" class="online-matching__step-form" data-step-title="Выберите тип оповещения (согласно СП3.13130.2012)" data-step-breadcrumb="Тип оповещения">
                  <label class="online-matching__radio">
                    <input type="radio" name="alert-type" value="3 тип оповещения" class="online-matching__radio-inp">
                    <span class="online-matching__radio-text">3&nbsp;тип&nbsp;оповещения</span>
                    <span class="online-matching__radio-hint hint">
                      <span class="hint__icon">i</span>
                      <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                    </span>
                  </label>
                  <label class="online-matching__radio">
                    <input type="radio" name="alert-type" value="4 тип оповещения" class="online-matching__radio-inp">
                    <span class="online-matching__radio-text">4&nbsp;тип&nbsp;оповещения</span>
                    <span class="online-matching__radio-hint hint">
                      <span class="hint__icon">i</span>
                      <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                    </span>
                  </label>
                  <button class="online-matching__submit btn btn_blue" onclick="submitStepTwo(event)">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
                </form> <?php

              endif ?>
            </div> <?php
          elseif ( $_GET['step'] == 3 ) : ?>

            <div class="online-matching__step" id="step-3"> <?php

            if ( $_GET['system'] === 'Система речевого оповещения на базе МЕТА 17820/17821' ) : ?>

              <form action="#" method="POST" class="online-matching__step-form">
                <label class="online-matching__field">
                  <input type="number" min="1" max="24" step="1" name="alert-zone" placeholder="Введите количество зон от 1 до 24" class="online-matching__field-inp">
                  </span>
                </label>
                <button class="online-matching__submit btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
              </form> <?php

            elseif ( $_GET['system'] === 'Система оповещения обеспечения транспортной безопасности и СОУЭ' ) : ?>
                  
            </div> <?php
            

            
            else : ?>
              <?php
            endif ?>
            <?php
          endif ?>

          <!-- <div class="online-matching__step" id="online-matching-step-3">
            <form action="#" method="POST" class="online-matching__step-form" id="alert-zones-form">
              <label class="online-matching__field alert-zone-form__field">
                <input type="number" min="1" max="24" step="1" name="alert-zone" placeholder="Введите количество зон от 1 до 24" class="online-matching__field-inp">
                </span>
              </label>
              <button class="online-matching__submit btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
            </form>
          </div> -->

          <!-- <div class="online-matching__step" id="online-matching-step-4">
            <form action="#" method="POST" class="online-matching__step-form" id="alarm-power-form">
              <label class="online-matching__radio alert-power-form__radio">
                <input type="radio" name="alert-power" value="До 50 Вт" class="online-matching__radio-inp">
                <span class="online-matching__radio-text">До 50 Вт</span>
              </label>
              <label class="online-matching__radio alert-power-form__radio">
                <input type="radio" name="alert-power" value="До 100 Вт" class="online-matching__radio-inp">
                <span class="online-matching__radio-text">До 100 Вт</span>
              </label>
              <label class="online-matching__radio alert-power-form__radio">
                <input type="radio" name="alert-power" value="Более 100 Вт" class="online-matching__radio-inp">
                <span class="online-matching__radio-text">Более 100 Вт</span>
              </label>
              <button class="online-matching__submit btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
            </form>
          </div> -->

          <!-- <div class="online-matching__step" id="online-matching-step-5">
            <form action="#" method="POST" class="online-matching__step-form" id="microphones-form">
              <select name="microphones" class="online-matching__select">
                <option selected hidden class="online-matching__option">Выберите количество из выпадающего списка</option>
                <option value="Нет" class="online-matching__option">Нет</option>
                <option value="1" class="online-matching__option">1</option>
                <option value="2" class="online-matching__option">2</option>
              </select>
              <button class="online-matching__submit btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
            </form>
          </div> -->

          <!-- <div class="online-matching__step" id="online-matching-step-6">
            <form action="#" method="POST" class="online-matching__step-form" id="intercoms-form">
              <label class="online-matching__radio intercoms-form__radio">
                <input type="radio" name="intercoms" value="МЕТА 18555" class="online-matching__radio-inp">
                <img src="#" alt="" data-src="<?php #echo get_the_post_thumbnail_url( get_posts( ['post_type' => 'equipment', 's' => 'СОЛОВЕЙ2-ИБП'] )[0]->ID ) ?>" class="online-matching__radio-img lazy">
                <span class="online-matching__radio-text">МЕТА 18555</span>
                <span class="online-matching__radio-hint hint">
                  <span class="hint__icon">i</span>
                  <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                </span>
              </label>
              <label class="online-matching__radio intercoms-form__radio">
                <input type="radio" name="intercoms" value="МЕТА 18555" class="online-matching__radio-inp">
                <img src="#" alt="" data-src="<?php #echo get_the_post_thumbnail_url( get_posts( ['post_type' => 'equipment', 's' => 'СОЛОВЕЙ2-ИБП'] )[0]->ID ) ?>" class="online-matching__radio-img lazy">
                <span class="online-matching__radio-text">МЕТА 18555</span>
                <span class="online-matching__radio-hint hint">
                  <span class="hint__icon">i</span>
                  <span class="hint__text">– способы оповещения: звуковой, речевой (передача специальных текстов), световой (световые мигающие оповещатели, световые оповещатели «Выход», эвакуационные знаки пожарной безопасности, указывающие направление движения);<br>– разделение здания на зоны пожарного оповещения;<br>– обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.</span>
                </span>
              </label>
              <button class="online-matching__submit btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
            </form>
          </div> -->

          <!-- <div class="online-matching__step" id="online-matching-step-7">
            <form action="#" method="POST" class="online-matching__step-form" id="number-intercoms-form">
              <label class="online-matching__field">
                <input type="number" min="40" max="360" step="40" name="number-intercoms" placeholder="Введите количество переговорных устройств" class="online-matching__field-inp">
                </span>
              </label>
              <button class="online-matching__submit btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>
            </form>
          </div> -->

          <!-- <div class="online-matching__result">
            <h2 class="online-matching__result-title">Рекомендованное оборудование</h2>

            <div class="online-matching__result-params">
              <div class="online-matching__result-row">
                <span class="online-matching__resul-row-left">Система</span>
                <span class="online-matching__resul-row-dots"></span>
                <span class="online-matching__resul-row-right">Система речевого оповещения СОЛОВЕЙ2</span>
              </div>
              <div class="online-matching__result-row" id="result-row-alert-type">
                <span class="online-matching__resul-row-left">Тип оповещения</span>
                <span class="online-matching__resul-row-dots"></span>
                <span class="online-matching__resul-row-right">3 тип</span>
              </div>
              <div class="online-matching__result-row">
                <span class="online-matching__resul-row-left">Количество зон оповещения</span>
                <span class="online-matching__resul-row-dots"></span>
                <span class="online-matching__resul-row-right">16 зон</span>
              </div>
              <div class="online-matching__result-row">
                <span class="online-matching__resul-row-left">Мощность оповещения</span>
                <span class="online-matching__resul-row-dots"></span>
                <span class="online-matching__resul-row-right">до 100 Вт</span>
              </div>
              <div class="online-matching__result-row">
                <span class="online-matching__resul-row-left">Количество микрофонных пультов</span>
                <span class="online-matching__resul-row-dots"></span>
                <span class="online-matching__resul-row-right">1 пульт</span>
              </div>
            </div>

            <div class="online-matching__result-equpiment-block">
              <h2 class="online-matching__result-equpiment-title">Рекомендованное оборудование</h2>
              <div class="online-matching__result-equpiment"> <?php
                $posts #= get_posts( [
                  #'post_type' => 'equipment',
                  #'numberposts' => 4
                ] );
               # print_catalogue( $posts, 'online-matching' ) ?>
              </div>
            </div>

            <div class="online-matching__result-schemes">
              <h2 class="online-matching__result-schemes-title">Схемы подключения</h2>
              <p class="online-matching__result-schemes-descr">Схема применения оборудования для&nbsp;построения однозонной СОУЭ мощностью 50&nbsp;Вт.</p>
              <div class="online-matching__result-schemes-docs">
                <div class="doc-wrap">
                  <a href="#link" target="_blank" class="doc">
                    <img src="#" alt="" data-src="<?php echo $template_directory ?>/img/icon-pdf.svg" class="doc__img lazy">
                    <div class="doc__text">
                      <span class="doc__title">Схема подключения</span>
                      <span class="doc__size">10 мб</span>
                    </div>
                  </a>
                </div>
                <div class="doc-wrap">
                  <a href="#link" target="_blank" class="doc">
                    <img src="#" alt="" data-src="<?php echo $template_directory ?>/img/icon-pdf.svg" class="doc__img lazy">
                    <div class="doc__text">
                      <span class="doc__title">Спецификация</span>
                      <span class="doc__size">10 мб</span>
                    </div>
                  </a>
                </div>
              </div>
              <img src="#" alt="" class="online-matching__result-schemes-scheme">
            </div>

          </div> -->

        </div>  <?php
      endif ?>
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
  </section>
</section>