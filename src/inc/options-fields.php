<?php
 /* Настройка контактов в панели настройки->общее */
// Функции вывода нужных полей
  function options_inp_html ( $id ) {
    echo "<input type='text' name='{$id}' value='" . esc_attr( get_option( $id ) ) . "'>";
  }

  add_action( 'admin_init', function() {
    $options = [
      'tel'               =>  'Телефон',
      'tel_support'       =>  'Телефон тех. поддержки',
      'tel_marketing'     =>  'Телефон отдела продаж',
      'tel_repair'        =>  'Телефон сервисного центра',
      'tel_design'        =>  'Телефон конструкторского центра',
      'email'             =>  'E-mail',
      'address'           =>  'Адрес',
      'coords'            =>  'Координаты маркера на карте',
      'zoom'              =>  'Увеличение карты'
    ];

    foreach ($options as $id => $name) {
      $my_id = "contacts_{$id}";

      add_settings_field( $id, $name, 'options_inp_html', 'general', 'default', $my_id );
      register_setting( 'general', $my_id );
    }
  } );
