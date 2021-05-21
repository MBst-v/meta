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