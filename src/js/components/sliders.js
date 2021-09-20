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