<?php
function online_matching() {
  if ( $_POST ) {
    $selected_system = $_POST['system'];
    // $meta_18555 = get_posts( ['post_type' => 'equipment', 'title' => 'МЕТА 18555' ] )[0];
    // $meta_18556_v = get_posts( ['post_type' => 'equipment', 'title' => 'МЕТА 18556 исп.&nbsp;В' ] )[0];
    // $meta_18556_n = get_posts( ['post_type' => 'equipment', 'title' => 'МЕТА 18556 исп.&nbsp;Н' ] )[0];
    // $meta_18556_y = get_posts( ['post_type' => 'equipment', 'title' => 'МЕТА 18556 исп.&nbsp;У' ] )[0];

    $meta_18555 = get_post( 5557 );
    $meta_18556_v = get_post( 5549 );
    $meta_18556_n = get_post( 13287 );
    $meta_18556_y = get_post( 5539 );

    $meta17555_19555 = [
      [
        'id' => $meta_18555->ID,
        'title' => $meta_18555->post_title,
        'img' => get_the_post_thumbnail_url( $meta_18555 ),
        'descr' => get_field( 'card_descr', $meta_18555 ) . ' <a href="' . get_post_permalink( $meta_18555->ID ) . '" target="_blank" class="hint__link">Подробнее</a>'
      ],
      [
        'id' => $meta_18556_v->ID,
        'title' => $meta_18556_v->post_title,
        'img' => get_the_post_thumbnail_url( $meta_18556_v ),
        'descr' => get_field( 'card_descr', $meta_18556_v ) . ' <a href="' . get_post_permalink( $meta_18556_v->ID ) . '" target="_blank" class="hint__link">Подробнее</a>'
      ],
      [
        'id' => $meta_18556_n->ID,
        'title' => $meta_18556_n->post_title,
        'img' => get_the_post_thumbnail_url( $meta_18556_n ),
        'descr' => get_field( 'card_descr', $meta_18556_n ) . ' <a href="' . get_post_permalink( $meta_18556_n->ID ) . '" target="_blank" class="hint__link">Подробнее</a>'
      ],
      [
        'id' => $meta_18556_y->ID,
        'title' => $meta_18556_y->post_title,
        'img' => get_the_post_thumbnail_url( $meta_18556_y ),
        'descr' => get_field( 'card_descr', $meta_18556_y ) . ' <a href="' . get_post_permalink( $meta_18556_y->ID ) . '" target="_blank" class="hint__link">Подробнее</a>'
      ]
    ];


    $meta17555_19555_step_1 = [
      'if' => [
        'Выберите тип оповещения (согласно СП3.13130.2012)' => '4 тип оповещения'          
      ],
      'title' => 'Выберите тип переговорных устройств',
      'breadcrumb' => 'Тип переговорных устройств',
      'fields' => [
        0 => [
          'type' => 'advanced-radio',
          'name' => 'intercoms-type',
          'error' => 'Выберите тип переговорных устройств',
          'values' => $meta17555_19555
        ]
      ]
    ];
    $meta17555_19555_step_2 = [
      'if' => [
        'Выберите тип оповещения (согласно СП3.13130.2012)' => '4 тип оповещения'          
      ],
      'title' => 'Укажите количество переговорных устройств ',
      'breadcrumb' => 'Количество переговорных устройств',
      'fields' => [
        0 => [
          'type' => 'number',
          'name' => 'intercoms-count',
          'error' => 'Введите количество от 1 до 320',
          'placeholder' => 'Введите количество от 1 до 320',
          'min' => 1,
          'step' => 1,
          'max' => 320
        ]
      ]
    ];

    $alert_type_3_hint = 'обязательно речевая система оповещения и установка световых оповещателей "ВЫХОД"';
    $alert_type_4_hint = 'обязательно речевая система оповещения и установка световых оповещателей "ВЫХОД", эвакуационные знаки пожарной безопасности, указывающие направление движения, разделение здания на зоны пожарного оповещения, обратная связь зон пожарного оповещения с помещением пожарного поста-диспетчерской.';

    if ( $selected_system === 'Система речевого оповещения СОЛОВЕЙ2' ) {
      $steps = [
        1 => [
          'title' => 'Выберите тип оповещения (согласно СП3.13130.2012)',
          'breadcrumb' => 'Тип оповещения',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'alert-type',
              'error' => 'Выберите тип оповещения',
              'values' => ['3 тип оповещения', '4 тип оповещения'],
              'hints' => [$alert_type_3_hint, $alert_type_4_hint]
            ]
          ]
        ],
        2 => [
          'title' => 'Введите количество зон оповещения',
          'breadcrumb' => 'Зоны оповещения',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-zones',
              'error' => 'Введите число от 1 до 24',
              'min' => 1,
              'max' => 24,
              'step' => 1,
              'placeholder' => 'Введите количество зон от 1 до 24',
              'field' => [
                'type' => 'number',
                'name' => 'alert-zone-%number%-power',
                'min' => 1,
                'step' => 1,
                'error' => 'Введите мощность для %number% зоны, Вт',
                'placeholder' => 'Введите мощность для %number% зоны, Вт'
              ]
            ]
          ]
        ],
        3 => [
          'title' => 'Выберите количество микрофонных пультов',
          'breadcrumb' => 'Микрофонные пульты',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'microphones',
              'error' => 'Выберите значение',
              'values' => ['Нет', '1', '2']
            ]
          ]
        ],
        4 => $meta17555_19555_step_1,
        5 => $meta17555_19555_step_2
      ];

    } elseif ( $selected_system === 'Система речевого оповещения на базе МЕТА 7122 М' ) {
      $steps = [
        1 => [
          'title' => 'Выберите тип оповещения (согласно СП3.13130.2012)',
          'breadcrumb' => 'Тип оповещения',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'alert-type',
              'error' => 'Выберите тип оповещения',
              'values' => ['3 тип оповещения', '4 тип оповещения'],
              'hints' => [$alert_type_3_hint, $alert_type_4_hint]
            ]
          ]
        ],
        2 => [
          'title' => 'Введите количество зон оповещения',
          'breadcrumb' => 'Зоны оповещения',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-zones',
              'error' => 'Введите число от 1 до 8',
              'min' => 1,
              'max' => 8,
              'step' => 1,
              'placeholder' => 'Введите количество зон от 1 до 8',
              'field' => [
                'type' => 'number',
                'name' => 'alert-zone-%number%-power',
                'error' => 'Введите мощность для %number% зоны до 200 Вт',
                'min' => 1,
                'step' => 1,
                'max' => 200,
                'total-amount' => 200,
                'placeholder' => 'Введите мощность для %number% зоны до 200 Вт',
                'total-amount-error' => 'Суммарная мощность оповещателей должна быть не более 200 Вт'
              ]
            ]
          ]
        ],
        3 => [
          'title' => 'Выберите количество микрофонных пультов',
          'breadcrumb' => 'Микрофонные пульты',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'microphones',
              'error' => 'Выберите значение',
              'values' => ['Нет', '1', '2']
            ]
          ]
        ],
        4 => $meta17555_19555_step_1,
        5 => $meta17555_19555_step_2
      ];

    } elseif ( $selected_system === 'Система речевого оповещения на базе МЕТА 17820/17821' ) {
      $steps = [
        1 => [
          'title' => 'Выберите тип оповещения (согласно СП3.13130.2012)',
          'breadcrumb' => 'Тип оповещения',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'alert-type',
              'error' => 'Выберите тип оповещения',
              'values' => ['3 тип оповещения', '4 тип оповещения'],
              'hints' => [$alert_type_3_hint, $alert_type_4_hint]
            ]
          ]
        ],
        2 => [
          'title' => 'Укажите необходимую мощность оповещателей',
          'breadcrumb' => 'Мощность оповещателей',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-power',
              'error' => 'Укажите общую мощность до 2500 Вт',
              'min' => 0,
              'max' => 2500,
              'placeholder' => 'Укажите общую мощность до 2500 Вт'
            ]
          ]
        ],
        3 => [
          'title' => 'Введите количество зон оповещения',
          'breadcrumb' => 'Зоны оповещения',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-zones',
              'error' => 'Введите количество зон от 1 до 40',
              'min' => 1,
              'max' => 40,
              'placeholder' => 'Введите количество зон от 1 до 40'
            ]
          ]
        ],
        4 => [
          'title' => 'Выберите количество микрофонных пультов',
          'breadcrumb' => 'Микрофонные пульты',
          'fields' => [
            0 => [
              'type' => 'select',
              'name' => 'microphones',
              'error' => 'Выберите значение',
              'placeholder' => 'Выберите количество из списка',
              'values' => ['Нет', '1', '2', '3', '4', '5', '6', '7', '8']
            ]
          ]
        ],
        5 => [
          'title' => 'Укажите необходимость системы светового оповещения',
          'breadcrumb' => 'Световое оповещение',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'light-alert',
              'error' => 'Выберите значение',
              'values' => ['Да', 'Нет']
            ]
          ]
        ],
        6 => [
          'title' => 'Укажите необходимость удаленного управления и мониторинга по IP-сети с помощью ПАК МЕТА-СЕТЬ',
          'breadcrumb' => 'Удаленное управление и мониторинг',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'distance-control',
              'error' => 'Выберите значение',
              'values' => ['Да', 'Нет']
            ]
          ]
        ],
        7 => $meta17555_19555_step_1,
        8 => $meta17555_19555_step_2
      ];
    } elseif ( $selected_system === 'Система речевого оповещения на базе МЕТА 19830' ) {
      $steps = [
        1 => [
          'title' => 'Выберите тип оповещения (согласно СП3.13130.2012)',
          'breadcrumb' => 'Тип оповещения',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'alert-type',
              'error' => 'Выберите тип оповещения',
              'values' => ['3 тип оповещения', '4 тип оповещения'],
              'hints' => [$alert_type_3_hint, $alert_type_4_hint]
            ]
          ]
        ],
        2 => [
          'title' => 'Введите количество зон оповещения',
          'breadcrumb' => 'Зоны оповещения',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-zones',
              'error' => 'Введите число от 1 до 40',
              'min' => 1,
              'max' => 40,
              'step' => 1,
              'placeholder' => 'Введите количество зон от 1 до 40'
            ]
          ]
        ],
        3 => [
          'title' => 'Укажите необходимую мощность оповещателей',
          'breadcrumb' => 'Мощность оповещателей',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-power',
              'error' => 'Укажите общую мощность до 4000 Вт',
              'min' => 1,
              'max' => 4000,
              'placeholder' => 'Укажите общую мощность до 4000 Вт'
            ]
          ]
        ],
        4 => [
          'title' => 'Выберите количество микрофонных пультов',
          'breadcrumb' => 'Микрофонные пульты',
          'fields' => [
            0 => [
              'type' => 'select',
              'name' => 'microphones',
              'error' => 'Выберите значение',
              'placeholder' => 'Выберите количество из списка',
              'values' => ['Нет', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16']
            ]
          ]
        ],
        5 => [
          'title' => 'Укажите необходимость музыкальной трансляции',
          'breadcrumb' => 'Музыкальная трансляция',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'music',
              'error' => 'Выберите значение',
              'values' => ['Да', 'Нет']
            ]
          ]
        ],
        6 => [
          'title' => 'Укажите необходимость системы светового оповещения',
          'breadcrumb' => 'Световое оповещение',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'light-alert',
              'error' => 'Выберите значение',
              'values' => ['Да', 'Нет']
            ]
          ]
        ],
        7 => [
          'title' => 'Укажите необходимость удаленного управления и мониторинга по IP-сети с помощью ПАК МЕТА-СЕТЬ',
          'breadcrumb' => 'Удаленное управление и мониторинг',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'distance-control',
              'error' => 'Выберите значение',
              'values' => ['Да', 'Нет']
            ]
          ]
        ],
        8 => $meta17555_19555_step_1,
        9 => $meta17555_19555_step_2
      ];
    } elseif ( $selected_system === 'Система оповещения обеспечения транспортной безопасности и СОУЭ' ) {
      $steps = [
        1 => [
          'title' => 'Выберите тип оповещения (согласно СП3.13130.2012)',
          'breadcrumb' => 'Тип оповещения (СОУЭ)',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'alert-type',
              'error' => 'Выберите тип оповещения',
              'values' => ['3 тип оповещения', '4 тип оповещения'],
              'hints' => [$alert_type_3_hint, $alert_type_4_hint]
            ]
          ]
        ],
        2 => [
          'title' => 'Выберите тип оповещения',
          'breadcrumb' => 'Тип оповещения',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'room-type',
              'error' => 'Выберите тип оповещения',
              'values' => ['Приобъектовое оповещение', 'Внутриобъектовое', 'Внутриобъектовое и приобъектовое'],
              'hints' => ['Уличное', 'оповещение отапливаемых помещений']
            ]
          ]
        ],
        3 => [
          'if' => [
            'Выберите тип оповещения' => 'Внутриобъектовое'          
          ],
          'title' => 'Укажите суммарную мощность оповещателей для отапливаемых помещений (до 20 000 Вт)',
          'breadcrumb' => 'Мощность внутриобъектовых оповещателей',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-power-for-warm-room',
              'error' => 'Укажите общую мощность до 20 000 Вт',
              'min' => 1,
              'max' => 20000,
              'placeholder' => 'Укажите общую мощность до 20 000 Вт'
            ]
          ]
        ],
        4 => [
          'if' => [
            'Выберите тип оповещения' => 'Приобъектовое'          
          ],
          'title' => 'Укажите суммарную мощность оповещателей для уличного оповещения (до 20 000 Вт)',
          'breadcrumb' => 'Мощность уличных оповещателей',
          'fields' => [
            0 => [
              'type' => 'number',
              'name' => 'alert-power-for-street',
              'error' => 'Укажите общую мощность до 20 000 Вт',
              'min' => 1,
              'max' => 20000,
              'placeholder' => 'Укажите общую мощность до 20 000 Вт'
            ]
          ]
        ],
        5 => [
          'title' => 'Укажите необходимость совмещения системы транспортной безопасности и СОУЭ',
          'breadcrumb' => 'Совмещение систем',
          'fields' => [
            0 => [
              'type' => 'radio',
              'name' => 'combine-systems',
              'error' => 'Выберите значение',
              'values' => ['Да', 'Нет']
            ]
          ]
        ],
        6 => [
          'title' => 'Выберите количество микрофонных пультов',
          'breadcrumb' => 'Микрофонные пульты',
          'fields' => [
            0 => [
              'type' => 'select',
              'name' => 'microphones',
              'error' => 'Выберите значение',
              'placeholder' => 'Выберите количество из списка',
              'values' => ['Нет', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20']
            ]
          ]
        ],
        7 => $meta17555_19555_step_1,
        8 => $meta17555_19555_step_2
      ];
    }
    echo json_encode( $steps );
  } else {
    // Показываем первый шаг
    global $template_directory;
    $systems = [
      0 => [
        'img' => $template_directory . '/img/om-solovei2.jpg',
        'title' => 'Система речевого оповещения СОЛОВЕЙ2',
        'descr' => 'Оптимально подходит для небольших и средних по площади объектов. (Детские сады, школы, административные здания, поликлиники и пр.).',
        'list' => [
          'Исполнение — настенное',
          'Мощность системы — от 50&nbsp;Вт',
          'Напряжение ЛО — 30&nbsp;В',
          'Количество зон — до&nbsp;24',
          'Количество сообщений — 2',
          'Оповещение ГО и ЧС — да',
          'Количество микрофонных пультов — до&nbsp;2',
          'Трансляция музыки — да'
        ]
      ],
      1 => [
        'img' => $template_directory . '/img/om-meta17820.jpg',
        'title' => 'Система речевого оповещения на базе МЕТА 17820/17821',
        'descr' => 'Оптимально подходит для средних и больших по площади объектов (Детские сады, школы, административные здания, больницы, бизнес-центры, физкультурно-оздоровительные центры и пр.).',
        'list' => [
          'Исполнение — настенное',
          'Мощность системы — от 200 Вт до 2500 Вт',
          'Напряжение ЛО — 100&nbsp;В',
          'Количество зон — от 8 до 40',
          'Количество сообщений — 2',
          'Оповещение ГО и ЧС — да',
          'Количество микрофонных пультов — до&nbsp;2',
          'Трансляция музыки — да'
        ]
      ],
      2 => [
        'img' => $template_directory . '/img/om-meta1722.jpg',
        'title' => 'Система речевого оповещения на базе МЕТА 7122 М',
        'descr' => 'Оптимально подходит для средних объектов (Детские сады, школы, административные здания, поликлиники, больницы и пр.).',
        'list' => [
          'Исполнение — настенное',
          'Мощность системы — 200 Вт',
          'Напряжение ЛО — 100 В',
          'Количество зон — 8',
          'Количество сообщений — 2',
          'Оповещение ГО и ЧС — да',
          'Количество микрофонных пультов — до 2',
          'Трансляция музыки — да'
        ]
      ],
      3 => [
        'img' => $template_directory . '/img/om-meta19830.jpg',
        'title' => 'Система речевого оповещения на базе МЕТА 19830',
        'descr' => 'Оптимально подходит для средних и больших объектов (Бизнес-центры, торговые центры, выставочные павильоны, крупные спортивные объекты, в качестве громкоговорящей (поисково-технической) связи на производственных объектах и многие другие).',
        'list' => [
          'Исполнение — стоечное 19"',
          'Мощность системы — 125 Вт — 20 000 Вт',
          'Напряжение ЛО — 100 В',
          'Количество зон — от 8 до 40',
          'Количество сообщений — 2',
          'Оповещение ГО и ЧС — да',
          'Количество микрофонных пультов — до 16',
          'Трансляция музыки — да'
        ]
      ],
      4 => [
        'img' => $template_directory . '/img/om-trs.jpg',
        'title' => 'Система оповещения обеспечения транспортной безопасности и СОУЭ',
        'descr' => 'Подходит для средних и больших объектов (Бизнес-центры, торговые центры, выставочные павильоны, крупные спортивные объекты, в качестве ГГС на крупных производственных объектах и многие другие).',
        'list' => [
          'Исполнение — стоечное 19"',
          'Мощность системы — до 20 000 Вт',
          'Напряжение ЛО — 100 В',
          'Количество зон — 20',
          'Количество сообщений — 1',
          'Оповещение ГО и ЧС — да',
          'Количество микрофонных пультов — до 4',
          'Трансляция музыки — да'
        ]
      ]
    ];
  }

  if ( $_POST ) {
    die();
  }
}

function recalculate_power_from_number( $power, ...$numbers ) {
  // Создаем массив для сбора повторений чисел
  $response = array_reduce( $numbers, function( $carry, $item ) {
    $carry[ $item ] = 0;
    return $carry;
  } );
  
  // Получаем временное значение для определения кол-ва самого большого числа
  $temp_val = $power / $numbers[0];
  
  if ( $temp_val === intval( $temp_val ) ) {
    $response[ $numbers[0] ] = $temp_val;
  } else {
    $response[ $numbers[0] ] = (int) floor( $temp_val );
    $temp_val = $power - $response[ $numbers[0] ] * $numbers[0];
    
    // Число условий, которые будут создаваться для проверки чисел (самое первое число не считается)
    $conditions_count = count( $numbers ) - 1;
    
    // Кол-во совпадений для цикла, всегда должно быть только одно совпадение
    $matches = 0;

    
    for ( $i = 0; $i < $conditions_count; $i++ ) {
      // Проверяем должно ли быть следующее условие
      if ( $i + 1 < $conditions_count ) {
        $condition = $temp_val > $numbers[ $i + 2 ];
      } else {
        $condition = 1;
      }
      // Проверяем само условие
      if ( $temp_val <= $numbers[ $i + 1 ] && $condition ) {
        // Если есть совпадение, то прибавляем 1
        $response[ $numbers[ $i + 1 ] ] = 1;
        $matches = 1;
        break;
      } else {
        // Если сейчас последняя итерация цикла
        if ( $condition === 1 ) {
          $response[ $numbers[0] ] += 1;
        }
      }
    }
  }
  return $response;
}

// Функция подсчета сколько раз числа содержатся в другом числе
function recalculate_power( $array_power, $n1, $n2) {
  $arr = [
    $n1 => 0,
    $n2 => 0
  ];
    
  foreach ( $array_power as $key => $val ) {
    $temp_val = $val / $n1;

    if ( $temp_val == intval( $temp_val ) ) {
      $by_n1 = $temp_val;
      $by_n2 = 0;
    } else {
      $by_n1 = (int) floor( $temp_val );
      $by_n2 = $temp_val - $by_n1;
        
      if ( $by_n2 <= 0.5 ) {
        $by_n2 = 1;
      } else {
        $by_n1 += 1;
        $by_n2 = 0;
      }
    }

    $arr[$n1] += $by_n1;
    $arr[$n2] += $by_n2;
  }
  
  return $arr;
}


function parse_params( $post, $zones=null ) {
  if ( $zones ) {
    $zones_values = array_values( $zones );
    $zones_count_string = implode ( ', ', $zones_values );
    $zones_sum = array_reduce ( $zones_values, function( $carry, $item ) {
      $carry += $item;
      return $carry;
    } );
  }

  $microphones_words = ['микрофонный пульт', 'микрофонных пульта', 'микрофонных пультов'];
  $zones_words = ['зона', 'зоны', 'зон'];

  $response = [
    'params' => '',
    'response' => []
  ];

  // Разбор данных в список результата (система ...... название)
  foreach ( $post as $key => $val ) {
    if ( $key === 'system' ) {
      $left = 'Система';
      $right = $val;
    } elseif ( $key === 'alert-type' ) {
      $left = 'Тип оповещения';
      $right = $val;
      if ( $post['room-type'] ) {
        $right .= ', ' . mb_strtolower( $post['room-type'] );
      }
    } elseif ( $key === 'alert-power-for-warm-room' && $val > 0 ) {
      $left = 'Общая мощность внутриобъектовых оповещателей';
      $right = $val . ' Вт';
    } elseif ( $key === 'alert-power-for-street' && $val > 0 ) {
      $left = 'Общая мощность уличных оповещателей';
      $right = $val . ' Вт';
    } elseif ( $key === 'combine-systems' ) {
      $left = 'Совмещение системы транспортной безопасности и СОУЭ';
      $right = $val;
    } elseif ( $key === 'alert-zones' ) {

      $left = 'Количество зон оповещения';
      $end = $zones_words[($val % 100 > 4 && $val % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][($val % 10 < 5) ? $val % 10 : 5]];
      $right = $val . ' ' . $end;
      if ( !$post['alert-power'] ) {
        $right .= ' (' . $zones_count_string . ')';
      }

    } elseif ( $key === 'alert-zone-1-power' ) {
      $left = 'Мощность оповещения';
      $right = $zones_sum . ' Вт';
    } elseif ( $key === 'alert-power' ) {
      $left = 'Общая мощность оповещателей';
      $right = $val . ' Вт';
    } elseif ( $key === 'microphones' ) {
      $left = 'Количество микрофонных пультов';
      if ( $val !== 'Нет' ) {
        $end = $microphones_words[($val % 100 > 4 && $val % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][($val % 10 < 5) ? $val % 10 : 5]];
      }
      $right = $val . ' ' . $end;
    } elseif ( $key === 'intercoms-type' ) {
      $left = 'Тип переговорных устройств';
      $right = $val;
    } elseif ( $key === 'intercoms-count' && $val > 0 ) {
      $left = 'Количество переговорных устройств';
      $right = $val . ' шт';
    } elseif ( $key === 'light-alert' ) {
      $left = 'Световое оповещение';
      $right = $val;
    } elseif ( $key === 'music' ) {
      $left = 'Музыкальная трансляция';
      $right = $val;
    } elseif ( $key === 'distance-control' ) {
      $left = 'Управление и мониторинг с помощью ПАК МЕТА-СЕТЬ';
      $right = $val;
    }

    if ( $left && $right ) {
      $response['params'] .= create_result_row( $left, $right );
      $response['response'][ $left ] = $right;
      if ( $key === 'distance-control' ) {
        $response['params'] .= create_result_row( 'Программное обеспечение МЕТА-СЕТЬ', $right );
        $response['response'][ 'Программное обеспечение МЕТА-СЕТЬ' ] = $right;
      }
    }

    unset( $left );
    unset( $right );
    unset( $end );
    unset( $row );
  }

  return $response;
}

function calculate_u( $unit ) {
  $element = [
    'count' => 1,
    'zones' => 0
  ];
  
  if ( $unit <= 24 ) {
    $element['zones'] = 24;
  } elseif ( $unit > 24 && $unit <= 33 ) {
    $element['zones'] = 33;
  } elseif ( $unit > 33 && $unit <= 42 ) {
    $element['zones'] = 42;
  } elseif ( $unit > 42 && $unit <= 48 ) {
    $element['zones'] = 48;
  } elseif ( $unit > 48 ) {
    $unit -= 48;
    $element['zones'] = 48;
    $extra_element = calculate_u( $unit );
  }
  
  $arr[] = $element;
  
  if ( isset( $extra_element ) ) {
    $arr = array_merge( $arr, $extra_element );
  }
    
  return $arr;
}

function parse_products( $products ) {
  global $template_directory;
  $response = [
    'products' => '',
    'params' => '',
    'response' => []
  ];

  foreach ( $products as $product ) {
    if ( $product->count > 0 ) {
      $product_title = get_field( 'full_title', $product );

      if ( $product->post_title === 'МЕТА 17820' || $product->post_title === 'МЕТА 17821' ) {
        $product_title = preg_replace( '/МЕТА.*/', $product->post_title, $product_title );
      }
      
      if ( !$product_title ) {
        $product_title = get_the_title( $product );
      }
      // Картинка или заглушка
      $product_thumb = get_the_post_thumbnail_url( $product );

      if ( !$product_thumb ) {
        $product_thumb = $template_directory . '/img/img-placeholder.svg';
      }
      // Формируем отрывок
      $product_excerpt = get_field( 'card_descr', $product );

      if ( !$product_excerpt ) {
        $product_excerpt = get_field( 'card_descr', $product->ID );
      }

      if ( !$product_excerpt ) {
        $product_excerpt = get_field( 'descr', $product );
        if ( !$product_excerpt ) {
          $product_excerpt = get_field( 'descr', $product->ID );
        }
      }
      
      $product_excerpt = get_excerpt( [
        'maxchar'   =>  100,
        'ignore_more' => true,
        'autop' => false,
        'text' =>  $product_excerpt
      ] );

      $response['products'] .= '<a href="' . get_the_permalink( $product ) . '" class="online-matching__product product">
        <img src="' . $product_thumb . '" alt="' . $product_title . '" class="product__img">
        <span class="product__title">' . $product_title . '</span>
        <p class="product__descr">' . $product_excerpt . '</p>
        <span class="product__link">Подробнее...</span>
      </a>';

      $response['params'] .= create_result_row( $product_title, $product->count . ' шт' );
      $response['response'][ $product_title ] = $product->count . ' шт';
    }
  }

  return $response;
}

function parse_intercoms( $intercoms_count, $intercoms_type, $ibp ) {
  $response = [
    'ibp' => 0,
    'params' => '',
    'products' => [],
    'response' => []
  ];

  if ( $ibp->post_title === 'СОЛОВЕЙ2-ИБП' ) {
    // $i_1 = get_posts( [
    //   'post_type' => 'equipment',
    //   'title' => 'МЕТА 17555'
    // ] )[0];
    // $i_2 = get_posts( [
    //   'post_type' => 'equipment',
    //   'title' => 'МЕТА 17556'
    // ] )[0];
    $i_1 = get_post( 13269 );
    $i_2 = get_post( 6796 );
  } else {
    // $i_1 = get_posts( [
    //   'post_type' => 'equipment',
    //   'title' => 'МЕТА 19555'
    // ] )[0];
    // $i_2 = get_posts( [
    //   'post_type' => 'equipment',
    //   'title' => 'МЕТА 19556'
    // ] )[0];
    $i_1 = get_post( 5523 );
    $i_2 = get_post( 5531 );
  }

  $intercoms = get_post( $intercoms_type );

  // $intercoms = get_posts( [
  //   'post_type' => 'equipment',
  //   'title' => preg_replace( '/\sисп\.\s/', ' исп.&nbsp;', $intercoms_type )
  // ] )[0];

  $intercoms->count = $intercoms_count;

  $ibp->count += ceil( $intercoms_count / 40 );

  $i_1->count = 1;

  if ( $intercoms_count > 40 ) {
    $i_2->count = ceil( $intercoms_count / 40 ) - 1;
  }

  $response['ibp'] = $ibp;
  $response['products'][] = $intercoms;
  $response['products'][] = $i_1;
  $response['products'][] = $i_2;
  // $response['products'][] = $ibp;

  return $response;
}

function create_result_row( $left, $right ) {
  return '<div class="online-matching__result-row"><span class="online-matching__resul-row-left">' . $left . '</span><span class="online-matching__resul-row-dots"></span><span class="online-matching__resul-row-right">' . $right . '</span></div>';
}

function parse_docs( $system_docs ) {
  foreach ( $system_docs as $docs ) {
    foreach ( $docs['files'] as $file ) {
      $new_docs[ 'docs' ][] = $file;
    }
  }

  return $new_docs;
}

function online_matching_get_results() {
  if ( $_POST ) {
    $system = $_POST['system'];
    $alert_type = $_POST['alert-type'];
    $alert_zones = $_POST['alert-zones'];
    $alert_power = $_POST['alert-power'];
    $microphones = $_POST['microphones'];
    $intercoms_type = $_POST['intercoms-type'];
    $intercoms_count = $_POST['intercoms-count'];
    $music = $_POST['music'];
    $light_alert = $_POST['light-alert'];
    $distance_control = $_POST['distance-control'];

    $zones = array_filter ( $_POST, function( $key ) {
        return strpos( $key, 'alert-zone-' ) !== false;
    }, ARRAY_FILTER_USE_KEY );

    $products = [];

    // $Product = new Product( null );

    if ( mb_stripos( $system, 'соловей2' ) !== false ) {

      // $solovei_by_50 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'СОЛОВЕЙ2-БУ1-50, СОЛОВЕЙ2-БУ1-100'
      // ] )[0];
      // $solovei_by_100 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'СОЛОВЕЙ2-БУ1-50, СОЛОВЕЙ2-БУ1-100'
      // ] )[0];
      // $ibp = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'СОЛОВЕЙ2-ИБП'
      // ] )[0];
      // $solovei_mp = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'СОЛОВЕЙ-МП'
      // ] )[0];

      $solovei_by_50 = get_post( 423 );
      $solovei_by_100 = get_post( 423 );
      $ibp = get_post( 4783 );
      $solovei_mp = get_post( 4799 );


      // Документы и схемы
      $system_docs = get_field( 'product_docs', $solovei_by_50 );
      $system_scehems = get_field( 'schemes', $solovei_by_50 );

      $system_docs = parse_docs( $system_docs );

      $solovei_by_50->post_title = 'СОЛОВЕЙ2-БУ1-50';
      $solovei_by_100->post_title = 'СОЛОВЕЙ2-БУ1-100';

      $power = recalculate_power( $zones, 100, 50);

      $solovei_by_50->count = $power[50];
      $solovei_by_100->count = $power[100];
      $ibp->count = $solovei_by_50->count + $solovei_by_100->count;
      $akb_18a_12v_count = 0;

      if ( $microphones > 0 ) {
        if ( $microphones == 1 ) {
          $suffix = '01';
        } elseif ( $microphones > 1 && $microphones <= 4 ) {
          $suffix = '04';
        } elseif ( $microphones > 4 && $microphones <= 8 ) {
          $suffix = '08';
        } elseif ( $microphones > 8 && $microphones <= 16 ) {
          $suffix = '16';
        } elseif ( $microphones > 16 && $microphones <= 24 ) {
          $suffix = '24';
        }
        $solovei_mp->post_title .= '-' . $suffix;
        $solovei_mp->count = $microphones;
      }

      if ( $intercoms_type && $intercoms_count ) {
        $parsed_intercoms = parse_intercoms( $intercoms_count, $intercoms_type, $ibp );
        $ibp = $parsed_intercoms['ibp'];
        $products = $parsed_intercoms['products'];
      }

      if ( $ibp->count > 0 ) {
        $akb_18a_12v_count += $ibp->count * 2;
      }

      $products[] = $solovei_by_50;
      $products[] = $solovei_by_100;
      $products[] = $solovei_mp;
      $products[] = $ibp;

      $parsed_products = parse_products( $products );
      $parsed_params = parse_params( $_POST, $zones );

      $response['products'] = $parsed_products['products'];
      $response['params'] = $parsed_params['params'] . '<div class="online-matching__result-separator">Рекомендованное оборудование</div>' . $parsed_products['params'] . $parsed_intercoms['params'];
      $response['response'] = array_merge( $parsed_params['response'], $parsed_products['response'] );

      if ( $akb_18a_12v_count > 0 ) {
        $response['params'] .= create_result_row( 'АКБ 18 А*ч, 12В', $akb_18a_12v_count . ' шт' );
        $response['response'][ 'АКБ 18 А*ч, 12В' ] = $akb_18a_12v_count . ' шт';
      }

      $response['docs'] = json_encode( $system_docs );
      $response['schemes'] = json_encode( $system_scehems );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . site_url() .'/equipments/opoveshhateli-pozharnye-rechevye-asr/" target="_blank" class="link link_blue">Оповещатели пожарные речевые</a> (30&nbsp;В)' );

    } elseif ( mb_stripos( $system, '7122' ) !== false ) {
      // $meta7122m = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 7122М'
      // ] )[0];
      // $meta7712 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 7712'
      // ] )[0];
      // $meta18580 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 18580'
      // ] )[0];
      // $ibp = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'СОЛОВЕЙ2-ИБП'
      // ] )[0];

      $meta7122m = get_post( 4099 );
      $meta7712 = get_post( 4117 );
      $meta18580 = get_post( 4109 );
      $ibp = get_post( 4783 );

      $system_docs = get_field( 'product_docs', $meta7122m );
      $system_scehems = get_field( 'schemes', $meta7122m );

      $system_docs = parse_docs( $system_docs );

      $meta7122m->count = 1;
      $meta7712->count = 1;
      $ibp->count = 0;
      $akb_18a_12v_count = 0;
      $akb_7a_12v_count = $meta7712->count * 4;
      if ( $microphones > 0 ) {
        $meta18580->post_title .= '-8';
        $meta18580->count = $microphones;
      }

      if ( $intercoms_type && $intercoms_count ) {
        $parsed_intercoms = parse_intercoms( $intercoms_count, $intercoms_type, $ibp );
        $ibp = $parsed_intercoms['ibp'];
        $products = $parsed_intercoms['products'];
      }

      $products[] = $meta7122m;
      $products[] = $meta7712;
      $products[] = $meta18580;
      $products[] = $ibp;

      if ( $ibp->count > 0 ) {
        $akb_18a_12v_count += $ibp->count * 2; // для ИБП
      }

      $parsed_products = parse_products( $products );
      $parsed_params = parse_params( $_POST, $zones );

      $response['products'] = $parsed_products['products'];
      $response['params'] = $parsed_params['params'] . '<div class="online-matching__result-separator">Рекомендованное оборудование</div>' . $parsed_products['params'] . $parsed_intercoms['params'];
      $response['response'] = array_merge( $parsed_params['response'], $parsed_products['response'] );

      if ( $akb_18a_12v_count > 0 ) {
        $response['params'] .= create_result_row( 'АКБ 18 А*ч, 12В', $akb_18a_12v_count . ' шт' );
        $response['response'][ 'АКБ 18 А*ч, 12В' ] = $akb_18a_12v_count . ' шт';
      }

      if ( $akb_7a_12v_count > 0 ) {
        $response['params'] .= create_result_row( 'АКБ 7 А*ч, 12В', $akb_7a_12v_count . ' шт' );
        $response['response'][ 'АКБ 7 А*ч, 12В' ] = $akb_7a_12v_count . ' шт';
      }

      $response['docs'] = json_encode( $system_docs );
      $response['schemes'] = json_encode( $system_scehems );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . site_url() .'/equipments/opoveshhateli-pozharnye-rechevye-asr-ispolnenie-3/" target="_blank" class="link link_blue">Оповещатели пожарные речевые исп.&nbsp;3</a>' );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . get_term_link( 49, 'equipments' ) . '" target="_blank" class="link link_blue">Громкоговорители рупорные МЕТА исп.&nbsp;3</a>' );


    } elseif ( mb_stripos( $system, '17820' ) !== false ) {

      // $meta17820 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 17820, МЕТА 17821'
      // ] )[0];
      // $meta17821 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 17820, МЕТА 17821'
      // ] )[0];
      // $meta17901 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 17901'
      // ] )[0];
      // // Микрофон и сопуствующие
      // $meta18580 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 18580'
      // ] )[0];
      // $meta17426 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 17426'
      // ] )[0];
      // $ibp = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'СОЛОВЕЙ2-ИБП'
      // ] )[0];
      // // Световое оповещение
      // $meta17016 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 17016'
      // ] )[0];
      // // Упр. и мониторинг с пак мета-сеть
      // $meta7314 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 7314'
      // ] )[0];

      $meta17820 = get_post( 5432 );
      $meta17821 = get_post( 5432 );
      $meta17901 = get_post( 6780 );
      // Микрофон и сопуствующие
      $meta18580 = get_post( 4109 );
      $meta17426 = get_post( 9898 );
      $ibp = get_post( 4783 );
      // Световое оповещение
      $meta17016 = get_post( 4816 );
      // Упр. и мониторинг с пак мета-сеть
      $meta7314 = get_post( 9977 );

      $system_docs = get_field( 'product_docs', $meta17820 );
      $system_scehems = get_field( 'schemes', $meta17820 );

      $system_docs = parse_docs( $system_docs );

      $meta17820->post_title = 'МЕТА 17820';
      $meta17821->post_title = 'МЕТА 17821';

      $zones = [ 'alert-power' => $_POST['alert-power'] ];

      // $power = recalculate_power( $zones, 500, 200 );

      $power = recalculate_power_from_number( $_POST['alert-power'], 500, 200 );

      $meta17820->count = $power[200];
      $meta17821->count = $power[500];
      $ibp->count = 0;

      $alert_zones_diff = $alert_zones / 8;

      if ( $alert_zones_diff > $meta17820->count + $meta17821->count ) {
        $diff = ceil( $alert_zones_diff - $meta17820->count - $meta17821->count );
        if ( $meta17820->count >= $meta17821->count ) {
          $meta17820->count += $diff;
        } else {
          $meta17821->count += $diff;
        }
      }

      $meta17901->count = $meta17820->count + $meta17821->count;

      if ( $microphones > 0 ) {
        $meta18580->count = $microphones;

        if ( $microphones >= 3 ) {
          $meta17426->count = 1;
          $ibp->count = 1;
        }

        if ( $alert_zones <= 8 ) {
          $meta18580->post_title .= '-8';
        } elseif ( $alert_zones > 8 && $alert_zones <= 16 ) {
          $meta18580->post_title .= '-16';
        } elseif ( $alert_zones > 16 && $alert_zones <= 24 ) {
          $meta18580->post_title .= '-24';
        } elseif ( $alert_zones > 24 && $alert_zones <= 32 ) {
          $meta18580->post_title .= '-32';
        } elseif ( $alert_zones > 32 && $alert_zones <= 40 ) {
          $meta18580->post_title .= '-40';
        }
      }

      if ( $intercoms_type && $intercoms_count ) {
        $parsed_intercoms = parse_intercoms( $intercoms_count, $intercoms_type, $ibp );
        $ibp = $parsed_intercoms['ibp'];
        $products = $parsed_intercoms['products'];
      }

      if ( $ibp->count > 0 ) {
        $akb_18a_12v_count = $ibp->count * 2; // для ИБП
      }
      $akb_26a_12v_count = $meta17820->count * 2;
      $abk_40a_12v_count = $meta17821->count * 2;

      if ( $light_alert && $light_alert === 'Да' ) {
        $meta17016->count = 1;
      }

      if ( $distance_control && $distance_control === 'Да' ) {
        $meta7314->count = 1;
      }

      $products[] = $meta17820;
      $products[] = $meta17821;
      $products[] = $meta17901;

      $products[] = $meta18580;
      $products[] = $meta17426;

      $products[] = $meta17016;
      $products[] = $meta7314;

      $products[] = $ibp;

      $parsed_products = parse_products( $products );
      $parsed_params = parse_params( $_POST, $zones );

      $response['products'] = $parsed_products['products'];
      $response['params'] = $parsed_params['params'] . '<div class="online-matching__result-separator">Рекомендованное оборудование</div>' . $parsed_products['params'] . $parsed_intercoms['params'];
      $response['response'] = array_merge( $parsed_params['response'], $parsed_products['response'] );

      if ( $akb_18a_12v_count ) {
        $response['params'] .= create_result_row( 'АКБ 18 А*ч, 12В', $akb_18a_12v_count . ' шт' );
        $response['response'][ 'АКБ 18 А*ч, 12В' ] = $akb_18a_12v_count . ' шт';
      }

      if ( $akb_26a_12v_count ) {
        $response['params'] .= create_result_row( 'АКБ 26 А*ч, 12В', $akb_26a_12v_count . ' шт' );
        $response['response'][ 'АКБ 26 А*ч, 12В' ] = $akb_26a_12v_count . ' шт';
      }

      if ( $abk_40a_12v_count ) {
        $response['params'] .= create_result_row( 'АКБ 40 А*ч, 12В', $abk_40a_12v_count . ' шт' );
        $response['response'][ 'АКБ 40 А*ч, 12В' ] = $abk_40a_12v_count . ' шт';
      }

      $response['docs'] = json_encode( $system_docs );
      $response['schemes'] = json_encode( $system_scehems );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . site_url() .'/equipments/opoveshhateli-pozharnye-rechevye-asr-ispolnenie-3/" target="_blank" class="link link_blue">Оповещатели пожарные речевые исп.&nbsp;3</a>' );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . get_term_link( 49, 'equipments' ) . '" target="_blank" class="link link_blue">Громкоговорители рупорные МЕТА исп.&nbsp;3</a>' );

    } elseif ( mb_stripos( $system, '19830' ) !== false ) {

      // $meta19830 =get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 19830'
      // ] )[0];
      // $meta9154 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9154'
      // ] )[0];
      // $meta9709 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9709'
      // ] )[0];
      // $meta9716 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9716'
      // ] )[0];
      // $meta9923 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9923'
      // ] )[0];
      // $meta9701 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9701'
      // ] )[0];
      // $meta18580 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 18580'
      // ] )[0];
      // $meta19426 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 19426'
      // ] )[0];
      // $meta19580 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 19580'
      // ] )[0];
      // $meta9210 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9210'
      // ] )[0];
      // $cdr3000 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'CDR-3000'
      // ] )[0];
      // $meta19016 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 19016'
      // ] )[0];
      // $meta9314 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9314'
      // ] )[0];
      // // Шкаф
      // $meta4901 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 4901'
      // ] )[0];
      // $meta9901 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9901'
      // ] )[0];
      // $meta9910 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9910'
      // ] )[0];
      // $meta9919 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9919'
      // ] )[0];
      // $meta9717 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9717'
      // ] )[0];

      $meta19830 = get_post( 6786 );
      $meta9154 = get_post( 9857 );
      $meta9709 = get_post( 9879 );
      $meta9716 = get_post( 6804 );
      $meta9923 = get_post( 13307 );
      $meta9701 = get_post( 7734 );
      $meta18580 = get_post( 4109 );
      $meta19426 = get_post( 9891 );
      $meta19580 = get_post( 7683 );
      $meta9210 = get_post( 9873 );
      $cdr3000 = get_post( 13315 );
      $meta19016 = get_post( 4824 );
      $meta9314 = get_post( 9180 );
      // Шкаф
      $meta4901 = get_post( 13310 );
      $meta9901 = get_post( 10158 );
      $meta9910 = get_post( 9885 );
      $meta9919 = get_post( 13305 );
      $meta9717 = get_post( 6774 );

      $system_docs = get_field( 'product_docs', $meta19830 );
      $system_scehems = get_field( 'schemes', $meta19830 );

      $system_docs = parse_docs( $system_docs );

      // Сумма высоты
      $u = 0;

      // Вместо ИБП
      // $meta9716 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9716'
      // ] )[0];

      $meta9716 = get_post( 6804 );

      $meta9716->count = 0;

      // Каждые 8 зон добавляется 1 мета19830
      $meta19830->count = ceil( $alert_zones / 8 );
      // Каждому мета19830 добавляется 1 мета9154
      // $meta9154->count = $meta19830->count;
      
      // Каждому мета19830 добавляется 1 мета9716
      $meta9716->count = $meta19830->count;
      // Каждому мета9716 добавляется 1 мета9923
      $meta9923->count = $meta9716->count;

      // Каждые 500 Вт добавялем 1 мета9154, без учета уже добавленных
      $meta9154->count = $meta19830->count + ceil( ($alert_power - 500 * $meta19830->count) / 500 );

      // Каждому мета9154 добавляется 1 мета9709
      $meta9709->count = $meta9154->count;

      $akb_7a_12v_count = $meta9709->count * 8;

      // Каждые 3 мета9154 добавляется 1 мета9701
      $meta9701->count = ceil( $meta9154->count / 3 );

      $meta9923->count = $meta9154->count + $meta9701->count + $meta9709->count;

      if ( $intercoms_type && $intercoms_count ) {
        $parsed_intercoms = parse_intercoms( $intercoms_count, $intercoms_type, $meta9716 );
        $meta9716 = $parsed_intercoms['ibp'];
        $products = $parsed_intercoms['products'];
      }

      if ( $meta9716->count > 0 ) {
        $akb_12a_12v_count = $meta9716->count * 2;
      }

      if ( $microphones > 0 ) {
        $meta18580->count = $microphones;

        if ( $alert_zones <= 8 ) {
          $meta18580->post_title .= '-8';
        } elseif ( $alert_zones > 8 && $alert_zones <= 16 ) {
          $meta18580->post_title .= '-16';
        } elseif ( $alert_zones > 16 && $alert_zones <= 24 ) {
          $meta18580->post_title .= '-24';
        } elseif ( $alert_zones > 24 && $alert_zones <= 32 ) {
          $meta18580->post_title .= '-32';
        } elseif ( $alert_zones > 32 ) {
          $meta18580->post_title .= '-40';
        }

        if ( $microphones < 1 ) {
          $meta19426->count = 1;
          $meta9716->count += 1;
        }
      }

      if ( $music && $music === 'Да' ) {
        $meta19580->count = 1;
        $meta9210->count = 1;
        $cdr3000->count = 1;

        if ( $alert_zones <= 8 ) {
          $meta19580->post_title .= '-8';
        } elseif ( $alert_zones > 8 && $alert_zones <= 16 ) {
          $meta19580->post_title .= '-16';
        } elseif ( $alert_zones > 16 && $alert_zones <= 24 ) {
          $meta19580->post_title .= '-24';
        } elseif ( $alert_zones > 24 && $alert_zones <= 32 ) {
          $meta19580->post_title .= '-32';
        } elseif ( $alert_zones > 32 ) {
          $meta19580->post_title .= '-40';
        }
      }

      if ( $light_alert && $light_alert === 'Да' ) {
        $meta19016->count = 1;
      }

      if ( $distance_control && $distance_control === 'Да' ) {
        $meta9314->count = 1;
      }

      $u = $meta19830->count * 2 +
           $meta9314->count +
           $meta19580->count * 2 +
           $meta19426->count * 2 +
           $meta19016->count * 2 +
           $cdr3000->count +
           $meta9154->count * 3 +
           $meta9210->count  +
           $meta9701->count * 3 +
           $meta9709->count * 3 +
           $meta9716->count * 3 +
           $meta9910->count;

      $result_calculate_u = calculate_u( $u );

      $meta4901_total_count = 0;

      $products[] = $meta18580;
      $products[] = $meta9716;
      $products[] = $meta19830;
      $products[] = $meta9154;
      $products[] = $meta9709;
      $products[] = $meta9701;
      $products[] = $meta9923;
      $products[] = $meta19426;
      $products[] = $meta19580;
      $products[] = $meta9210;
      $products[] = $cdr3000;

      foreach ( $result_calculate_u as $key => $val ) {
        $title = $meta4901->post_title . '-' . $val['zones'];
        
        foreach ( $products as $product ) {
          if ( $product->post_title === $title  ) {
            $product->count += 1;
            $meta4901_total_count += 1;
            $continue = true;
            break;
          }
        }

        if ( $continue ) {
          $continue = false;
          continue;
        }

        $continue = false;
        
        $products[] = (object) [
          'post_title' => $title,
          'count' => 1,
          'ID' => $meta4901->ID
        ];

        $meta4901_total_count += 1;

        unset( $title );
      }

      $meta9901->count = $meta4901_total_count;
      $meta9910->count = $meta4901_total_count;
      $meta9919->count = $meta4901_total_count;
      $meta9717->count = 1;

      $products[] = $meta9901;
      $products[] = $meta9910;
      $products[] = $meta9919;
      $products[] = $meta9717;

      $parsed_products = parse_products( $products );
      $parsed_params = parse_params( $_POST, $zones );

      $response['products'] = $parsed_products['products'];

      $response['params'] = $parsed_params['params'] . create_result_row( 'Комплект соединительных кабелей', 'Да' ) . create_result_row( 'Высота', $u . ' U' ) . '<div class="online-matching__result-separator">Рекомендованное оборудование</div>' . $parsed_products['params'] . $parsed_intercoms['params'];

      $parsed_params['response']['Комплект соединительных кабелей'] = 'Да';
      $parsed_params['response']['Высота'] = $u . ' U';

      $response['response'] = array_merge( $parsed_params['response'], $parsed_products['response'] );

      if ( $akb_7a_12v_count ) {
        $response['params'] .= create_result_row( 'АКБ 7 А*ч, 12В', $akb_7a_12v_count . ' шт' );
        $response['response'][ 'АКБ 7 А*ч, 12В' ] = $akb_7a_12v_count . ' шт';
      }

      if ( $akb_12a_12v_count ) {
        $response['params'] .= create_result_row( 'АКБ 12 А*ч, 12В', $akb_12a_12v_count . ' шт' );
        $response['response'][ 'АКБ 12 А*ч, 12В' ] = $akb_12a_12v_count . ' шт';
      }

      $response['docs'] = json_encode( $system_docs );
      $response['schemes'] = json_encode( $system_scehems );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . site_url() .'/equipments/opoveshhateli-pozharnye-rechevye-asr-ispolnenie-3/" target="_blank" class="link link_blue">Оповещатели пожарные речевые исп.&nbsp;3</a>' );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . get_term_link( 49, 'equipments' ) . '" target="_blank" class="link link_blue">Громкоговорители рупорные МЕТА исп.&nbsp;3</a>' );



    } elseif ( mb_stripos( $system, 'транспортной безопасности' ) !== false ) {
      // $meta8801 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 8801'
      // ] )[0];
      // $dr1347 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'DR-1347 исп.2'
      // ] )[0];
      // $dr1715 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'DR-1715'
      // ] )[0];
      // // Микрофон
      // $meta8554 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 8554'
      // ] )[0];
      // // Вместо ИБП
      // $meta9716 = get_posts( [
      //   'post_type' => 'equipment',
      //   'title' => 'МЕТА 9716'
      // ] )[0];

      $meta8801 = get_post( 10088 );
      $dr1347 = get_post( 9927 );
      $dr1715 = get_post( 9941 );
      // Микрофон
      $meta8554 = get_post( 7667 );
      // Вместо ИБП
      $meta9716 = get_post( 6804 );

      $system_docs = get_field( 'product_docs', $meta8801 );
      $system_scehems = get_field( 'schemes', $meta8801 );

      $system_docs = parse_docs( $system_docs );

      $meta9716->count = 0;
      $meta8801->count = 0;
      $meta8801_rows = '';
      $meta8801_response = [];

      // Для теплых помещений
      if ( mb_stripos( $_POST['room-type'], 'внутриобъект') !== false ) {
        $meta8801->count = 1; // по умолчанию 1 (900 Вт)
        $meta8801->post_title .= '-06';
        if ( $_POST['alert-power-for-warm-room'] > 900 ) {
          $power_for_warm_room = recalculate_power_from_number( $_POST['alert-power-for-warm-room'] - 900, 900, 600, 300 );
          foreach ( $power_for_warm_room as $key => $val ) {
            if ( $val == 0 ) {
              continue;
            }
            if ( $key == 900 ) {
              $meta8801_type = '03';
            } elseif ( $key == 600 ) {
              $meta8801_type = '02';
            } elseif ( $key == 300 ) {
              $meta8801_type = '01';
            } else {
              continue;
            }
            $meta8801->count += $val;
            $meta8801_rows .= create_result_row( 'МЕТА 8801-' . $meta8801_type, $val . ' шт' );
            $meta8801_response[ 'МЕТА 8801-' . $meta8801_type ] = $val . ' шт';

          }
        }
      }

      // Для улицы
      if ( mb_stripos( $_POST['room-type'], 'приобъект') !== false ) {
        $dr1347->count = ceil( $_POST['alert-power-for-street'] / 600 ); // Каждые 600 Вт 
        $dr1715->count = $dr1347->count;
      }

      if ( $microphones > 0 ) {
        $meta8554->count = $microphones;

        $alert_zones = $meta8801->count * 8 + $dr1347->count * 4;

        if ( $alert_zones <= 8 ) {
          $meta8554->post_title .= '-8';
        } elseif ( $alert_zones > 8 && $alert_zones <= 16 ) {
          $meta8554->post_title .= '-16';
        } elseif ( $alert_zones > 16 && $alert_zones <= 24 ) {
          $meta8554->post_title .= '-24';
        } elseif ( $alert_zones > 24 && $alert_zones <= 40 ) {
          $meta8554->post_title .= '-40';
        } elseif ( $alert_zones > 40 ) {
          $meta8554->post_title .= '-56';
        }
      }

      if ( $meta8801->count != 0 ) {
        // Нужно сбросить на 1 шкаф -06
        $meta8801->count = 1;
      }

      if ( $intercoms_type && $intercoms_count ) {
        $parsed_intercoms = parse_intercoms( $intercoms_count, $intercoms_type, $meta9716 );
        $meta9716 = $parsed_intercoms['ibp'];
        $products = $parsed_intercoms['products'];
      }

      if ( $meta9716->count > 0 ) {
        $akb_12a_12v_count = $meta9716->count * 2;
      }

      $products[] = $dr1347;
      $products[] = $dr1715;
      $products[] = $meta8554;
      $products[] = $meta8801;

      $parsed_products = parse_products( $products );
      $parsed_params = parse_params( $_POST, $zones );

      $response['products'] = $parsed_products['products'];
      $response['params'] = $parsed_params['params'] . '<div class="online-matching__result-separator">Рекомендованное оборудование</div>' . $parsed_products['params'] . $meta8801_rows . $parsed_intercoms['params'];
      $response['response'] = array_merge( $parsed_params['response'], $parsed_products['response'], $meta8801_response );

      if ( $akb_12a_12v_count ) {
        $response['params'] .= create_result_row( 'АКБ 12 А*ч, 12В', $akb_12a_12v_count . ' шт' );
        $response['response'][ 'АКБ 12 А*ч, 12В' ] = $akb_12a_12v_count . ' шт';
      }

      $response['docs'] = json_encode( $system_docs );
      $response['schemes'] = json_encode( $system_scehems );
      $response['params'] .= create_result_row( 'Оповещатели', '<a href="' . site_url() .'/equipments/gromkogovoriteli-rupornye-meta/" target="_blank" class="link link_blue">Рупорные громкоговорители</a>' );

    }

    echo json_encode( $response );
    die();
  }
}

add_action( 'wp_ajax_nopriv_online_matching', 'online_matching' );
add_action( 'wp_ajax_online_matching', 'online_matching' );

add_action( 'wp_ajax_nopriv_online_matching_get_results', 'online_matching_get_results' );
add_action( 'wp_ajax_online_matching_get_results', 'online_matching_get_results' );