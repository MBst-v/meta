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