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