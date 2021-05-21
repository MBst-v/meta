//polyfills
//=include intersectionObserverPolyfill.js
//=include customEventsPolyfill.js
//=include utils.js
//=include online-matching.js

document.addEventListener('DOMContentLoaded', function() {

  fakeScrollbar = id('fake-scrollbar');

  // Инициализируем поддержку svg (в основном это надо для svg use в IE)
  svg4everybody();


  //includes
  //=include menu.js
  hdr = id('hdr');
  sticky(hdr);
  //=include popups.js
  //=include forms.js
  //=include telMask.js
  //=include sliders.js
  //=include map.js
  //=include tabsInit.js
  //=include ajax-search.js
  //=include loadmore.js
  //=include initMap.js

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