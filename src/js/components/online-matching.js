;
(function() {

  if (!id('online-matching-sect')) return;

  let onlineMatchingSect = id('online-matching-sect'),
    onlineMatchingBlock = q('.online-matching', onlineMatchingSect),
    onlineMatchingTextBlock = id('step-text-block'),
    onlineMatchingResultBlock = q('.online-matching__result', onlineMatchingSect),
    stepsForm = id('steps-form'),
    breadcrumbsBlock = id('breadcrumbs'),
    firstStep = id('step-1'),
    stepTitle = id('step-title'),

    consultBtn = id('consult-btn'),
    orderBtn = id('order-btn'),
    resetBtn = id('reset-btn'),

    printBtn = id('print'),

    response,

    resultParamsBlock = id('result-params'),
    resultDocsBlock = id('result-docs'),
    resultSchemesBlock = id('result-schemes'),
    resultProductsBlock = id('result-products'),

    firstStepTitle = stepTitle.innerHTML,
    onlineMatchingButtons = qa('.online-matching__system-btn', onlineMatchingSect),
    breadcrumbs = breadcrumbsBlock.children,
    steps = stepsForm.getElementsByClassName('online-matching__step'),
    stepsObject,
    stepsLength,
    currentStepNumeber,
    prevStepNumber,
    requiredFields,

    HTML = {
      'label': '<label class="online-matching__%class%">%field%</label>',
      'hint': '<span class="online-matching__%class%-hint hint"><span class="hint__icon">i</span><span class="hint__text">%text%</span></span>',
      'field': '<input type="%type%"%min%%max%%step%%value%%total-amount% name="%name%"%placeholder% required%error%%total-amount-error% class="online-matching__field-inp">',

      'radio-text': '<span class="online-matching__radio-text">%text%</span>',
      'radio': '<input type="radio" name="%name%" value="%value%" required%error% class="online-matching__radio-inp">',
      'radio-img': '<img src="%src%" alt="%alt%" class="online-matching__radio-img">',

      'select': '<select name="%name%" required%error% class="online-matching__select">%options%</select>',
      'option': '<option value="%value%"class="online-matching__option">%text%</option>',
      'error': '<span class="online-matching__field-error">%text%</span>',
      'prev': '<button class="online-matching__submit online-matching__prev"><svg class="online-matching__prev-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg>Назад</button>',
      'next': '<button class="online-matching__submit online-matching__next btn btn_blue">Далее<svg class="online-matching__submit-svg" viewBox="0 0 23 8" xmlns="http://www.w3.org/2000/svg"><path d="M22.3536 4.35356C22.5488 4.15829 22.5488 3.84171 22.3536 3.64645L19.1716 0.464468C18.9763 0.269206 18.6597 0.269206 18.4645 0.464468C18.2692 0.65973 18.2692 0.976312 18.4645 1.17157L21.2929 4L18.4645 6.82843C18.2692 7.02369 18.2692 7.34027 18.4645 7.53554C18.6597 7.7308 18.9763 7.7308 19.1716 7.53554L22.3536 4.35356ZM-4.37114e-08 4.5L22 4.5L22 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg></button>'
    },

    alertZonesInputTemplate = {
      type: 'number',
      name: 'alert-zone-%number%-power',
      error: 'Введите мощность для %number% зоны',
      placeholder: 'Введите мощность для %number% зоны, Вт'
    },

    reset = function() {
      prevStepNumber = undefined;
      showFirstStep();
    },

    init = function() {
      resetBtn.addEventListener('click', reset);

      stepsForm.addEventListener('submit', e => e.preventDefault());
      stepsForm.addEventListener('keydown', goNext);
      // stepsForm.addEventListener('keydown', e => e.preventDefault());
      // stepsForm.addEventListener('keyup', e => e.preventDefault());
      stepsForm.addEventListener('click', goNext);
      stepsForm.addEventListener('click', goPrev);
      stepsForm.addEventListener('input', function(e) {
        let currentFieldsObject = stepsObject[currentStepNumeber].fields,
          target = e.target,
          value = target.value,
          name = target.name;

        // Создание дополнительных инпутов при вводе чисел
        for (let j = 0, len = currentFieldsObject.length; j < len; j++) {
          if (currentFieldsObject[j].field && currentFieldsObject[j].name === name) {
            // Создадим селектор
            let optFiledName = currentFieldsObject[j].field.name,
              startAttr = optFiledName.replace(/%.*$/, ''),
              endAttr = optFiledName.replace(/.*%/, ''),
              attrSelector = '[name^=' + startAttr + '][name$=' + endAttr + ']',
              // existsInputs = qa('[name$=-power]', steps[currentStepNumeber]),
              existsInputs = qa(attrSelector, steps[currentStepNumeber]),
              existsInputsLen = existsInputs.length,
              // Блок с кнопками, перед которым будем вставлять поля
              buttonsBlock = q('.online-matching__buttons', steps[currentStepNumeber]);

            // Если кол-во инпутов меньше, вводимого значения, то будем добавлять инпуты
            if (+value <= +target.getAttribute('max')) {
              if (existsInputsLen < value) {
                for (let i = existsInputsLen + 1; i <= value; i++) {
                  // console.log('Добавляем инпут', i);
                  let input = parseTypeNumber(currentFieldsObject[j].field, i).replace(' class', ' data-opt-field class');
                  buttonsBlock.insertAdjacentHTML('beforebegin', input);
                }
              } else if (existsInputs > value) {
                // Если существующих инпутов больше, то будем удаляьть их с конца
                for (let i = existsInputsLen - 1; i >= value; i--) {
                  // console.log('Удаляем инпут', i);
                  steps[currentStepNumeber].removeChild(existsInputs[i].parentElement);
                }
              }
            }
            break;
          }
        }

        // Запишем data-value текущего шага (для проверки if условия в дальнейшем)
        // if (!/alert-zone-[0-9]-power/.test(name)) {
        if (!target.parentElement.hasAttribute('data-opt-field')) {
          steps[currentStepNumeber].setAttribute('data-value', value);
        }
      });

      stepsForm.setAttribute('novalidate', '');

      breadcrumbsBlock.addEventListener('click', function(e) {
        let target = e.target;
        if (target.tagName === 'LI') {
          step(target.getAttribute('data-step'));
        }
      });

      for (let i = 0, len = onlineMatchingButtons.length; i < len; i++) {
        onlineMatchingButtons[i].addEventListener('click', submitStepOne);
      }

    },

    goNext = function(e) {
      let target = e.target;

      if (e.type === 'keydown' && (e.code === 'Enter' || e.key === 'Enter') || target.classList.contains('online-matching__submit') && target.classList.contains('online-matching__next')) {
        // console.log('goNext');
        e.preventDefault();
        if (validateFields() && validateTotalAmountFields()) {
          let selectField = q('select', steps[currentStepNumeber]),
            isSelectField = !!selectField;

          if (isSelectField) {
            steps[currentStepNumeber].setAttribute('data-value', selectField.value);
          }

          currentStepNumeber++;
          step();
        }
      }
    },

    goPrev = function(e) {
      let target = e.target;

      if (target.classList.contains('online-matching__submit') && target.classList.contains('online-matching__prev')) {
        // console.log('goPrev');
        e.preventDefault();
        currentStepNumeber--;
        step(0, 'prev');
      }
    },

    validateFields = function() {
      requiredFields = qa('[required]', steps[currentStepNumeber], true);

      requiredFields.forEach(function(el, i) {
        let type = el.type,
          isValid;

        if (el.tagName === 'SELECT') {
          isValid = el.value !== el.children[0].value;
        } else {
          isValid = el.checkValidity();
        }

        if (isValid) {
          if (type === 'radio') {
            removeError(steps[currentStepNumeber]);
          } else {
            removeError(el.parentElement);
          }
        } else {
          if (type === 'radio') {
            showError(el, steps[currentStepNumeber]);
          } else {
            showError(el, el.parentElement);
          }
        }

      });

      return requiredFields.every(function(el) {
        if (el.tagName === 'SELECT') {
          return el.value !== el.children[0].value;
        } else {
          return el.checkValidity();
        }
      });

    },

    validateTotalAmountFields = function() {
      let totalAmountFields = qa('[data-total-amount]', steps[currentStepNumeber], true),
        isValid = true;

      if (totalAmountFields.length > 0) {
        let buttonsBlock = q('.online-matching__buttons', steps[currentStepNumeber]),
          totalAmount = totalAmountFields[0].getAttribute('data-total-amount'),
          errorElement = q('.online-matching__total-amount-error', steps[currentStepNumeber]),
          error = '<span class="online-matching__total-amount-error">' + totalAmountFields[0].getAttribute('data-total-amount-error') + '</span>',
          sum = 0;

        totalAmountFields.forEach(function(el, i) {
          sum += +el.value;
        });

        // Ошибку общей суммы будем вставлять перед блоком с кнопками
        if (sum > totalAmount) {
          isValid = false;
          if (!errorElement) {
            buttonsBlock.insertAdjacentHTML('beforebegin', error);
          }
        } else {
          if (errorElement) {
            steps[currentStepNumeber].removeChild(errorElement)
          }
        }
      }

      return isValid;

    },

    showError = function(field, parent) {
      let errorText = field.getAttribute('data-error'),
        type = field.type,
        where = type === 'radio' ? 'beforebegin' : 'beforeend',
        who = type === 'radio' ? q('.online-matching__buttons', steps[currentStepNumeber]) : parent;

      if ($('.online-matching__field-error:contains(' + errorText + ')', parent).length === 0) {
        who.insertAdjacentHTML(where, HTML.error.replace('%text%', errorText));
      }
    },

    removeError = function(parent) {
      let error = q('.online-matching__field-error', parent);

      if (error) {
        parent.removeChild(error);
      }

    },

    disallowButtonsAccess = function(that) {
      for (let i = 0, len = onlineMatchingButtons.length; i < len; i++) {
        onlineMatchingButtons[i].classList.add(onlineMatchingButtons[i] === that ? 'loading' : 'disabled');
      }
    },
    allowButtonsAccess = function() {
      for (let i = 0, len = onlineMatchingButtons.length; i < len; i++) {
        onlineMatchingButtons[i].classList.remove('loading', 'disabled');
      }
    },

    disallowBreadcrumbsAccess = function() {
      breadcrumbsBlock.classList.add('disabled');
    },
    allowBreadcrumbsAccess = function() {
      breadcrumbsBlock.classList.remove('disabled');
    },
    createBreadcrumb = function(text) {
      breadcrumbsBlock.insertAdjacentHTML('beforeend', '<li class="breadcrumbs__li" data-step="' + breadcrumbs.length + '" hidden>' + text + '</li>');
    },

    parseTypeRadio = function(fieldObject) {
      let values = fieldObject.values,
        hints = fieldObject.hints,
        name = fieldObject.name,
        error = ' data-error="' + fieldObject.error + '"',
        output = '';

      for (let i = 0, len = values.length; i < len; i++) {
        let field = HTML.radio.replace('%name%', name).replace('%value%', values[i]).replace('%error%', error) +
          HTML['radio-text'].replace('%text%', values[i]) +
          (hints && hints[i] ? HTML.hint.replace('%class%', 'radio').replace('%text%', hints[i]) : '');

        output += HTML.label.replace('%class%', 'radio').replace('%field%', field);
      }

      return output;
    },

    parseTypeAdvancedRadio = function(fieldObject) {
      let values = fieldObject.values,
        name = fieldObject.name,
        error = ' data-error="' + fieldObject.error + '"',
        output = '';

      for (let i = 0, len = values.length; i < len; i++) {
        let field = HTML.radio.replace('%name%', name).replace('%value%', values[i].id).replace('%error%', error) +
          HTML['radio-img'].replace('%src%', values[i].img).replace('%alt%', values[i].title) +
          HTML['radio-text'].replace('%text%', values[i].title) +
          HTML.hint.replace('%class%', 'radio').replace('%text%', values[i].descr);

        output += HTML.label.replace('%class%', 'radio').replace('%field%', field);
      }

      return output;
    },

    parseTypeSelect = function(fieldObject) {
      let values = fieldObject.values,
        placeholder = fieldObject.placeholder ? '<option selected hidden class="online-matching__option">' + fieldObject.placeholder + '</option>' : '',
        name = fieldObject.name,
        error = ' data-error="' + fieldObject.error + '"',
        options = placeholder;

      for (let i = 0, len = values.length; i < len; i++) {
        options += HTML.option.replace('%text%', values[i]).replace('%value%', values[i]);
      }

      return HTML.select.replace('%name%', name).replace('%options%', options).replace('%error%', error);
    },

    parseTypeNumber = function(fieldObject, num) {
      let value = fieldObject.value ? ' value="' + fieldObject.value + '"' : '',
        name = fieldObject.name,
        type = fieldObject.type,
        error = ' data-error="' + fieldObject.error + '"',
        placeholder = fieldObject.placeholder ? ' placeholder="' + fieldObject.placeholder + '"' : '',
        min = fieldObject.min ? ' min="' + fieldObject.min + '"' : '',
        max = fieldObject.max ? ' max="' + fieldObject.max + '"' : '',
        step = fieldObject.step ? ' step="' + fieldObject.step + '"' : '',
        totalAmount = fieldObject['total-amount'] ? ' data-total-amount="' + fieldObject['total-amount'] + '"' : '',
        totalAmountError = fieldObject['total-amount-error'] ? ' data-total-amount-error="' + fieldObject['total-amount-error'] + '"' : '',
        output = '';

      if (num) {
        name = name.replace('%number%', num);
        placeholder = placeholder.replace('%number%', num);
        error = error.replace('%number%', num);
      }

      field = HTML.field.replace('%name%', name)
        .replace('%placeholder%', placeholder)
        .replace('%type%', type)
        .replace('%min%', min)
        .replace('%max%', max)
        .replace('%step%', step)
        .replace('%error%', error)
        .replace('%total-amount%', totalAmount)
        .replace('%total-amount-error%', totalAmountError)
        .replace('%value%', value);

      output += HTML.label.replace('%class%', 'field').replace('%field%', field);

      return output;
    },

    createStep = function(fields, i) {
      let fieldsHTML = fields.reduce(function(prevField, nextField) {
        let fieldHTML,
          type = nextField.type;

        if (type === 'radio') {
          fieldHTML = parseTypeRadio(nextField);
        } else if (type === 'advanced-radio') {
          fieldHTML = parseTypeAdvancedRadio(nextField);
        } else if (type === 'number') {
          fieldHTML = parseTypeNumber(nextField);
        } else if (type === 'select') {
          fieldHTML = parseTypeSelect(nextField);
        }

        return prevField + fieldHTML;

      }, '');

      stepsForm.insertAdjacentHTML('beforeend',
        '<div class="online-matching__step" id="step-' + ++i + '" hidden>' +
        fieldsHTML +
        '<div class="online-matching__buttons">' + HTML.prev + HTML.next + '</div></div>');

    },

    submitStepOne = function() {
      this.nextElementSibling.checked = true;
      stepsLength = 0;
      currentStepNumeber = 0;
      prevStepNumber = 0;

      disallowButtonsAccess(this);
      disallowBreadcrumbsAccess();

      let xhr = new XMLHttpRequest(),
        data = new FormData(stepsForm);

      data.append('action', 'online_matching');

      xhr.open(stepsForm.method, stepsForm.action);
      xhr.send(data);

      xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          stepsObject = JSON.parse(xhr.response);
          printSteps();
          // console.log(stepsObject);
          currentStepNumeber++;
          step();
        }
      });
    },

    removeChilds = function(parent, childs) {
      if (childs) {
        while (childs[1]) {
          parent.removeChild(childs[1]);
        }
      }
    },

    hideChilds = function() {

    },

    showFirstStep = function() {
      removeChilds(breadcrumbsBlock, breadcrumbs);
      removeChilds(stepsForm, steps);
      allowButtonsAccess();

      [
        firstStep,
        onlineMatchingBlock,
        onlineMatchingTextBlock,
        consultBtn
      ].forEach(el => el.removeAttribute('hidden'));


      [
        orderBtn,
        printBtn,
        resetBtn,
        onlineMatchingResultBlock
      ].forEach(el => el.setAttribute('hidden', ''));

      currentStepNumeber = 0;
      stepTitle.innerHTML = '1. Выберите систему оповещения:';
      $('html, body').animate({
        scrollTop: $("#breadcrumbs").offset().top
      }, 1000);
    },

    showLastStep = function() {
      onlineMatchingSect.classList.add('loading');

      let xhr = new XMLHttpRequest(),
        data = new FormData(stepsForm);

      data.append('action', 'online_matching_get_results');

      xhr.open(stepsForm.method, stepsForm.action);
      xhr.send(data);

      xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && xhr.status === 200) {

          // let response;

          try {
            response = JSON.parse(xhr.response)
          } catch (err) {
            console.log(err);
            console.log(xhr.response);
            return;
          }

          let docs = response.docs && JSON.parse(response.docs),
            schemes = response.schemes && JSON.parse(response.schemes),
            params = response.params,
            products = response.products,
            docsFiles = docs && docs.docs,
            docsHTML = '',
            schemesHTML = '';

          // console.log(response);
          // console.log(docs);
          // console.log(schemes);

          for (let key in docsFiles) {
            let doc = docsFiles[key],
              title = doc['title'],
              file = doc['file'],
              filetype = file['subtype'],
              filesize = (file['filesize'] / 1024 / 1024).toFixed(2) + ' Мб';

            if (filetype.indexOf('excel') !== -1) {
              filetype = 'xls';
            } else if (filetype.indexOf('jpeg') !== -1) {
              filetype = 'jpg';
            } else if (filetype.indexOf('dwg') !== -1) {
              filetype = 'dwg';
            }

            docsHTML += `
              <div class="doc-wrap">
                <a href="${file['url']}" target="_blank" class="doc">
                  <img src="${templateDir}/img/icon-${filetype}.svg" alt="#" class="doc__img">
                  <div class="doc__text">
                    <span class="doc__title">${title}.${filetype}</span>
                    <span class="doc__size">${filesize}</span>
                  </div>
                </a>
              </div>`;
          }

          for (let key in schemes) {
            let scheme = schemes[key];
            schemesHTML += `
            <a data-fancybox="schemes" data-caption="${scheme.title}" href="${scheme.img}" class="online-matching__result-scheme">
              <figure class="online-matching__result-scheme-fig">
                <img src="${scheme.img}" alt="${scheme.title}" class="online-matching__result-scheme-img">
                <figcaption class="online-matching__result-scheme-title">${scheme.title}</figcaption>
              </figure>
            </a>`;
          }


          resultSchemesBlock.children[0].insertAdjacentHTML('beforebegin', schemesHTML);
          resultDocsBlock.innerHTML = docsHTML;
          resultParamsBlock.innerHTML = params;
          resultProductsBlock.innerHTML = products;

          console.log(params);

          if (schemesHTML) {
            let schemesLength = resultSchemesBlock.children.length,
              schemesSelector = '.online-matching__result-scheme',
              schemesSlides = qa(schemesSelector, resultSchemesBlock),
              firstImage = q('img', schemesSlides[0]),
              $schemes = $(resultSchemesBlock),
              build = function() {
                if (SLIDER.hasSlickClass($schemes)) {
                  return;
                }
                if (schemesLength > 2) {
                  $schemes.slick({
                    infinite: false,
                    slide: schemesSelector,
                    adaptiveHeight: true,
                    appendArrows: $('#result-schemes-arrows'),
                    prevArrow: SLIDER.createArrow('arrow_black online-matching__result-schemes__prev', SLIDER.arrowSvg),
                    nextArrow: SLIDER.createArrow('arrow_black online-matching__result-schemes__next', SLIDER.arrowSvg),
                    draggable: false
                  });
                }
              };

            // Если первое изображение загружено (имеет высоту и ширину),
            // то собираем слайдер
            firstImage.onload = function() {
              build();
              windowFuncs.resize.push(build);
            }

            // build();
            // windowFuncs.resize.push(build);

            // console.log('msg');

            // $('[data-fancybox="schemes"]', resultSchemesBlock).fancybox({
            //   beforeClose: function(e, instance, slide) {
            //     if (resultSchemesBlock.classList.contains('slick-slider')) {
            //       $schemes.slick('slickGoTo', e.currIndex);
            //     }
            //   },
            //   buttons: [
            //     'share',
            //     'zoom',
            //     'fullScreen',
            //     'close'
            //   ]
            // });
          } else {
            resultSchemesBlock.setAttribute('hidden', '');
          }

          $('html, body').animate({
            scrollTop: $(".online-matching__result").offset().top
          }, 1000);

          [
            consultBtn,
            onlineMatchingBlock,
            onlineMatchingTextBlock
          ].forEach(el => el.setAttribute('hidden', ''));

          [
            onlineMatchingResultBlock,
            orderBtn,
            printBtn,
            resetBtn
          ].forEach(el => el.removeAttribute('hidden'));

          onlineMatchingSect.classList.remove('loading');
          // window.steps = steps;
          // window.stepsObject = stepsObject;
          // window.result = response;
        }
      });

    },

    showStep = function() {

      let titleNumber = stepTitle.textContent.match(/^[0-9]/);

      // Шаг назад
      if (prevStepNumber > currentStepNumeber) {
        // console.log('Шаг назад');
        for (let i = prevStepNumber; i > currentStepNumeber; i--) {
          breadcrumbs[i].classList.remove('current');
          steps[i].setAttribute('hidden', '');
          steps[i].removeAttribute('data-value');
          breadcrumbs[i].setAttribute('hidden', '');

          // Очищаем текстовые инпуты и чекбоксы шага, также удаляем дополнительные
          let inputs = qa('input', steps[i]);

          if (inputs.length > 0) {
            for (let j = 0, len = inputs.length; j < len; j++) {
              // Удаляем доп поля
              if (/alert-zone-[0-9]-power/.test(inputs[j].name)) {
                steps[i].removeChild(inputs[j].parentElement);
              } else {
                // Очищаем текстовые
                if (inputs[j].type === 'text' || inputs[j].type === 'number') {
                  inputs[j].value = '';
                  // Снимаем чекбоксы
                } else if (inputs[j].type === 'radio') {
                  inputs[j].checked = false;
                  // Сбрасываем селект
                } else if (inputs[j].tagName === 'SELECT') {
                  inputs[j].value = inputs[j].children[0].value;
                }
              }
            }
          }

        }

        // Ставим заголовок шага
        stepTitle.innerHTML = +currentStepNumeber + 1 + '. ' + stepsObject[currentStepNumeber].title + ':';

        // Шаг вперед
      } else {
        if (stepsObject[currentStepNumeber]) {

          let condition = stepsObject[currentStepNumeber].if,
            gotcha = false;

          // console.log('Проверяем if');
          // Проверяем if условия
          if (condition) {
            let conditionKey = Object.keys(condition)[0],
              conditionValue = Object.values(condition)[0];

            for (let i = 1; i < currentStepNumeber; i++) {
              // if (stepsObject[i].title === conditionKey && steps[i].getAttribute('data-value') === conditionValue) {
              if (stepsObject[i].title === conditionKey && steps[i].getAttribute('data-value').toLowerCase().indexOf(conditionValue.toLowerCase()) !== -1) {
                // console.log('совпало условие');
                // console.log(stepsObject[i]);
                // console.log(steps[i]);
                gotcha = true;
                break;
              }
            }

            // Если if условие не верно, то идем к следующему шагу
            if (!gotcha) {
              // showLastStep();
              // breadcrumbs[currentStepNumeber - 1].classList.remove('current');
              // steps[currentStepNumeber - 1].setAttribute('hidden', '');
              // breadcrumbs[currentStepNumeber - 1].setAttribute('hidden', '');
              showStep(++currentStepNumeber);
              return;
            }
          }
        } else {
          showLastStep();
          return;
        }

        // Скрываем прошлый шаг
        // breadcrumbs[currentStepNumeber - 1].classList.remove('current');
        // steps[currentStepNumeber - 1].setAttribute('hidden', '');
        // breadcrumbs[currentStepNumeber - 1].setAttribute('hidden', '');

        // Скрываем все прошлые шаги
        for (let i = 0; i < currentStepNumeber; i++) {
          breadcrumbs[i].classList.remove('current');
          steps[i].setAttribute('hidden', '');
          // breadcrumbs[i].setAttribute('hidden', '');
        }

        // Ставим заголовок шага
        stepTitle.innerHTML = +titleNumber[0] + 1 + '. ' + stepsObject[currentStepNumeber].title + ':';

      }

      // Прячем все прошлые шаги
      hideChilds(stepsForm, steps);

      breadcrumbs[currentStepNumeber].removeAttribute('hidden');
      breadcrumbs[currentStepNumeber].classList.add('current');

      steps[currentStepNumeber].removeAttribute('hidden');

      // console.log('currentStepNumeber', currentStepNumeber);
      // console.log('prevStepNumber', prevStepNumber);

    },

    printSteps = function() {
      let selectEvent = function(el) {
        el.on('change', function(item, state) {
          this.select.classList.add('selected');
        });
      };

      for (let stepNumber in stepsObject) {
        let stepObject = stepsObject[stepNumber],
          stepTitle = stepObject.title,
          stepBreadcrumb = stepObject.breadcrumb,
          stepFields = stepObject.fields;

        createStep(stepFields, stepNumber);

        createBreadcrumb(stepBreadcrumb);
        stepsLength++;
      }

      let select = tail.select('.online-matching__select');

      if (select) {
        if (select.length) {
          select.forEach(selectEvent);
        } else {
          selectEvent(select);
        }
      }
    },

    step = function(stepNum, dir) {
      if (stepNum) {
        prevStepNumber = currentStepNumeber;
        currentStepNumeber = stepNum;
      } else {
        // Двигаемся дальше
        if (dir === 'next' || !dir) {
          // console.log('next');
          prevStepNumber = currentStepNumeber - 1;
        } else {
          // console.log('prev');
          prevStepNumber = currentStepNumeber + 1;
        }
      }

      // console.log('Нужно сделать переход на шаг ' + currentStepNumeber);
      // console.log('Предыдущий шаг ' + prevStepNumber);

      if (currentStepNumeber < 1) {
        // console.log('Показать первый шаг');
        showFirstStep();
      } else if (currentStepNumeber > stepsLength) {
        // console.log('Показать последний шаг');
        showLastStep();
      } else {
        // console.log('Показать шаг', currentStepNumeber);
        showStep(currentStepNumeber);
      }

      if (browser.isMobile) {
        $('html, body').animate({
          scrollTop: $("#breadcrumbs").offset().top
        }, 1000);
      }

    };


  init();
  onlineMatchingSect.classList.remove('loading');

  // Перед отправкой формы "заказать решение"
  // добавляем в formData данные полей онлайн-подбора
  document.addEventListener('wpcf7beforesubmit', function(event) {
    let isOrderPopupForm = !!q('#order-popup-form', event.target);

    if (isOrderPopupForm) {
      let formData = event.detail.formData,
        responseData = response.response,
        result = '';

      for (let key in responseData) {
        result += key + ': ' + responseData[key] + '\n';
        // console.log(key, responseData[key]);
      }

      formData.append('result', result);
    }

  });



})();