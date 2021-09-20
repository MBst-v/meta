//polyfills
(function(){'use strict';function a(a){this.time=a.time,this.target=a.target,this.rootBounds=a.rootBounds,this.boundingClientRect=a.boundingClientRect,this.intersectionRect=a.intersectionRect||i(),this.isIntersecting=!!a.intersectionRect;var b=this.boundingClientRect,c=b.width*b.height,d=this.intersectionRect,e=d.width*d.height;this.intersectionRatio=c?+(e/c).toFixed(4):this.isIntersecting?1:0}function b(a,b){var c=b||{};if("function"!=typeof a)throw new Error("callback must be a function");if(c.root&&1!=c.root.nodeType)throw new Error("root must be an Element");this._checkForIntersections=d(this._checkForIntersections.bind(this),this.THROTTLE_TIMEOUT),this._callback=a,this._observationTargets=[],this._queuedEntries=[],this._rootMarginValues=this._parseRootMargin(c.rootMargin),this.thresholds=this._initThresholds(c.threshold),this.root=c.root||null,this.rootMargin=this._rootMarginValues.map(function(a){return a.value+a.unit}).join(" ")}function c(){return window.performance&&performance.now&&performance.now()}function d(a,b){var c=null;return function(){c||(c=setTimeout(function(){a(),c=null},b))}}function e(a,b,c,d){"function"==typeof a.addEventListener?a.addEventListener(b,c,d||!1):"function"==typeof a.attachEvent&&a.attachEvent("on"+b,c)}function f(a,b,c,d){"function"==typeof a.removeEventListener?a.removeEventListener(b,c,d||!1):"function"==typeof a.detatchEvent&&a.detatchEvent("on"+b,c)}function g(a,b){var c=Math.max(a.top,b.top),d=Math.min(a.bottom,b.bottom),e=Math.max(a.left,b.left),f=Math.min(a.right,b.right),g=f-e,h=d-c;return 0<=g&&0<=h&&{top:c,bottom:d,left:e,right:f,width:g,height:h}}function h(a){var b;try{b=a.getBoundingClientRect()}catch(a){}return b?(b.width&&b.height||(b={top:b.top,right:b.right,bottom:b.bottom,left:b.left,width:b.right-b.left,height:b.bottom-b.top}),b):i()}function i(){return{top:0,bottom:0,left:0,right:0,width:0,height:0}}function j(a,b){for(var c=b;c;){if(c==a)return!0;c=k(c)}return!1}function k(a){var b=a.parentNode;return b&&11==b.nodeType&&b.host?b.host:b&&b.assignedSlot?b.assignedSlot.parentNode:b}if("object"==typeof window){if("IntersectionObserver"in window&&"IntersectionObserverEntry"in window&&"intersectionRatio"in window.IntersectionObserverEntry.prototype)return void("isIntersecting"in window.IntersectionObserverEntry.prototype||Object.defineProperty(window.IntersectionObserverEntry.prototype,"isIntersecting",{get:function(){return 0<this.intersectionRatio}}));var l=window.document,m=[];b.prototype.THROTTLE_TIMEOUT=100,b.prototype.POLL_INTERVAL=null,b.prototype.USE_MUTATION_OBSERVER=!0,b.prototype.observe=function(a){var b=this._observationTargets.some(function(b){return b.element==a});if(!b){if(!(a&&1==a.nodeType))throw new Error("target must be an Element");this._registerInstance(),this._observationTargets.push({element:a,entry:null}),this._monitorIntersections(),this._checkForIntersections()}},b.prototype.unobserve=function(a){this._observationTargets=this._observationTargets.filter(function(b){return b.element!=a}),this._observationTargets.length||(this._unmonitorIntersections(),this._unregisterInstance())},b.prototype.disconnect=function(){this._observationTargets=[],this._unmonitorIntersections(),this._unregisterInstance()},b.prototype.takeRecords=function(){var a=this._queuedEntries.slice();return this._queuedEntries=[],a},b.prototype._initThresholds=function(a){var b=a||[0];return Array.isArray(b)||(b=[b]),b.sort().filter(function(b,c,d){if("number"!=typeof b||isNaN(b)||0>b||1<b)throw new Error("threshold must be a number between 0 and 1 inclusively");return b!==d[c-1]})},b.prototype._parseRootMargin=function(a){var b=(a||"0px").split(/\s+/).map(function(a){var b=/^(-?\d*\.?\d+)(px|%)$/.exec(a);if(!b)throw new Error("rootMargin must be specified in pixels or percent");return{value:parseFloat(b[1]),unit:b[2]}});return b[1]=b[1]||b[0],b[2]=b[2]||b[0],b[3]=b[3]||b[1],b},b.prototype._monitorIntersections=function(){this._monitoringIntersections||(this._monitoringIntersections=!0,this.POLL_INTERVAL?this._monitoringInterval=setInterval(this._checkForIntersections,this.POLL_INTERVAL):(e(window,"resize",this._checkForIntersections,!0),e(l,"scroll",this._checkForIntersections,!0),this.USE_MUTATION_OBSERVER&&"MutationObserver"in window&&(this._domObserver=new MutationObserver(this._checkForIntersections),this._domObserver.observe(l,{attributes:!0,childList:!0,characterData:!0,subtree:!0}))))},b.prototype._unmonitorIntersections=function(){this._monitoringIntersections&&(this._monitoringIntersections=!1,clearInterval(this._monitoringInterval),this._monitoringInterval=null,f(window,"resize",this._checkForIntersections,!0),f(l,"scroll",this._checkForIntersections,!0),this._domObserver&&(this._domObserver.disconnect(),this._domObserver=null))},b.prototype._checkForIntersections=function(){var b=this._rootIsInDom(),d=b?this._getRootRect():i();this._observationTargets.forEach(function(e){var f=e.element,g=h(f),i=this._rootContainsTarget(f),j=e.entry,k=b&&i&&this._computeTargetAndRootIntersection(f,d),l=e.entry=new a({time:c(),target:f,boundingClientRect:g,rootBounds:d,intersectionRect:k});j?b&&i?this._hasCrossedThreshold(j,l)&&this._queuedEntries.push(l):j&&j.isIntersecting&&this._queuedEntries.push(l):this._queuedEntries.push(l)},this),this._queuedEntries.length&&this._callback(this.takeRecords(),this)},b.prototype._computeTargetAndRootIntersection=function(a,b){if("none"!=window.getComputedStyle(a).display){for(var c=h(a),d=c,e=k(a),f=!1;!f;){var i=null,j=1==e.nodeType?window.getComputedStyle(e):{};if("none"==j.display)return;if(e==this.root||e==l?(f=!0,i=b):e!=l.body&&e!=l.documentElement&&"visible"!=j.overflow&&(i=h(e)),i&&(d=g(i,d),!d))break;e=k(e)}return d}},b.prototype._getRootRect=function(){var a;if(this.root)a=h(this.root);else{var b=l.documentElement,c=l.body;a={top:0,left:0,right:b.clientWidth||c.clientWidth,width:b.clientWidth||c.clientWidth,bottom:b.clientHeight||c.clientHeight,height:b.clientHeight||c.clientHeight}}return this._expandRectByRootMargin(a)},b.prototype._expandRectByRootMargin=function(a){var b=this._rootMarginValues.map(function(b,c){return"px"==b.unit?b.value:b.value*(c%2?a.width:a.height)/100}),c={top:a.top-b[0],right:a.right+b[1],bottom:a.bottom+b[2],left:a.left-b[3]};return c.width=c.right-c.left,c.height=c.bottom-c.top,c},b.prototype._hasCrossedThreshold=function(a,b){var c=a&&a.isIntersecting?a.intersectionRatio||0:-1,d=b.isIntersecting?b.intersectionRatio||0:-1;if(c!==d)for(var e,f=0;f<this.thresholds.length;f++)if(e=this.thresholds[f],e==c||e==d||e<c!=e<d)return!0},b.prototype._rootIsInDom=function(){return!this.root||j(l,this.root)},b.prototype._rootContainsTarget=function(a){return j(this.root||l,a)},b.prototype._registerInstance=function(){0>m.indexOf(this)&&m.push(this)},b.prototype._unregisterInstance=function(){var a=m.indexOf(this);-1!=a&&m.splice(a,1)},window.IntersectionObserver=b,window.IntersectionObserverEntry=a}})();
(function(){function a(a,b){b=b||{bubbles:!1,cancelable:!1,detail:null};let c=document.createEvent("CustomEvent");return c.initCustomEvent(a,b.bubbles,b.cancelable,b.detail),c}return"function"!=typeof window.CustomEvent&&void(a.prototype=window.Event.prototype,window.CustomEvent=a)})();
var
  // Размреы экранов для медиазапросов
  mediaQueries = {
    's': '(min-width:575.98px)',
    'm': '(min-width:767.98px)',
    'lg': '(min-width:1023.98px)',
    'xl': '(min-width:1439.98px)'
  },
  SLIDER = {},
  // Определяем бразуер пользователя
  browser = {
    // Opera 8.0+
    isOpera: (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
    // Firefox 1.0+
    isFirefox: typeof InstallTrigger !== 'undefined',
    // Safari 3.0+ "[object HTMLElementConstructor]"
    isSafari: /constructor/i.test(window.HTMLElement) || (function(p) {
      return p.toString() === "[object SafariRemoteNotification]";
    })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification)),
    // Internet Explorer 6-11
    isIE: /*@cc_on!@*/ false || !!document.documentMode,
    // Edge 20+
    isEdge: !( /*@cc_on!@*/ false || !!document.documentMode) && !!window.StyleMedia,
    // Chrome 1+
    isChrome: !!window.chrome && !!window.chrome.webstore,
    isYandex: !!window.yandex,
    isMac: window.navigator.platform.toUpperCase().indexOf('MAC') >= 0,
    isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
  },
  /*
Объединение слушателей для window на события 'load', 'resize', 'scroll'
Все слушатели на окно следует задавать через него, например:
  window.resize.push(functionName)
Все ф-ии, добавленные в [] window.resize, будут заданы одним слушателем
*/
  windowFuncs = {
    load: [],
    resize: [],
    scroll: [],
    call: function(event) {
      let funcs = windowFuncs[event.type] || event;
      for (let i = funcs.length - 1; i >= 0; i--) {
        // console.log(funcs[i].name);
        funcs[i]();
      }
    }
  },

  docLink, // ссылка на шаблон договора калькулятора
  mask, // ф-я маски телефонов в поля ввода (в файле telMask.js)
  lazy,
  menu,
  hdr,
  overlay,
  routePopup,
  consultPopup,
  orderPopup,
  filterPopup,
  mapBlock,
  body = document.body,
  templateDir = body.dataset.templateDir,
  siteUrl = body.dataset.pageUrl,
  fakeScrollbar,
  // Сокращение записи querySelector
  q = function(selector, element) {
    element = element || body;
    return element.querySelector(selector);
  },
  // Сокращение записи querySelectorAll + перевод в массив
  qa = function(selectors, element, toArray) {
    element = element || body;
    return toArray ? Array.prototype.slice.call(element.querySelectorAll(selectors)) : element.querySelectorAll(selectors);
  },
  // Сокращение записи getElementById
  id = function(selector) {
    return document.getElementById(selector);
  },
  // Фикс 100% высоты экрана для моб. браузеров
  setVh = function() {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', vh + 'px');
  },
  // Сокращение записи window.matchMedia('query').matches
  media = function(media) {
    return window.matchMedia(media).matches;
  },
  // Кроссбраузерный кастомный эвент, который мы отключим в IE
  dispatchEvent = function(element, eventName) {
    if (!browser.isIE && typeof window.CustomEvent === "function") {
      let evt = new CustomEvent(eventName);
      element.dispatchEvent(evt);
    }
  },
  // Функция запрета/разрешения прокрутки страницы
  pageScroll = function(disallow) {
    fakeScrollbar.classList.toggle('active', disallow);
    body.classList.toggle('no-scroll', disallow);
    body.style.paddingRight = disallow ? fakeScrollbar.offsetWidth - fakeScrollbar.clientWidth + 'px' : '';
  },
  // Липкий элемент средствами js
  sticky = function($el, fixThresholdDir, className) {
    $el = typeof $el === 'string' ? q($el) : $el;
    className = className || 'fixed';
    fixThresholdDir = fixThresholdDir || 'bottom';

    let fixThreshold = $el.getBoundingClientRect()[fixThresholdDir] + pageYOffset,
      $elClone = $el.cloneNode(true),
      $elParent = $el.parentElement,
      fixElement = function() {
        if (!$el.classList.contains(className) && pageYOffset >= fixThreshold) {
          $elParent.appendChild($elParent.replaceChild($elClone, $el));
          $el.classList.add(className);

          window.removeEventListener('scroll', fixElement);
          window.addEventListener('scroll', unfixElement);
        }
      },
      unfixElement = function() {
        if ($el.classList.contains(className) && pageYOffset <= fixThreshold) {
          $elParent.replaceChild($el, $elClone);
          $el.classList.remove(className);

          window.removeEventListener('scroll', unfixElement);
          window.addEventListener('scroll', fixElement);
        }
      };

    $elClone.classList.add('clone');
    fixElement();
    window.addEventListener('scroll', fixElement);
  },
  // Функция табов-переключателей с accessibillity
  initTabs = function($btnsBlock, $textBlock) {
    if ($btnsBlock || $textBlock) {
      let tabsContents = $textBlock.constructor === Array ? $textBlock : $textBlock.children,
        tabs = $btnsBlock.children,
        tabFocus = 0,
        changeTabs = function(event) {
          let target = event.target;

          if (target.tagName === 'BUTTON') {
            let parent = target.parentNode,
              grandparent = parent.parentNode,
              tabContent = q('#' + target.getAttribute('aria-controls'), grandparent.parentNode);

            // Убираем выделение с кнопок
            qa('[aria-selected="true"]', parent, true)
              .forEach(function(el) {
                el.setAttribute('aria-selected', false);
                el.classList.remove('is-active');
              });

            // Скрываем все тексты
            qa('[role="tabpanel"]', grandparent, true)
              .forEach(function(el) {
                el.setAttribute('aria-hidden', true);
                el.classList.remove('is-active');
              });

            // Делаем активной текущую кнопку-таб
            target.setAttribute('aria-selected', true);
            target.classList.add('is-active');

            // Показываем контент переключателя
            tabContent.removeAttribute('aria-hidden');
            tabContent.classList.add('is-active');

            // Устанавливаем фокус
            for (let i = tabs.length - 1; i >= 0; i--) {
              if (tabs[i] === target) {
                tabFocus = i;
                break;
              }
            }
          }
        }

      $btnsBlock.addEventListener('click', changeTabs);
      $btnsBlock.addEventListener('keydown', function(event) {
        // Двигаемся вправо
        if (event.keyCode === 39 || event.keyCode === 37) {
          tabs[tabFocus].setAttribute('tabindex', -1);
          if (event.keyCode === 39) {
            tabFocus++;
            // Если дошли до конца, то начинаем сначала
            if (tabFocus >= tabs.length) {
              tabFocus = 0;
            }
            // Двигаемся влево
          } else if (event.keyCode === 37) {
            tabFocus--;
            // Если дошли до конца, то начинаем сначала
            if (tabFocus < 0) {
              tabFocus = tabs.length - 1;
            }
          }

          tabs[tabFocus].setAttribute('tabindex', 0);
          tabs[tabFocus].focus();
        }
      });
    }

  },
  // Прокрутка до элемента при помощи requestAnimationFrame
  scrollToTarget = function(event, target) {
    event.preventDefault();

    target = target || this.dataset.scrollTarget;

    if (target.constructor === String) {
      target = q(target);
    }

    if (!target) {
      console.warn('Scroll target not found');
      return;
    }

    let wndwY = window.pageYOffset,
      targetStyles = getComputedStyle(target),
      targetTop = target.getBoundingClientRect().top - +(targetStyles.paddingTop).slice(0, -2) - +(targetStyles.marginTop).slice(0, -2),
      start = null,
      V = .35,
      step = function(time) {
        if (start === null) {
          start = time;
        }
        let progress = time - start,
          r = (targetTop < 0 ? Math.max(wndwY - progress / V, wndwY + targetTop) : Math.min(wndwY + progress / V, wndwY + targetTop));

        window.scrollTo(0, r);

        if (r != wndwY + targetTop) {
          requestAnimationFrame(step);
        }
      }

    requestAnimationFrame(step);
  };
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

document.addEventListener('DOMContentLoaded', function() {

  fakeScrollbar = id('fake-scrollbar');

  // Инициализируем поддержку svg (в основном это надо для svg use в IE)
  svg4everybody();


  //includes
  ;
  (function() {
    let mobileMenu = function(_) {
        let setMenuStyles = function(trf, trs) {
            let args = [trf, trs],
              props = ['transform', 'transition'],
              values = ['translate3d(' + trf + ', 0px, 0px)', 'transform ' + trs];
  
            for (let i = args.length - 1; i >= 0; i--) {
              if (args[i] !== 0) {
                if (args[i] === '') {
                  args[i] = '';
                } else {
                  args[i] = values[i];
                }
                menuCnt.style[props[i]] = args[i];
              }
            }
          },
          checkForString = function(variable) {
            return variable.constructor === String ? q(variable) : variable;
          },
          openMenu = function() {
            if (!opened) {
              if (menu.hasAttribute('style')) {
                menu.removeAttribute('style');
                menu.offsetHeight;
              }
              menu.classList.add('active');
              openBtn.classList.add('active');
              menuCnt.scrollTop = 0;
  
              if (!fade) {
                setMenuStyles('0px', '.5s');
                menuWidth = menuCnt.offsetWidth;
              }
              if (!allowPageScroll) {
                pageScroll(true);
              }
            }
          },
          closeMenu = function(e, forSwipe) {
            if (opened) {
              let target = e && e.target;
              // Если меню открыто и произошел свайп или нет события (закрыто вызовом функции close()) или есть евент и его св-ва
              if (forSwipe || !e || (e.type === 'keyup' && e.keyCode === 27 || target === menu || target === closeBtn)) {
                menu.classList.remove('active');
                openBtn.classList.remove('active');
  
                if (!fade) {
                  setMenuStyles(initialTransformX, '.5s');
                }
              }
            }
          },
          swipeStart = function(e) {
            if (allowSwipe) {
              let evt = e.touches[0] || window.e.touches[0];
  
              isSwipe = isScroll = false;
              posInitX = posX1 = evt.clientX;
              posInitY = posY1 = evt.clientY;
              swipeStartTime = Date.now();
  
              menuCnt.addEventListener('touchend', swipeEnd);
              menuCnt.addEventListener('touchmove', swipeAction);
              setMenuStyles(0, '');
            }
          },
          swipeAction = function(e) {
            if (allowSwipe) {
              let evt = e.touches[0] || window.e.touches[0],
                style = menuCnt.style.transform,
                transform = +style.match(trfRegExp)[0];
  
              posX2 = posX1 - evt.clientX;
              posX1 = evt.clientX;
  
              posY2 = posY1 - evt.clientY;
              posY1 = evt.clientY;
  
              // Если еще не определено свайп или скролл (двигаемся в бок или вверх/вниз)
              if (!isSwipe && !isScroll) {
                let posY = Math.abs(posY2),
                  posX = Math.abs(posX2);
  
                if (posY > 7 || posX2 === 0) {
                  isScroll = true;
                } else if (posY < 7) {
                  isSwipe = true;
                }
              }
  
              if (isSwipe) {
                // Если двигаемся влево или вправо при уже открытом меню, фиксируем позицию
                if ((toLeft && posInitX > posX1) || (toRight && posInitX < posX1)) {
                  setMenuStyles('0px', 0);
                  return;
                }
                setMenuStyles(transform - posX2 + 'px', 0);
              }
            }
          },
          swipeEnd = function(e) {
            posFinal = posInitX - posX1;
  
            let absPosFinal = Math.abs(posFinal);
  
            swipeEndTime = Date.now();
  
            if (absPosFinal > 1 && isSwipe) {
              if (toLeft && posFinal < 0 || toRight && posFinal > 0) {
                if (absPosFinal >= menuWidth * swipeThreshold || swipeEndTime - swipeStartTime < 300) {
                  closeMenu(e, true);
                } else {
                  opened = false;
                  openMenu(e, true);
                }
              }
              allowSwipe = false;
            }
  
            menu.removeEventListener('touchend', swipeEnd);
            menu.removeEventListener('touchmove', swipeAction);
  
          },
          transitionEnd = function(e) {
            if (fade) {
              if (e.propertyName === 'opacity') {
                transitionEndEvents();
              }
            } else {
              if (e.propertyName === 'transform') {
                transitionEndEvents();
              }
            }
            allowSwipe = true;
          },
          transitionEndEvents = function() {
            if (opened) {
              opened = false;
              openBtn.addEventListener('click', openMenu);
              closeBtn.removeEventListener('click', closeMenu);
              if (!allowPageScroll) {
                pageScroll(false);
              }
            } else {
              opened = true;
              openBtn.removeEventListener('click', openMenu);
              closeBtn.addEventListener('click', closeMenu);
            }
          },
          init = function() {
            menu = checkForString(_.menu);
            menuCnt = checkForString(_.menuCnt);
            openBtn = checkForString(_.openBtn);
            closeBtn = checkForString(_.closeBtn);
            allowPageScroll = options.allowPageScroll;
            toRight = options.toRight;
            toLeft = options.toLeft;
            initialTransformX = toLeft ? '100%' : toRight ? '-100%' : 0;
            fade = options.fade;
  
            setListeners('add');
  
            if (fade) {
              toRight = toLeft = false;
            } else {
              setMenuStyles(initialTransformX, 0);
              menu.addEventListener('touchstart', swipeStart);
            }
          },
          setListeners = function(action) {
            openBtn[action + 'EventListener']('click', openMenu);
            menu[action + 'EventListener']('click', closeMenu);
            menu[action + 'EventListener']('transitionend', transitionEnd);
            document[action + 'EventListener']('keyup', closeMenu);
          },
          destroy = function() {
            if (opened) {
              closeMenu();
            }
  
            if (fade) {
              toRight = toLeft = false;
            } else {
              setMenuStyles('', '');
              menu.removeEventListener('touchstart', swipeStart);
            }
  
            setListeners('remove');
            menu = null;
            menuCnt = null;
            openBtn = null;
            closeBtn = null;
          },
          applyMediaParams = function() {
            // console.log('applyMediaParams');
            if (targetMediaQuery) {
              // console.log('set ' + targetMediaQuery + ' params');
              for (let option in responsive[targetMediaQuery]) {
                options[option] = responsive[targetMediaQuery][option];
              }
              currentMediaQuery = targetMediaQuery;
            } else { // set initial params
              for (let option in initialOptions) {
                options[option] = initialOptions[option];
              }
              currentMediaQuery = null;
            }
            if (menu) {
              destroy();
              init();
            }
          },
          checkMedia = function() {
            if (responsive) {
              targetMediaQuery = null;
              for (let mediaQuery in responsive) {
                if (media(mediaQuery)) {
                  targetMediaQuery = mediaQuery;
                }
              }
              if (targetMediaQuery !== currentMediaQuery) {
                applyMediaParams();
              }
            }
            if (!menu) {
              init();
            }
          },
          options = JSON.parse(JSON.stringify(_)),
          initialOptions = JSON.parse(JSON.stringify(_)),
          responsive = _.responsive,
          targetMediaQuery = null,
          currentMediaQuery = null,
          menu,
          menuCnt,
          openBtn,
          closeBtn,
          swipeStartTime,
          swipeEndTime,
          allowPageScroll,
          swipeThreshold = 0.5,
          toRight,
          toLeft,
          initialTransformX,
          fade,
          startPageY = pageYOffset,
          trfRegExp = /([-0-9.]+(?=px))/,
          isSwipe = false,
          isScroll = false,
          allowSwipe = false,
          opened = false,
          posX1 = 0,
          posX2 = 0,
          posY1 = 0,
          posY2 = 0,
          posInitX = 0,
          posInitY = 0,
          posFinal = 0,
          menuWidth = 0;
  
        if (_.menu) {
          // Элементы не изменяются через responsive
          checkMedia();
  
          windowFuncs.resize.push(checkMedia);
  
          // Если разрешена прокрутка, то закрываем при прокрутке
          // if (allowPageScroll) {
          //   windowFuncs.scroll.push(closeMenu);
          // }
  
          return {
            options: options,
            menu: menu,
            menuCnt: menuCnt,
            openBtn: openBtn,
            closeBtn: closeBtn,
            open: openMenu,
            close: closeMenu,
            destroy: destroy
          };
        }
      },
      burger = id('hdr-burger');
  
  
    menu = mobileMenu({
      menu: q('.menu'),
      menuCnt: q('.menu__cnt'),
      openBtn: burger,
      closeBtn: burger,
      toRight: true,
      fade: false,
      allowPageScroll: false,
      responsive: {
        '(min-width:767.98px)': {
          fade: true,
          toRight: false,
          allowPageScroll: true
        }
      }
    });
  
    burger.addEventListener('click', function() {
      let header = burger.closest('.hdr');
  
      header.classList.toggle('show-menu');
    });
  
  })();
  hdr = id('hdr');
  sticky(hdr);
  (function() {
    if (q('.route-popup') && id('route-btn')) {
      routePopup = new Popup('.route-popup', {
        openButtons: '#route-btn',
        closeButtons: '.route-popup__close'
      });
    }
  
    if (id('consult-popup') && id('consult-btn')) {
      consultPopup = new Popup('#consult-popup', {
        openButtons: '#consult-btn',
        closeButtons: '#consult-popup .popup__close'
      });
    }
  
    if (id('order-popup') && id('order-btn')) {
      orderPopup = new Popup('#order-popup', {
        openButtons: '#order-btn',
        closeButtons: '#order-popup .popup__close'
      });
    }
  
    if (id('filter')) {
      filterPopup = new Popup('#filter', {
        openButtons: '#filter-open-btn',
        closeButtons: '.filter__close'
      });
    }
  
    // thanksPopup = new Popup('.thanks-popup', {
    //   closeButtons: '.thanks-popup__close'
    // });
  
    // thanksPopup.addEventListener('popupbeforeopen', function() {
    //   clearTimeout(thanksPopupTimer);
    // });
  
    // Закрытие всех попапов вместе с закрытием окна спасибо
    // thanksPopup.addEventListener('popupbeforeclose', function() {
    //   let otherPopups = [callbackPopup, orderPopup];
  
    //   for (let i = 0; i < otherPopups.length; i++) {
    //     if (otherPopups[i].classList.contains('active')) {
    //       otherPopups[i].closePopup();
    //     }
    //   }
    // });
  })()
  ;
  (function() {
    let $productInputs = qa('.product-name-inp'),
      productInputsLen = $productInputs.length;
  
    let $forms = [
      id('contacts-form'),
      id('promo-form'),
      id('order-form'),
      id('consult-form'),
      id('consult-popup-form'),
      id('contacts-cb-form'),
      id('order-form'),
      id('order-popup-form'),
      id('ask-form'),
      id('design-form')
    ];
  
    if (productInputsLen && productInputsLen > 0) {
      let text = q('.product-hero__title').textContent;
  
      for (let i = 0; i < productInputsLen; i++) {
        $productInputs[i].value = text;
      }
    }
  
    let formValidator = function(params) {
      let $form = params.form,
        $formBtn = params.formBtn,
        // $uploadFilesBlock = params.uploadFilesBlock,
        errorsClass = 'invalid',
        // $filesInput = params.filesInput,
        // Правила проверки форм, аналогично jquery.validate
        rules = {
          name: {
            required: true
          },
          tel: {
            required: true,
            pattern: /\+7\([0-9]{3}\)[0-9]{3}\-[0-9]{2}\-[0-9]{2}/,
            or: 'email'
          },
          email: {
            required: true,
            pattern: /^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z])+$/,
            or: 'tel'
          },
          msg: {
            required: true,
            pattern: /[^\<\>\[\]%\&'`]+$/
          },
          policy: {
            required: true
          }
        },
        messages = {
          tel: {
            required: 'Введите ваш телефон или E-mail',
            pattern: 'Укажите верный телефон'
          },
          name: {
            required: 'Введите ваше имя',
          },
          email: {
            required: 'Введите ваш E-mail или телефон',
            pattern: 'Введите верный E-mail'
          },
          msg: {
            required: 'Введите ваше сообщение',
            pattern: 'Введены недопустимые символы'
          },
          policy: {
            required: 'Согласитель с политикой обработки персональных данных'
          }
        },
        /*
          Функция получения значения полей у текущей формы.
          Ищет только те элементы формы, именя которых указаны в rules.
          Возвращает объект: 
          {название-поля: значение-поля}
          Например:
          {'user-email': 'mail@mail.ru'}
        */
        getFormData = function($form) {
          let formElements = $form.elements,
            values = {};
  
          for (let rule in rules) {
            let formElement = formElements[rule];
  
            if (formElement) {
              values[rule] = formElement.value;
            }
          }
  
          return values;
        },
        /*
          Функция проверки правильности заполнения формы.
        */
        validationForm = function(event) {
          let errors = {},
            thisForm = $form,
            values = getFormData(thisForm);
  
          for (let elementName in values) {
            let rule = rules[elementName],
              $formElement = thisForm[elementName],
              elementValue = values[elementName],
              or = rule.or,
              $orFormElement = thisForm[or];
  
            if (rule) {
              if ($formElement.hasAttribute('required') || rule.required === true) {
                let elementType = $formElement.type,
                  pattern = rule.pattern;
  
                // Если элемент не чекнут или пустой
                if (((elementType === 'checkbox' || elementType === 'radio') && !$formElement.checked) ||
                  elementValue === '') {
  
                  if (or && $orFormElement) {
                    if ($orFormElement.value === '') {
                      errors[elementName] = messages[elementName].required;
                      continue;
                    }
                  } else {
                    errors[elementName] = messages[elementName].required;
                    continue;
                  }
                }
  
                // Если текстовый элемент, у которого есть щаблон для заполнения
                if (elementType !== 'cehckbox' && elementType !== 'radio' && pattern) {
                  if (elementValue !== '' && pattern.test(elementValue) === false) {
                    errors[elementName] = messages[elementName].pattern;
                    continue;
                  }
                }
  
                hideError($formElement);
              }
            }
          }
  
          if (Object.keys(errors).length == 0) {
            thisForm.removeEventListener('change', validationForm);
            thisForm.removeEventListener('input', validationForm);
            $form.validatie = true;
          } else {
            thisForm.addEventListener('change', validationForm);
            thisForm.addEventListener('input', validationForm);
            showErrors(thisForm, errors);
            $form.validatie = false;
          }
  
        },
        showErrors = function($form, errors) {
          let $formElements = $form.elements;
  
          for (let elementName in errors) {
            let errorText = errors[elementName],
              $errorElement = `<label class="${errorsClass}">${errorText}</label>`,
              $formElement = $formElements[elementName],
              $nextElement = $formElement.nextElementSibling;
  
            if ($nextElement && $nextElement.classList.contains(errorsClass)) {
              if ($nextElement.textContent !== errorText) {
                $nextElement.textContent = errorText;
              }
              continue;
            } else {
              $formElement.insertAdjacentHTML('afterend', $errorElement);
            }
  
            $formElement.classList.add(errorsClass);
          }
  
        },
        hideError = function($formElement) {
          let $nextElement = $formElement.nextElementSibling;
          $formElement.classList.remove(errorsClass);
          if ($nextElement && $nextElement.classList.contains(errorsClass)) {
            $nextElement.parentElement.removeChild($nextElement);
          }
        },
        submitHandler = function(e) {
          console.log(e);
          // let $form = q('#' + event.detail.id + '>form'),
          let $form = q('#' + e.detail.id + '>form') || e.target,
            eventType = e.type;
  
          if (eventType === 'wpcf7mailsent') {
            let $formElements = $form.elements;
  
            for (let i = 0; i < $formElements.length; i++) {
              hideError($formElements[i]);
              $formElements[i].classList.remove('filled');
            }
  
            $form.reset();
            // if ($uploadFilesBlock) {
              // $uploadFilesBlock.innerHTML = '';
            // }
            // if ($form === $quizForm) {
            //   id('quiz').resetQuiz();
            // }
            console.log('отправлено');
          }
          /* else if (eventType === 'wpcf7mailfailed') {
                  console.log('отправка не удалась');
                }*/
  
          $form.classList.remove('loading');
  
          setTimeout(function() {
            $form.classList.remove('sent');
  
            [
              routePopup,
              consultPopup,
              orderPopup,
              filterPopup
            ].forEach(function(popup) {
              if (popup) {
                popup.closePopup();
              }
            });
  
          }, 3000);
  
          // thanksPopup.openPopup();
          // thanksPopupTimer = setTimeout(function() {
          //   thanksPopup.closePopup();
          // }, 3000);
  
  
        },
        toggleInputsClass = function() {
          let $input = event.target,
            type = $input.type,
            files = $input.files,
            classList = $input.classList,
            value = $input.value;
  
          if (type === 'text' || $input.tagName === 'TEXTAREA') {
            if (value === '') {
              classList.remove('filled');
            } else {
              classList.add('filled');
            }
          } else if (type === 'file') {
            // $input.filesArray = [];
  
            // let uploadedFiles = '';
            // for (let i = 0, len = files.length; i < len; i++) {
              // $input.filesArray[i] = files[i];
              // uploadedFiles += '<span class="uploadedfiles__file"><span class="uploadedfiles__file-text">' + files[i].name + '</span></span>';
            // }
            // $uploadFilesBlock.innerHTML = uploadedFiles;
          }
        };
  
      $form.setAttribute('novalidate', '');
      $form.validatie = false;
      $formBtn.addEventListener('click', function() {
        validationForm();
        if ($form.validatie === false) {
          event.preventDefault();
        } else {
          $form.classList.add('loading');
        }
      });
      if (!document.wpcf7mailsent) {
        document.addEventListener('wpcf7mailsent', submitHandler);
        document.wpcf7mailsent = true;
      }
      $form.addEventListener('input', toggleInputsClass);
    };
  
    for (var i = $forms.length - 1; i >= 0; i--) {
      if ($forms[i]) {
        formValidator({
          form: $forms[i],
          formBtn: q('button', $forms[i]),
          // uploadFilesBlock: q('.uploadedfiles', $forms[i]),
          // filesInput: q('input[type="files"]', $forms[i])
        });
      }
    }
  })();
  ;(function() {
    let setCursorPosition = function(pos, inputElement) {
      inputElement.focus();
      if (inputElement.setSelectionRange) {
        inputElement.setSelectionRange(pos, pos);
      } else if (inputElement.createTextRange) {
        let range = inputElement.createTextRange();
  
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
      }
    };
  
    mask = function() {
      let pattern = '+7(___)___-__-__',
        i = 0,
        def = pattern.replace(/\D/g, ''),
        val = this.value.replace(/\D/g, '');
  
      if (def.length >= val.length) {
        val = def;
      }
  
      this.value = pattern.replace(/./g, function(match) {
        return /[_\d]/.test(match) && i < val.length ? val.charAt(i++) : i >= val.length ? '' : match;
      });
  
      if (event.type === 'blur') {
        if (this.value.length === 2) {
          this.value = '';
          this.classList.remove('filled');
        }
      } else {
        setCursorPosition(this.value.length, this);
      }
    };
  
    let input = qa('[name=tel]');
  
    for (let i = 0; i < input.length; i++) {
      input[i].addEventListener('input', mask);
      input[i].addEventListener('focus', mask);
      input[i].addEventListener('blur', mask);
    }
  
  })();
  ;
  (function() {
    let nextArrow = '<button type="button" class="arrow"></button>',
      prevArrow = '<button type="button" class="arrow"></button>',
      dot = '<button type="button" class="dot"></button>',
      arrowSvg = '<svg class="arrow__svg" width="38" height="8" fill="none" viewBox="0 0 38 8" xmlns="http://www.w3.org/2000/svg"><path d="M37.3536 4.35355C37.5488 4.15829 37.5488 3.84171 37.3536 3.64645L34.1716 0.464466C33.9763 0.269204 33.6597 0.269204 33.4645 0.464466C33.2692 0.659728 33.2692 0.976311 33.4645 1.17157L36.2929 4L33.4645 6.82843C33.2692 7.02369 33.2692 7.34027 33.4645 7.53553C33.6597 7.7308 33.9763 7.7308 34.1716 7.53553L37.3536 4.35355ZM0 4.5H37V3.5H0V4.5Z" fill="currentColor"/></svg>',
      smallArrowSvg = '<svg class="arrow__svg" width="16" height="8" viewBox="0 0 16 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.3536 4.35355C15.5488 4.15829 15.5488 3.84171 15.3536 3.64645L12.1716 0.464467C11.9763 0.269205 11.6597 0.269205 11.4645 0.464467C11.2692 0.659729 11.2692 0.976312 11.4645 1.17157L14.2929 4L11.4645 6.82843C11.2692 7.02369 11.2692 7.34027 11.4645 7.53553C11.6597 7.7308 11.9763 7.7308 12.1716 7.53553L15.3536 4.35355ZM-4.37114e-08 4.5L15 4.5L15 3.5L4.37114e-08 3.5L-4.37114e-08 4.5Z" fill="currentColor"/></svg>',
      cornerArrowSvg = '<svg class="arrow__svg" width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L6 5.87805L1 11" stroke="currentColor"/></svg>',
      createArrow = function(className, inside) {
  
        className = (className.indexOf('prev') === -1 ? 'next ' : 'prev ') + className;
  
        return '<button type="button" class="arrow arrow_' + className + '">' + inside + '</button>';
      },
  
      // Функции slick для сокращения записи
      // Чем больше слайдеров, тем актуальнее эти функции
      hasSlickClass = function($el) {
        return $el.hasClass('slick-slider');
      },
      unslick = function($el) {
        $el.slick('unslick');
      },
  
      setImages = function(slides) {
        for (let i = 0, len = slides.length; i < len; i++) {
          let img = q('img', slides[i]);
          // Если элемент найден и он без display:none
          if (img && img.offsetParent) {
            img.src = img.getAttribute('data-lazy') || img.getAttribute('data-src');
          }
        }
      },
  
      // Медиазапросы для сокращения записи
      mw576 = '(min-width: 575.98px)',
      mw768 = '(min-width: 767.98px)',
      mw1024 = '(min-width: 1023.98px)',
      mw1440 = '(min-width: 1439.98px)',
  
      // Слайдер главной секции
      heroSlider = id('index-hero-slider'),
  
      // Слайдер о компании на глвной странице и странице о компании
      aboutGallery = id('about-gallery'),
  
      // Слайдер клиентов на главной странице
      partnersSlider = id('about-partners'),
  
      // Слайдер команды
      teamSlider = id('team-slider'),
  
      // Слайдер продукта или решения
      productGallery = id('product-gallery'),
  
      // Слайдер схем и изображений
      productSchemes = id('product-schemes'),
  
      // Слайдер схем и изображений решения
      solutionSchemes = id('solution-schemes'),
  
      // Слайдер товаров в решении
      solutionEquipments = id('solution-equipments'),
  
      // Слайдер видео
      videosSlider = q('.product-props__videos');
  
    SLIDER.createArrow = createArrow;
    SLIDER.arrowSvg = arrowSvg;
    SLIDER.hasSlickClass = hasSlickClass;
  
    if (videosSlider) {
      let videoSlidesSelector = '.product-props__videos > iframe',
        videoSlides = qa(videoSlidesSelector, videosSlider),
  
        $videosSlider = $(videosSlider),
  
        buildVideoSlider = function() {
          if (media('(min-width:767.98px)') && videoSlides.length < 3) {
            if (hasSlickClass($videosSlider)) {
              unslick($videosSlider);
            }
          } else {
            if (hasSlickClass($videosSlider)) {
              return;
            }
            if (videoSlides.length && videoSlides.length > 1) {
              $videosSlider.slick({
                infinite: false,
                slide: videoSlidesSelector,
                appendArrows: $('.product-videos__nav'),
                prevArrow: createArrow('product-videos__prev', arrowSvg),
                nextArrow: createArrow('product-videos__next', arrowSvg),
                mobileFirst: true,
                draggable: false,
                responsive: [{
                  breakpoint: 767.98,
                  settings: {
                    slidesToShow: 2
                  }
                }]
              });
            }
          }
        }
      windowFuncs.resize.push(buildVideoSlider);
  
      console.log(videoSlides.length);
    }
  
    if (productGallery) {
      let gallerySlideSelector = '.product-gallery__slide',
        gallerySlider = id('product-gallery-slides'),
        gallerySliderNav = id('product-gallery-nav'),
        galleryNavSlides = qa(gallerySlideSelector, gallerySliderNav, true),
        gallerySlides = qa(gallerySlideSelector, gallerySlider),
  
        $gallerySlider = $(gallerySlider),
        $gallerySliderNav = $(gallerySliderNav),
  
        buildProductGallerySlider = function() {
          // return;
          if (hasSlickClass($gallerySlider)) {
            return;
          }
          if (gallerySlides.length && gallerySlides.length > 1) {
            $gallerySlider.slick({
              infinite: false,
              slide: gallerySlideSelector,
              // adaptiveHeight: true,
              lazyLoad: 'progressive',
              appendArrows: $('#product-gallery-arrows'),
              prevArrow: createArrow('arrow_black product-gallery__prev', arrowSvg),
              nextArrow: createArrow('arrow_black product-gallery__next', arrowSvg),
              // mobileFirst: true,
              draggable: false,
              // responsive: [{
              //   breakpoint: 575.98,
              //   settings: {
              //     adaptiveHeight: false
              //   }
              // }]
            });
  
            $gallerySliderNav.slick({
              slidesToShow: 4,
              slidesToScroll: 4,
              infinite: false,
              slide: gallerySlideSelector,
              arrows: false,
              mobileFirst: true,
              swipeThreshold: 8,
              responsive: [{
                breakpoint: 575.98,
                settings: {
                  vertical: true,
                  verticalSwiping: true
                }
              }, {
                breakpoint: 1023.98,
                settings: {
                  vertical: false,
                  verticalSwiping: false
                }
              }]
            });
          }
        }
      windowFuncs.resize.push(buildProductGallerySlider);
  
      galleryNavSlides[0].classList.add('active');
  
      $gallerySlider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $gallerySliderNav.slick('slickGoTo', nextSlide);
  
        for (let i = galleryNavSlides.length - 1; i >= 0; i--) {
          galleryNavSlides[i].classList.remove('active');
        }
        galleryNavSlides[nextSlide].classList.add('active');
      });
  
      gallerySliderNav.addEventListener('click', function() {
        let target = event.target,
          tragetIndex = galleryNavSlides.indexOf(target);
  
        $gallerySlider.slick('slickGoTo', tragetIndex);
      });
  
      $gallerySliderNav.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $gallerySlider.slick('slickGoTo', nextSlide);
      });
  
      $('[data-fancybox="images"]').fancybox({
        beforeClose: function(e, instance, slide) {
          if (gallerySlides.length && gallerySlides.length > 1) {
            $gallerySlider.slick('slickGoTo', e.currIndex);
          }
        },
        buttons: [
          'share',
          'zoom',
          'fullScreen',
          'close'
        ]
      });
    }
  
    if (heroSlider) {
      let heroSlideSelector = '.index-hero__slide',
        heroSlides = qa(heroSlideSelector, heroSlider),
  
        $heroSlider = $(heroSlider),
  
        buildHeroSlider = function() {
          console.log(heroSlides);
          setImages(heroSlides);
          if (hasSlickClass($heroSlider)) {
            return;
          }
          if (heroSlides.length && heroSlides.length > 1) {
            $heroSlider.slick({
              // adaptiveHeight: true,
              lazyLoad: 'progressive',
              slide: heroSlideSelector,
              appendArrows: $('.index-hero__arrows'),
              appendDots: $('.index-hero__nav'),
              dots: true,
              dotsClass: 'index-hero__dots dots',
              customPaging: function() {
                return dot;
              },
              prevArrow: createArrow('index-hero__prev', cornerArrowSvg),
              nextArrow: createArrow('index-hero__next', cornerArrowSvg)
            });
          }
        }
      windowFuncs.resize.push(buildHeroSlider);
    }
  
    if (productSchemes) {
      let productSchemesSelector = '.product-scheme',
        productSchemesSlides = qa(productSchemesSelector, productSchemes),
        $productSchemes = $(productSchemes),
        buildSchemesSlider = function() {
          if (hasSlickClass($productSchemes)) {
            return;
          }
          if (productSchemesSlides.length && productSchemesSlides.length > 1) {
            $productSchemes.slick({
              infinite: false,
              slide: productSchemesSelector,
              adaptiveHeight: true,
              appendArrows: $('#product-schemes__arrows'),
              prevArrow: createArrow('arrow_black product-schemes__prev', arrowSvg),
              nextArrow: createArrow('arrow_black product-schemes__next', arrowSvg),
              draggable: false,
              lazyLoad: 'progressive'
            });
          }
        };
  
      windowFuncs.resize.push(buildSchemesSlider);
  
      $('#product-schemes [data-fancybox="schemes"]').fancybox({
        beforeClose: function(e, instance, slide) {
          if (productSchemes.classList.contains('slick-slider')) {
            $productSchemes.slick('slickGoTo', e.currIndex);
          }
        },
        buttons: [
          'share',
          'zoom',
          'fullScreen',
          'close'
        ]
      });
    }
  
    if (solutionSchemes) {
      let solutionSchemesSelector = '.solution-scheme',
        solutionSchemesSlides = qa(solutionSchemesSelector, solutionSchemes),
        $solutionSchemes = $(solutionSchemes),
        buildSolutionSchemesSlider = function() {
          if (media(mw768) && solutionSchemesSlides.length < 3) {
            setImages(solutionSchemesSlides);
            if (hasSlickClass($solutionSchemes)) {
              unslick($solutionSchemes);
            }
          } else {
            if (hasSlickClass($solutionSchemes)) {
              return;
            }
            if (solutionSchemesSlides.length && solutionSchemesSlides.length > 1) {
              $solutionSchemes.slick({
                infinite: false,
                slide: solutionSchemesSelector,
                adaptiveHeight: true,
                appendArrows: $('#solution-schemes > .solution-schemes__nav'),
                prevArrow: createArrow('arrow_black solution-schemes__prev', arrowSvg),
                nextArrow: createArrow('arrow_black solution-schemes__next', arrowSvg),
                draggable: false,
                lazyLoad: 'progressive',
                mobileFirst: true,
                responsive: [{
                  breakpoint: 767.98,
                  settings: {
                    adaptiveHeight: false,
                    slidesToShow: 2,
                    appendArrows: $('.solution-schemes__title-block > .solution-schemes__nav')
                  }
                }]
              });
            } else {
              setImages(solutionSchemesSlides);
            }
          }
        };
  
      windowFuncs.resize.push(buildSolutionSchemesSlider);
  
      $('#solution-schemes [data-fancybox="schemes"]').fancybox({
        beforeClose: function(e, instance, slide) {
          if (solutionSchemes.classList.contains('slick-slider')) {
            $solutionSchemes.slick('slickGoTo', e.currIndex);
          }
        },
        buttons: [
          'share',
          'zoom',
          'fullScreen',
          'close'
        ]
      });
    }
  
    if (solutionEquipments) {
      let solutionEquipmentsSelector = '.solution-equipments__product',
        solutionEquipmentsSlides = qa(solutionEquipmentsSelector, solutionEquipments),
  
        $solutionEquipments = $(solutionEquipments),
  
        buildSolutionEquipmentsSlider = function() {
          if (media(mw768) && solutionEquipmentsSlides.length < 4) {
            setImages(solutionEquipmentsSlides);
            if (hasSlickClass($solutionEquipments)) {
              unslick($solutionEquipments);
            }
          } else if (media(mw1440) && solutionEquipmentsSlides.length < 5) {
            setImages(solutionEquipmentsSlides);
            if (hasSlickClass($solutionEquipments)) {
              unslick($solutionEquipments);
            }
          } else {
            if (hasSlickClass($solutionEquipments)) {
              return;
            }
            if (solutionEquipmentsSlides.length && solutionEquipmentsSlides.length > 1) {
              $solutionEquipments.slick({
                infinite: false,
                adaptiveHeight: true,
                lazyLoad: 'progressive',
                slide: solutionEquipmentsSelector,
                appendArrows: $('#solution-equipments>.solution-equipments__nav'),
                prevArrow: createArrow('arrow_black solution-equipments__prev', arrowSvg),
                nextArrow: createArrow('arrow_black solution-equipments__next', arrowSvg),
                mobileFirst: true,
                draggable: false,
                responsive: [{
                  breakpoint: 767.98,
                  settings: {
                    adaptiveHeight: false,
                    slidesToShow: 3,
                    appendArrows: $('.solution-equipments__title-block>.solution-equipments__nav')
                  }
                }, {
                  breakpoint: 1439.98,
                  settings: {
                    adaptiveHeight: false,
                    slidesToShow: 4,
                    appendArrows: $('.solution-equipments__title-block>.solution-equipments__nav')
                  }
                }]
              });
  
            }
          }
  
        }
      windowFuncs.resize.push(buildSolutionEquipmentsSlider);
    }
  
    if (aboutGallery) {
      let aboutGallerySlides = qa('.about__gallery-img', aboutGallery),
        buildGallerySlider = function() {
          let $aboutGallery = $(aboutGallery);
  
          if (hasSlickClass($aboutGallery)) {
            return;
          }
  
          if (aboutGallerySlides.length && aboutGallerySlides.length > 1) {
            $aboutGallery.slick({
              infinite: false,
              appendArrows: $('.about__gallery-nav'),
              slide: '.about__gallery-img',
              prevArrow: createArrow('arrow_blue about__gallery-prev', arrowSvg),
              nextArrow: createArrow('arrow_blue about__gallery-next', arrowSvg)
            });
          }
        }
      windowFuncs.resize.push(buildGallerySlider);
    }
  
    if (partnersSlider) {
      let partnersSelector = '.partner',
        partnersSlides = qa(partnersSelector, partnersSlider),
        buildPartnersSlider = function() {
          let $partnersSlider = $(partnersSlider);
  
          if (hasSlickClass($partnersSlider)) {
            return;
          }
  
          if (partnersSlides.length && partnersSlides.length > 1) {
            $partnersSlider.slick({
              autoplay: true,
              slidesToShow: 3,
              arrows: false,
              dots: true,
              appendDots: $('.about-partners__nav'),
              dotsClass: 'about-partners__dots dots',
              customPaging: function() {
                return dot;
              },
              slide: partnersSelector,
              mobileFirst: true,
              responsive: [{
                breakpoint: 575.98,
                settings: {
                  slidesToShow: 4
                }
              }, {
                breakpoint: 767.98,
                settings: {
                  slidesToShow: 5,
                  dots: false,
                  arrows: true,
                  prevArrow: createArrow('arrow_black about-partners__prev', smallArrowSvg),
                  nextArrow: createArrow('arrow_black about-partners__next', smallArrowSvg),
                  // appendArrows: $('.about-partners__nav')
                }
              }]
            });
          }
        }
      windowFuncs.resize.push(buildPartnersSlider);
    }
  
    if (teamSlider) {
      let teamSelector = '.char',
        teamSlides = teamSlider && qa(teamSelector, teamSlider),
        $teamSlider = $(teamSlider),
        $teamSliderParent = teamSlider.parentElement,
        buildTeamSlider = function() {
          if (media(mw576) && teamSlides.length < 3) {
            if (hasSlickClass($teamSlider)) {
              unslick($teamSlider);
            }
          } else if (media(mw1024) && teamSlides.length < 4) {
            if (hasSlickClass($teamSlider)) {
              unslick($teamSlider);
            }
          } else if (media(mw1440) && teamSlides.length < 5) {
            if (hasSlickClass($teamSlider)) {
              unslick($teamSlider);
            }
          } else {
            if (hasSlickClass($teamSlider)) {
              return;
            }
            $teamSlider.slick({
              appendArrows: $('.slider-nav', $teamSliderParent),
              prevArrow: createArrow('arrow_black team-slider__prev', arrowSvg),
              nextArrow: createArrow('arrow_black team-slider__next', arrowSvg),
              slide: teamSelector,
              infinite: false,
              mobileFirst: true,
              variableWidth: true,
              centerMode: true,
              centerPadding: '0px',
              responsive: [{
                breakpoint: 575.98,
                settings: {
                  centerMode: false,
                  slidesToShow: 2
                }
              }, {
                breakpoint: 767.98,
                settings: {
                  centerMode: false,
                  slidesToShow: 3
                }
              }, {
                breakpoint: 1439.98,
                settings: {
                  centerMode: false,
                  slidesToShow: 4
                }
              }]
            });
          }
        }
      windowFuncs.resize.push(buildTeamSlider);
    }
  
  
    // настройки grab курсора на всех слайдерах
    $('.slick-list.draggable').on('mousedown', function() {
      $(this).addClass('grabbing');
    });
  
    $('.slick-list.draggable').on('beforeChange', function() {
      $(this).removeClass('grabbing');
    });
  
    $(document).on('mouseup', function() {
      $('.slick-list.draggable').removeClass('grabbing');
    });
  
  
  })();
  ;
  (function() {
    let mapSect = id('map-sect');
  
    if (mapSect) {
      let hightlightElement = function(e) {
        let target = e.target;
        console.log(target);
        console.log(target.classList);
        if (target && target.classList.contains('map-sect__a')) {
          let highlightedElement = q('[data-city="' + target.textContent + '"]', mapSect);
          if (highlightedElement) {
            highlightedElement.classList.toggle('hover');
          }
        }
      };
  
      mapSect.addEventListener('mouseover', hightlightElement);
      mapSect.addEventListener('mouseout', hightlightElement);
    }
  
  })();
  ;
  (function() {
    let filter = id('filter'),
      doubleFormSect = id('double-form-sect');
  
    if (filter) {
      initTabs(
        q('.filter__buttons', filter),
        q('.filter__categories', filter)
      );
    }
  
    if (doubleFormSect) {
      initTabs(
        q('.double-form-headings', doubleFormSect),
        qa('.double-form-wrap', doubleFormSect, true)
      );
    }
  })();
  ;
  (function() {
    let searchForms = qa('.search-form');
  
    if (searchForms && searchForms.length > 0) {
      // Регулярное выражение для фильтрации нажатой клавиши в поле ввода
      // Когда нажата одна из этих клавиш, то поиск производить не будем
      let keyCodeRegExp = /shift|control|meta|alt|caps|tab|escape/i,
        // для поддержки IE
        keysCodes = [16 /*shift*/, 17 /*ctrl*/, 20 /*caps*/, 27 /*esc*/],
        // Функция отправки и получения ajax-запроса
        ajaxQuery = function(e, form, searchValue) {
          if (e && e.type === 'submit') {
            e.preventDefault();
            clearTimeout(inputTimer);
          }
  
          let xhr = new XMLHttpRequest(),
            data = 'action=ajax_search&term=' + searchValue,
            resultBlock = q('.search-result', form);
  
          xhr.open(form.method, form.action)
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.send(data);
  
          form.classList.add('searching');
  
          xhr.addEventListener('readystatechange', function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              form.classList.remove('searching');
              form.classList.add('show-results');
              resultBlock.innerHTML = xhr.response;
            }
          });
        },
        // Функция отмены поиска, т.е. закрытия окна результатов
        cancelSearch = function(e) {
          let target = e.target,
            openedSearchForm = q('.search-form.show-list');
  
          if (openedSearchForm && (target !== openedSearchForm && !openedSearchForm.contains(target) || e.type === 'focusout')) {
            openedSearchForm.classList.remove('show-list');
            // Если показан результат и он not found, то удалим его и очистим поле запроса
            if (openedSearchForm.classList.contains('show-results')) {
              let notFound = q('.search-result__not-found', openedSearchForm);
              if (notFound) {
                let resultBlock = notFound.parentElement,
                  input = q('.search-inp', openedSearchForm);
                openedSearchForm.classList.remove('show-results');
                resultBlock.innerHTML = '';
                input.value = '';
              }
            }
          }
        },
        // Функция готовности к поиску, открытие окна результатов и т.д.
        setReadyToSearch = function(e) {
          // Показываем окно результатов
          this.classList.add('show-list');
        },
        // Таймер для ввода
        inputTimer;
  
      // Для каждой формы назначаем обработчики событий
      for (var i = searchForms.length - 1; i >= 0; i--) {
        let resultBlock = q('.search-result', searchForms[i]),
          searchInput = q('.search-inp', searchForms[i]),
          searchValue = '',
  
          // Функция удаления пробелов по бокам у запроса
          // чтобы исключить множественный пробел между словами
          prepareSearchValue = function() {
            if (event.code === 'Enter' || event.key === 'Enter') {
              event.preventDefault();
              clearTimeout(inputTimer);
            }
            searchValue = searchInput.value.trim();
          };
          searchForms[i].addEventListener('focusin', setReadyToSearch);
  
        // Фокус внутри формы задает готовность к поиску (для этого пришлось задать форме tabindex)
        // Потеря фокуса отменяет поиск и закрывает окно (закрытие при клике вне формы)
        searchForms[i].addEventListener('focusout', cancelSearch);
  
        // Обработчик отправки формы
        searchForms[i].addEventListener('submit', function(e) {
          ajaxQuery(e, this, searchValue);
        });
  
        // Каждое нажатие клавиши будет подготавливать к отправке текст запроса
        // чтобы исключить множественный пробел между словами
        searchInput.addEventListener('keydown', prepareSearchValue);
  
        searchInput.addEventListener('keyup', function(e) {
          // Только если нажата клавиша, которой нет в "списке" регулярного выражения
          // Для IE используем keyCode
          if (e.code && e.code.search(keyCodeRegExp) === -1 || keysCodes.indexOf(e.keyCode) === -1) {
            clearTimeout(inputTimer);
  
            if (searchInput.value.trim() !== searchValue) {
              prepareSearchValue();
            }
            // Если введено более 2-х символов, то будем запускать таймер поиска
            if (searchValue.length > 2) {
              inputTimer = setTimeout(function(e) {
                ajaxQuery(e, searchInput.form, searchValue);
              }, 1000);
            }
          }
        });
      }
    }
  })();
  ;
  (function() {
    let $newsSect = id('news-sect'),
      $loadmoreBtn = id('loadmore-btn');
  
    if ($newsSect && $loadmoreBtn) {
      let totalCountPosts = $newsSect.dataset.postsCount,
        numberposts = $newsSect.dataset.numberposts,
        $newsBlock = q('.news', $newsSect),
        postsOnPage = qa('.post', $newsSect),
        loadPosts = function(event) {
          $loadmoreBtn.classList.add('loading');
          $loadmoreBtn.blur();
  
          let xhr = new XMLHttpRequest(),
            data = 'action=print_posts&numberposts=' + numberposts + '&offset=' + postsOnPage.length;
  
          xhr.open('POST', siteUrl + '/wp-admin/admin-ajax.php');
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.send(data);
  
          xhr.addEventListener('readystatechange', function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              let posts = xhr.response;
              
              $loadmoreBtn.classList.remove('loading');
              $newsBlock.innerHTML += posts;
              postsOnPage = qa('.post', $newsSect);
  
              $newsBlock.style.maxHeight = $newsBlock.scrollHeight + 'px';
  
              if (postsOnPage.length == totalCountPosts) {
                $loadmoreBtn.setAttribute('hidden', '');
              } else {
                $loadmoreBtn.focus();
              }
  
            }
          });
        };
  
      $newsBlock.style.maxHeight = $newsBlock.scrollHeight + 'px';
  
      $loadmoreBtn.addEventListener('click', loadPosts);
  
      console.log('totalCountPosts', totalCountPosts);
      console.log('numberposts', numberposts);
    }
  
  })();
  mapBlock = id('map');
  
  if (mapBlock) {
    let ymapsInit = function() {
      let tag = document.createElement('script');
      tag.setAttribute('src', 'https://api-maps.yandex.ru/2.1/?apikey=82596a7c-b060-47f9-9fb6-829f012a9f04&lang=ru_RU&onload=ymapsOnload');
      body.appendChild(tag);
      mapBlock.removeEventListener('lazyloaded', ymapsInit);
    }
    
    mapBlock.addEventListener('lazyloaded', ymapsInit);
  }

  // Задаем обработчики событий 'load', 'resize', 'scroll'
  // Для объекта window (если массивы не пустые)
  let closeMenu = function() {
    menu.close();
  };
  
  windowFuncs.scroll.push(closeMenu);
  windowFuncs.resize.push(setVh);
  for (let eventType in windowFuncs) {
    if (eventType !== 'call') {
      let funcsArray = windowFuncs[eventType];
      if (funcsArray.length > 0) {
        windowFuncs.call(funcsArray);
        window.addEventListener(eventType, windowFuncs.call);
      }
    }
  }

  // Делаем глобальный lazy, чтобы потом можно было обновлять его через lazy.refresh()
  lazy = new lazyload({
    clearSrc: true,
    clearMedia: true
  });


});