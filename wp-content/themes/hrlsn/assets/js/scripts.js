let vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);
if (document.getElementById('ticker-line')) {
    let tickerWidth = document.getElementById('ticker-line').offsetWidth;
    document.documentElement.style.setProperty('--tw', `${tickerWidth}px`);
}


jQuery(function($){

    $(document).ready(function () {

      $('body').addClass('fully-loaded');

      /* mobile similar products slider */
      initSimilarSlider();

      /* mobile menu */
      $('.h-mobmenu-link span').on('click', function() {
        openMobileMenu();
      });

      $('.h-mobmenu__header__close').on('click', function() {
        closeMobileMenu();
      });

      $('.h-mobmenu').click(function(event) { 
        var target = $(event.target);
        if ($('.h-mobmenu').hasClass('active') && !target.closest('.h-mobmenu__wrapper').length) {
          closeMobileMenu();
        }  
      });

      /* popups */
      $('.notice-popup [data-action=close]').on('click', function() {
        $(this).closest('.notice-popup').addClass('hidden');
        let type = $(this).attr('data-type');
        setPopupCloseCookie(type);
      });

      var urlParams = new URLSearchParams(window.location.search);
      var nm = urlParams.get('nm');
      if (nm && nm == 'confirmed') {
        setPopupCloseCookie('subscribe');
      }

      let cookiesPopup = Cookies.get('hrlsn_popup_cookies');
      if (!cookiesPopup) $(".cookie-notice").removeClass('hidden');

      let locationPopup = Cookies.get('hrlsn_popup_location');
      if (!locationPopup) $(".location-notice").removeClass('hidden');

      let subscribePopup = Cookies.get('hrlsn_popup_subscribe');
      if (!subscribePopup) $(".subscribe-notice").removeClass('hidden');

      let welcomePopup = Cookies.get('hrlsn_popup_welcome');
      if (!welcomePopup) $(".welcome-notice").removeClass('hidden');

      /* subscribe button */
      if ($('input.tnp-submit').length) {
        let oldButton = $('input.tnp-submit');
        let btnTitle = oldButton.val();
        $('input.tnp-submit').after('<button class="inline" type="submit">[ <span class="link">' + btnTitle + '</span> ]</button>');
        oldButton.remove();
      }

      /* filters */
      $('.h-filters__filters span').on('click', function() {
        if (!$(this).hasClass('open')) {
          openFiltersPopup();
        } else {
          closeFiltersPopup();
        }
      });

      $('.h-filters__block__close').on('click', function() {
        closeFiltersPopup();
      });

      // click outside
      $('body').click(function(event) { 
        var target = $(event.target);
        if ($('.h-filters__filters span').hasClass('open') && !target.closest('.h-filters__block').length && !target.closest('.h-filters__filters').length) {
          closeFiltersPopup();
        }
        if (!isMobileView() && $('body').hasClass('search-active') && !target.closest('.h-main').length && !target.closest('.h-search').length && !target.closest('.catalog-page__qedit').length) {
          $('.h-links__search-close span').trigger('click');
        }
        if (isMobileView() && $('.prod-info__desc__chart__table').hasClass('active') && !target.closest('.prod-info__desc__chart__table').length && !target.closest('.prod-info__desc__chartlink').length) {
          $('.prod-info__desc__chart__table__close').trigger('click');
        }
        if ($('.notice-popup').is(':visible') && !target.closest('.notice-popup').length && !target.closest('[data-type-link="notice"]').length && !target.closest('.cart-page__right__checkout__btn').length) {
          $('.notice-popup').addClass('hidden');
        }
      });

      $('[data-filter-type="all"]').on('click', function() {
        let type = $(this).attr('data-clear-type');
        $('[data-filter-type="'+type+'"]').removeAttr('checked');
      });

      $('[data-filter-type="category"]').on('change', function() {
        let atLeastOneChecked = false;
        $('[data-filter-type="category"]').each(function( index ) {
          if ($(this).is(':checked')) {
            atLeastOneChecked = true;
          }
        });
        if (atLeastOneChecked) {
          $('[data-clear-type="category"]').removeAttr('checked');
        } else {
          $('[data-clear-type="category"]').prop( "checked", true );
        }
      });

      $('.h-filters__block__apply').on('click', function() {
        // getting data object (except cats)
        let dataObj = getFormData($('#filters-form'));
        $.each(dataObj, function( key, value ) {
          if (key.indexOf("cat_") >= 0 || key.indexOf("cats") >= 0 || key.indexOf("tag_") >= 0 || key.indexOf("tags") >= 0) {
            delete dataObj[key];
          }
        });
        // getting data string
        let dataStr = jQuery.param(dataObj);
        // adding actual cats to string
        let catsChecked = [];
        $('[data-filter-type="category"]').each(function( index ) {
          if ($(this).is(':checked')) {
            let id = $(this).attr('data-filter-value');
            catsChecked.push(id);
          }
        });
        let catsCheckedStr = catsChecked.join("-");
        // adding actual tags to string
        let tagsChecked = [];
        $('[data-filter-type="tag"]').each(function( index ) {
          if ($(this).is(':checked')) {
            let id = $(this).attr('data-filter-value');
            tagsChecked.push(id);
          }
        });
        let tagsCheckedStr = tagsChecked.join("-");
        // getting final data string
        let finalStart = '?';
        if (catsCheckedStr) finalStart += 'cats=' + catsCheckedStr + '&';
        if (tagsCheckedStr) finalStart += 'tags=' + tagsCheckedStr + '&';
        let finalDataStr = finalStart + dataStr;
        // redirecting form
        let fromAction = $('#filters-form').attr('action');
        //console.log(fromAction + finalDataStr);
        window.location.href = fromAction + finalDataStr;
      });   

      /* add to cart size */
      $('.cfvsw-swatch-inner').on('click', function() {
        if ($(this).closest('.prod-list').length) {
          let addToCartBtn = $(this).closest('.prod-list__item__form__sizes').find('.add_to_cart_button');
          setTimeout(() => {
            if (addToCartBtn.hasClass('cfvsw_variation_found')) {
              addToCartBtn.trigger('click');
            } else {
              $(this).trigger('click');
            }
          }, 50); 
        }
      });

      /* size chart */
      $('.prod-info__desc__chartlink').on('click', function() {
        $(this).toggleClass('open');
        if (isMobileView()) {
          $('.prod-info__desc__chart__table').addClass('active');
        } else {
          $('.prod-info__desc__chart__table').slideToggle('fast');
        }
      });

      $('.prod-info__desc__chart__table__close').on('click', function() {
        $('.prod-info__desc__chartlink').removeClass('open');
        $('.prod-info__desc__chart__table').removeClass('active');
      });

      /* search */
      $('.h-links__search span').on('click', function() {
        $('body').addClass('search-active');
        $('.h-search--desktop').slideDown('fast');
        $('.h-search__form__input input').focus();
      });

      $('.h-links__search-close span').on('click', function() {
        $('.h-search--desktop').slideUp('fast');
        $('.h-search__form__input input').blur();
        setTimeout(() => {
          $('body').removeClass('search-active');
        }, 200);
      });

      $('.search-moblink').on('click', function() {
        $('body').addClass('search-active');
        $('.h-search--mobile .h-search__form__input input').focus();
      });
      
      /* search results */
      $('.catalog-page__qedit').on('click', function() {
        if (isMobileView()) {
          $('.h-mobmenu-link span').trigger('click');
          $('.search-moblink').trigger('click');
        } else {
          $('.h-links__search span').trigger('click');
        }
      });
      
      /* product page add to cart*/
      $('.prod-info__form form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
          type:     $(this).attr( 'method' ),
          url:      $(this).attr( 'action' ),
          data:     $(this).serialize(),
          dataType: 'html',
          complete: function() {
            $( document.body ).trigger( 'updated_wc_div' );
            updateCartDivQty();
            showAddedToCartPopup();
            renameAddToCartBtn(true);
          }
        });
      });

      /* cart quantity plus */
      $(document).on('click', '.h-cart__item .plus', function() {
        let input = $(this).closest('.h-cart__item').find('input.qty');
        let currentQty = parseInt(input.val());
        let maxQty = parseInt(input.attr('max'));
        if (!maxQty || maxQty < 1) maxQty = 10000;

        if (currentQty < maxQty) {
          let newQty = ++currentQty;
          $(this).closest('.h-cart__item').find('.qty-number').text(newQty);
          input.val(newQty);
          setTimeout(() => {
            $( "[name='update_cart']" ).removeAttr( 'disabled' );
            $( "[name='update_cart']" ).trigger( 'click' );
          }, 100);
        }
      });

      /* cart quantity minus */
      $(document).on('click', '.h-cart__item .minus', function() {
        let input = $(this).closest('.h-cart__item').find('input.qty');
        let currentQty = parseInt(input.val());

        if (currentQty > 1) {
          let newQty = --currentQty;
          $(this).closest('.h-cart__item').find('.qty-number').text(newQty);
          input.val(newQty);
          setTimeout(() => {
            $( "[name='update_cart']" ).removeAttr( 'disabled' );
            $( "[name='update_cart']" ).trigger( 'click' );
          }, 100);
        } else {
          $(this).closest('.h-cart__item').find('.product-remove a').trigger('click');
        }
      });
      
      /* coupon */
      $(document).on('click', '.h-coupon__have span', function() {
        $('.h-coupon__have').addClass('hidden');
        $('.h-coupon__submit').removeClass('hidden');
        $('.h-coupon__submit input[type=text]').focus();
      });

      $(document).on('click', '.h-coupon__submit__trigger', function(e) {
        let couponCode = $('[name="coupon_code"]').val();
        if ($(this).hasClass('h-coupon__submit__trigger--checkout')) {
          couponCheck(couponCode, 'checkout');
        } else {
          couponCheck(couponCode);
        }
        // $('[name="apply_coupon"]').trigger('click');
      });
      
      $(document).on('keypress', '[name="coupon_code"]', function(e) {
        if (e.which == 13) {
          e.preventDefault();
          $('.h-coupon__submit__trigger').trigger('click');
        }
      });

      /* preorder description */
      $(document).on('click', '[data-link="backorder"]', function() {
        $('.backorder-notice').removeClass('hidden');
      });

      /* on variation change */
      $(document).on('change', '[name="variation_id"]', function() {
        setTimeout(() => {
          if ($(this).val()) {
            // if already in cart
            let activeVariationId = $('[name="variation_id"]').val();
            if ($('.prod-info__form__submit__variation[data-id="'+activeVariationId+'"]').length) {
              renameAddToCartBtn();
            }
            // out of stock
            else if ($('.woocommerce-variation-availability .stock').hasClass('out-of-stock')) 
            {
              let outOfStockText = $('.out-of-stock-text').html();
              $('.single_add_to_cart_button').html(outOfStockText).attr('disabled', 'disabled');
              $('.prod-info__form__submit__desc').addClass('hidden');
            } 
            // backorder
            else if ($('.woocommerce-variation-availability .stock').hasClass('available-on-backorder')) 
            {
              let backorderText = $('.backorder-text').html();
              $('.single_add_to_cart_button').html(backorderText).attr('disabled', false);
              $('.prod-info__form__submit__desc').removeClass('hidden');
            } 
            // in stock
            else
            {
              let inStockText = $('.in-stock-text').html();
              $('.single_add_to_cart_button').html(inStockText).attr('disabled', false);
              $('.prod-info__form__submit__desc').addClass('hidden');
            }
          } 
        }, 10);
      });


      // popup select location
      $("#select-location-form").on('submit', function(e) {
        e.preventDefault();
        let url = $('#select-location-url').val();
        if (url) {
          setTimeout(() => {
            window.location.href = url;
          }, 10);
        } else {
          // $('#select-location-url').addClass('popup-error');
        }
        $(this).closest('.notice-popup').find('.notice-popup__close').trigger('click');
      });

      $("#select-location-url").on('change', function() {
        $(this).removeClass('popup-error');
      });
      
      // subscription
      $("#subscription-form").on('submit', function(e) {
        e.preventDefault();
        let email = $('#subscription-email').val();
        if (validateEmail(email)) {
          console.log('BINGO');
        } else {
          $('#subscription-email').addClass('popup-error');
        }
      });

      $("#subscription-email").on('keyup paste change', function() {
        $(this).removeClass('popup-error');
      });

      $(".added-to-cart-popup__close").on('click', function() {
        $(".added-to-cart-popup").addClass('hidden');
      });



      /**************************** CHECKOUT BLOCK actions ****************************/


      $( document.body ).on( "updated_checkout", function(e) {
        // для обновления способов доставки после выбора города
        if ($(this).hasClass('update_process')) {
          $('.woocommerce-checkout').unblock().removeClass('update_process');
          loadDeliveryMethods();
          updateDeliveryHiddenFields();
          updateBoxberryText();
          checkStageStatus('city');
        }
        // для появления лоадера после ввода индекса на англ.сайте
        if ($(this).hasClass('update_process_2')) {
          $('.woocommerce-checkout').unblock().removeClass('update_process_2');
        }
        // для обновления ПВЗ Боксберри
        let current_stage = jQuery(".ch-stage--active").data("stage");
        if (current_stage == "delivery") {
          setTimeout(function() {
            checkStageStatus('delivery');
          }, 200);
        }
        // для обновления названия кнопки
        if (current_stage == "payment") {
          setTimeout(function() {
            checkStageStatus('payment');
          }, 200);
        }
        // для обновления после применения купона
        if ($(this).hasClass('coupon_process')) {
          /*if (!$("form.woocommerce-checkout").hasClass('virtual-checkout')) {
            let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();
            if (current_lang !== 'en') {
              if (current_stage == 'details') {
                loadStage('delivery', true);
              } else if (current_stage == 'payment') {
                loadStage('details', true);
                setTimeout(function() {
                  loadStage('delivery', true);
                }, 200);
              }
            }
          }*/
          // удаляем куки
          Cookies.set( 'hrlsn_coupon_shipping', '0', { path: '/', expires: 1 } );
          $('body').removeClass('coupon_process');
        }
        // для обновления после применения купона (NEW)
        if ($(this).hasClass('coupon_process_new')) {
          loadDeliveryMethods();
        }
        // для обновления после изменения кол-ва
        if ($(this).hasClass('edit-order-mobile')) {
          $("body").removeClass('edit-order-mobile');
          $(".h-cart__change").removeClass('hidden');
          $(".h-cart__return").addClass('hidden');
        }
      });
  
      $(".ch-stage input[name='hrlsn_checkout_city_field']").on("keypress", function() {
        $(".ch-sequence__action__btn").addClass('disabled');
      })


      /* navigate checkout */
      $(".ch-sequence__action__btn").on('click', function() {
        if (!$(this).hasClass('disabled')) {
          let stage = detectStage('next');
          if (stage == 'submit') {
            $( 'form.checkout' ).trigger( 'submit' );
            $("input[name='woocommerce_checkout_place_order']").click();
          } else {
            loadStage(stage);
          }
        } else {
          let stage = $(".ch-stage--active").data('stage');
          checkStageStatus(stage, true);
        }
        updateStageHeight();
      });
      $("[data-stage='next']").on('click', function() {
        let stage = detectStage('next');
        loadStage(stage);
      });
      $(".ch-sequence__nav__prev").on('click', function() {
        if (!$(this).hasClass('disabled')) {
          let stage = detectStage('prev');
          loadStage(stage, true);
        }
      });

      /* open backorder popup */
      $('.cart-page__right__checkout__btn').on('click', function(e) {
        if (orderHasPreorderItems()) {
          e.preventDefault();
          showPreorderPopup();
        }
      });

      /* close backorder popup */
      $('[data-action="place-order"]').on('click', function() {
        window.location.href = $('.cart-page__right__checkout__btn').attr('href');
      });

      // on loading
      $(".ch-stage input[name='hrlsn_checkout_city_field'], .ch-stage input[name='hrlsn_checkout_address_field'], .ch-stage input[name='billing_postcode']").val('');
      updateStageHeight();

      // for virtual orders
      if ($("form.woocommerce-checkout").hasClass('virtual-checkout')) {
        checkStageStatus('details');
      }

      // city check
      $(".ch-stage input[name='city_suggest']").on('focus', function() {
        $(".ch-stage .city_results").show();
        $(".ch-sequence__nav").hide();
      });
      $(".ch-stage input[name='city_suggest']").on('input', function() {
        $(".ch-stage .city_results").show();
        $(".ch-sequence__nav").hide();
        $(this).attr('data-selected', 'false');
        checkStageStatus('city');
      });
      $(".ch-stage .city_results span").on('click', function() {
        $(".ch-stage .city_results").hide();
        $(".ch-sequence__nav").show();
        $(".ch-stage input[name='city_suggest']").val($(this).text());
        $(".ch-stage input[name='city_suggest']").attr('data-selected', 'true');
        checkStageStatus('city');
      });  
      $(".ch-stage input[name='billing_postcode']").on('input', function() {
        let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();
        if (current_lang == 'en') {
          $('.woocommerce-checkout').addClass('update_process');
          checkStageStatus('city');
        }
      });

      // delivery select
      $(".ch-stage input[name='shipping_method[0]']").on('change', function() {
        let current_stage = $(".ch-stage--active").data("stage");
        if (current_stage == "delivery") {
          updateBoxberryText();
          updateDeliveryMethodDesc();
          checkStageStatus('delivery');
        }
      });

      // on loading
      if ($(".ch-stage input[name='shipping_method[0]']:checked").length > 0) {
        if (typeof $(".ch-stage input[name='delivery']:checked").val() !== 'undefined') {
          let split = $(".ch-stage input[name='delivery']:checked").val().split(":");
          $(".ch-stage__info__"+split[0]).removeClass('hidden');
        }
      };

      // details check
      $(".ch-stage input[name='billing_first_name'], .ch-stage input[name='billing_last_name'], .ch-stage input[name='billing_email'], .ch-stage input[name='hrlsn_checkout_address_field'], .ch-stage input[name='billing_phone'], .ch-stage input[name='billing_address_1'], .ch-stage input[name='billing_street_name'], .ch-stage input[name='billing_house_number']").on('input keypress', function() {
        checkStageStatus('details');
      });

      // coupon
      $(".h-cart__checkout__coupon").on('click', function() {
        $(".h-cart__checkout__error").addClass('hidden');
        $(".h-cart__checkout--couponinfo").addClass('hidden');
        $(".h-cart__checkout--couponadd").removeClass('hidden');
        $(".h-cart__checkout__coupontype").focus();
      });
      $(".h-cart__checkout__btn").on('click', function() {
        if ($(".h-cart__checkout__coupontype").val() == 'sale30' || $(".h-cart__checkout__coupontype").val() == 'SALE30') {
          $(".h-cart__checkout__error").removeClass('hidden');
          $(".h-cart__checkout__coupontype").val('');
          $(".h-cart__checkout--couponadd").addClass('hidden');
          $(".h-cart__checkout--coupondelete").addClass('hidden');
          $(".h-cart__checkout--couponinfo").removeClass('hidden');
        } else {
          $(".h-cart__checkout--coupondelete").removeClass('hidden');
          $(".h-cart__checkout--couponadd").addClass('hidden');
          $(".h-cart__checkout__coupontype").val('');
          $(".h-cart__totals--coupon").removeClass('hidden');
          $(".h-cart__totals--coupon").addClass('in');
          setTimeout(function() {
            $(".h-cart__totals--coupon").removeClass('in');
          }, 200);
        }
      });
      $(".h-cart__checkout__coupon--detele").on('click', function() {
        $(".h-cart__checkout--couponadd").addClass('hidden');
        $(".h-cart__checkout--coupondelete").addClass('hidden');
        $(".h-cart__checkout--couponinfo").removeClass('hidden');
        $(".h-cart__totals--coupon").removeClass('in');
        $(".h-cart__totals--coupon").addClass('out');
        setTimeout(function() {
          $(".h-cart__totals--coupon").removeClass('out');
          $(".h-cart__totals--coupon").addClass('hidden');
        }, 200);
      }); 



  });



  /**
   * on Added to Cart action
   */
  $( document.body ).on( 'added_to_cart', function() {
    updateCartDivQty();
    showAddedToCartPopup();
  });

  /**
   * on Updated Cart action
   */
  $( document.body ).on( 'updated_cart_totals', function() {
    let newQty = $('.cart-total-qty').val();
    updateCartDivQty(newQty);
  });

  /* fix iOS issue with videos */
  document.addEventListener('DOMContentLoaded', function () {
    var videoElements = document.querySelectorAll('video');
  
    videoElements.forEach(function(videoElement) {
      videoElement.controls = false;
  
      videoElement.addEventListener('play', function () {
        this.controls = false;
      });
  
      videoElement.addEventListener('pause', function () {
        this.controls = false;
      });
    });
  });

  /**************************** CHECKOUT BLOCK functions ****************************/

  function detectStage(dir) {
    let stage = false;
    let current = $(".ch-stage--active").data('stage');
    let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();
    if (dir == 'next') {
      switch (current) {
        case 'city':
          stage = 'delivery';
          break;
        case 'delivery':
          stage = 'details';
          break;
        case 'details':
          if (current_lang == 'en') {
            console.log('confirmation');
            stage = 'confirmation';
          } else {
            console.log('payment');
            stage = 'payment';
          }
          break;
        case 'confirmation':
          stage = 'payment';
          break;
        case 'payment':
          stage = 'submit';
          break;
        default:
          stage = 'city';
          break;
      }
    }
    if (dir == 'prev') {
      switch (current) {
        case 'delivery':
          stage = 'city';
          break;
        case 'details':
          stage = 'delivery';
          break;
        case 'confirmation':
          stage = 'details';
          break;
        case 'payment':
          if (current_lang == 'en') {
            stage = 'confirmation';
          } else {
            stage = 'details';
          }
          break;
        default:
          stage = 'city';
          break;
      }
    }
    return stage;
  }

  function loadStage(stage, prev = false) {

    // errors
    if (stage == 'payment') {
      $('.woocommerce-NoticeGroup').removeClass('hidden');
    } else {
      $('.woocommerce-NoticeGroup').addClass('hidden');
    }

    let in_class = 'in';
    let out_class = 'out';

    if (prev) {
      in_class = 'prev-in';
      out_class = 'prev-out';
    } 

    let current_stage = $(".ch-stage--active").data('stage');
    $("[data-stage="+current_stage+"]").addClass(out_class);
    $("[data-stage="+stage+"]").addClass(in_class).addClass('ch-stage--active');

    setTimeout(function() {
      $("[data-stage="+current_stage+"]").removeClass('ch-stage--active');
      if (prev) {
        $("[data-stage="+stage+"]").removeClass('ch-stage--previous');
      } else {
        $("[data-stage="+current_stage+"]").addClass('ch-stage--previous');
      }
      $("[data-stage="+stage+"]").removeClass(in_class);
      updateStageHeight();
    }, 200);

    setTimeout(function() {
      $("[data-stage="+current_stage+"]")
        .removeClass(out_class);
    }, 500);

    let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();

    $(".ch-sequence__nav__prev").removeClass('disabled');
    $(".ch-sequence__action__btn i").addClass('hidden');
    $(".ch-sequence__action__btn i.continue").removeClass('hidden');
    switch (stage) {
      case 'city':
        activateDeliveryNotice();
        $(".ch-sequence__nav__prev").addClass('disabled');
        break;
      case 'delivery':
        deactivateDeliveryNotice();
        updateDeliveryMethodDesc();
        $(".ch-sequence__action__btn i").addClass('hidden');
        $(".ch-sequence__action__btn i.continue").removeClass('hidden');
        break;
      case 'details':
        updateBoxberryText();
        updateDeliveryAddressField();
        if ($("form.woocommerce-checkout").hasClass('virtual-checkout')) {
          $(".ch-sequence__nav__prev").addClass('disabled');
        }
        $(".ch-sequence__action__btn i").addClass('hidden');
        $(".ch-sequence__action__btn i.overview").removeClass('hidden');
        break;
      case 'confirmation':
        fillInReviewFields();
        $(".ch-sequence__action__btn i").addClass('hidden');
        $(".ch-sequence__action__btn i.choose").removeClass('hidden');
        break;
      case 'payment':
        if (current_lang == 'en') {
          uncheckPaymentMethod();
        } else {
          fillInReviewFields();
        }
        $(".ch-sequence__action__btn i.continue").addClass('hidden');
        $(".ch-sequence__action__btn i.pay").removeClass('hidden');
        break;
      default:
        break;
    }
    deactivateStage();
    checkStageStatus(stage);
  }

  function checkStageStatus(stage, error = false) {
    switch (stage) {
      case 'city':
        
        let city_selected = $(".ch-stage input[name='hrlsn_checkout_city_field']").val();
        let billing_city = $(".ch-stage input[name='billing_city']").val();
        let billing_postcode = $(".ch-stage input[name='billing_postcode']").val();
        if (validateField(city_selected) && validateField(billing_city) && validatePostcode(billing_postcode)) { 
          $('[data-error="city"], [data-error="postcode"]').addClass('hidden');
          activateStage();
          // добавляем лоадер после ввода индекса для англ. сайта
          let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();
          if (current_lang == 'en' && $('body').hasClass('update_process')) {
            $('body').addClass('update_process_2');
            $row = $('.woocommerce-checkout');
            $row.block({
              message: null,
              overlayCSS: {
                opacity: 0.8
              }
            });
          }
        } else {
          deactivateStage();
          if (error) {
            if (!validateField(city_selected) || !validateField(billing_city)) {
              $('[data-error="city"]').removeClass('hidden');
            }
            if (!validatePostcode(billing_postcode)) {
              $('[data-error="postcode"]').removeClass('hidden');
            }
          }
        }
        break;
      case 'delivery':
        let delivery_length = $(".ch-stage input[name='shipping_method[0]']:checked").length;
        let delivery_selected = $(".ch-stage input[name='shipping_method[0]']:checked").val();
        if (validateDelivery(delivery_length, delivery_selected)) {
          $('[data-error="boxberry"]').addClass('hidden');
          activateStage();
        } else {
          deactivateStage();
          if (error) {
            $('[data-error="boxberry"]').removeClass('hidden');
          }
        }
        break;
      case 'details':
        let name = $(".ch-stage input[name='billing_first_name']").val();
        let surname = $(".ch-stage input[name='billing_last_name']").val();
        let email = $(".ch-stage input[type='email']").val();
        let phone = $(".ch-stage input[name='billing_phone']").val();
        let address = $(".ch-stage input[name='billing_address_1']").val();
        /*let street = $(".ch-stage input[name='billing_street_name']").val();
        let house = $(".ch-stage input[name='billing_house_number']").val();*/
        if (validateField(name) && validateField(surname) && validateEmail(email) && validatePhone(phone) /*&& validateField(street) && validateField(house)*/ && validateField(address)) { 
          $('[data-error="first_name"], [data-error="last_name"], [data-error="email"], [data-error="email_format"], [data-error="phone"], [data-error="phone_format"], [data-error="address"], [data-error="street"], [data-error="house"]').addClass('hidden');
          activateStage();
        } else {
          deactivateStage();
          if (validateField(name)) {
            $('[data-error="first_name"]').addClass('hidden');
          }
          if (validateField(surname)) {
            $('[data-error="last_name"]').addClass('hidden');
          }
          if (validateField(email)) {
            $('[data-error="email"]').addClass('hidden');
          }
          if (validateEmail(email)) {
            $('[data-error="email_format"]').addClass('hidden');
          }
          if (validateField(phone)) {
            $('[data-error="phone"]').addClass('hidden');
          }
          if (validatePhone(phone)) {
            $('[data-error="phone_format"]').addClass('hidden');
          }
          /*if (validateField(street)) {
            $('[data-error="street"]').addClass('hidden');
          }
          if (validateField(house)) {
            $('[data-error="house"]').addClass('hidden');
          }*/
          if (validateField(address)) {
            $('[data-error="address"]').addClass('hidden');
          }
          if (error) {
            $('[data-error="first_name"], [data-error="last_name"], [data-error="email"], [data-error="email_format"], [data-error="phone"], [data-error="phone_format"], [data-error="address"], [data-error="street"], [data-error="house"]').addClass('hidden');
            if (!validateField(name)) {
              $('[data-error="first_name"]').removeClass('hidden');
            }
            if (!validateField(surname)) {
              $('[data-error="last_name"]').removeClass('hidden');
            }
            if (!validateField(email)) {
              $('[data-error="email"]').removeClass('hidden');
              $('[data-error="email_format"]').addClass('hidden');
            }
            if (validateField(email) && !validateEmail(email)) {
              $('[data-error="email"]').addClass('hidden');
              $('[data-error="email_format"]').removeClass('hidden');
            }
            if (!validateField(phone)) {
              $('[data-error="phone"]').removeClass('hidden');
              $('[data-error="phone_format"]').addClass('hidden');
            }
            if (validateField(phone) && !validatePhone(phone)) {
              $('[data-error="phone"]').addClass('hidden');
              $('[data-error="phone_format"]').removeClass('hidden');
            }
            /*if (!validateField(street)) {
              $('[data-error="street"]').removeClass('hidden');
            }
            if (!validateField(house)) {
              $('[data-error="house"]').removeClass('hidden');
            }*/
            if (!validateField(address)) {
              $('[data-error="address"]').removeClass('hidden');
            }
          }
        }
        break;
      case 'confirmation':
        activateStageBtn();
        break;
      case 'payment':
        activateStageBtn();
        setSubmitBtnTitle();
        break;
      default:
        break;
    }

    updateStageHeight();
  }

  function activateStage() {
    $(".ch-sequence__action__btn").removeClass('disabled');
  }

  function activateStageBtn() {
    $(".ch-sequence__action__btn").removeClass('disabled');
  }

  function deactivateStage() {
    $(".ch-sequence__action__btn").addClass('disabled');
  }

  function validateEmail(value) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(value);
  }

  function validatePassword(value) {
    if (value.length > 5) {
      return true;
    } else {
      return false;
    }
  }

  function validateCity(value) {
    if (value == 'true') {
      return true;
    } else {
      return false;
    }
  }

  function validateAddress() {
    if ($("form.woocommerce-checkout").hasClass('virtual-checkout')) return true;
    let address_street = $(".ch-stage input[name='billing_street_name']");
    let address_house = $(".ch-stage input[name='billing_house_number']");

    // check for pick-up
    let deliveryInput = $(".ch-stage input[name='shipping_method[0]']:checked");
    let deliveryId = deliveryInput.val();
    if (deliveryId == 'local_pickup:54') {
      return true;
    } else {
      if (address_street.val().length && address_house.val().length) {
        return true;
      } else {
        return false;
      }
    }
  }

  function validateDelivery(length, selected) {
    if (length > 0) {
      let boxberry_link = $(".shipping_list_boxberry_self11 a").text();
      if (selected.indexOf("boxberry_self") >= 0) {
        if (boxberry_link.indexOf("(") >= 0) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    } else {
      return false;
    }
  }

  function validateField(value) {
    if (value.length > 1) {
      return true;
    } else {
      return false;
    }
  }

  function validatePostcode(value) {
    let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();
    if (current_lang == 'en' && value.length > 3 || current_lang == 'ru') {
      return true;
    } else {
      return false;
    }
  }

  function validatePhone(value) {
    if (value.length > 8) {
      return true;
    } else {
      return false;
    }
  }

  function setSubmitBtnTitle() {
    let current_payment_method = $("input[name='payment_method']:checked").val();
    let current_sum = parseInt($(".h-cart__checkout__sum bdi").text());
    if (current_payment_method == 'cod') {
      $(".ch-sequence__action__btn i.confirm").removeClass('hidden');
      $(".ch-sequence__action__btn i.pay").addClass('hidden');
    } else {
      if (current_sum > 0) {
        $(".ch-sequence__action__btn i.confirm").addClass('hidden');
        $(".ch-sequence__action__btn i.pay").removeClass('hidden');
      } else {
        $(".ch-sequence__action__btn i.confirm").removeClass('hidden');
        $(".ch-sequence__action__btn i.pay").addClass('hidden');
      }
    }
  }

  $('form.checkout input, form.checkout textarea').on('keydown', function(e){ 
    if (e.keyCode == 9) {
      e.preventDefault();
      if ($("#billing_first_name").is(":focus")) {
        $("#billing_last_name").focus();
      } else if ($("#billing_last_name").is(":focus")) {
        $("#billing_email").focus();
      } else if ($("#billing_email").is(":focus")) {
        $("#billing_phone").focus();
      } else if ($("#billing_phone").is(":focus")) {
        if ($("#billing_street_name").is(":visible")) {
          $("#billing_street_name").focus();
        } else {
          $("#billing_address_1").focus();
        }  
      } else if ($("#billing_address_1").is(":focus")) {
        $("#billing_address_2").focus();
      } else if ($("#billing_street_name").is(":focus")) {
        $("#billing_house_number").focus();
      } else if ($("#billing_house_number").is(":focus")) {
        $("#billing_address_2").focus();
      } else if ($("#billing_address_2").is(":focus")) {
        $("#order_comments").focus();
      }
    }
  });

  function updateDeliveryHiddenFields() {
    let deliveryInput = $(".ch-stage input[name='shipping_method[0]']:checked");
    let deliveryId = deliveryInput.val();
    let inner = deliveryInput.next().text();
    let index = inner.lastIndexOf(' ', inner.lastIndexOf(' ')-1);
    let deliveryLabel = inner.substr( 0, index );
    let deliveryPrice = inner.substr( index + 1 );

    $("#shipping_method_new li > div").addClass('hidden');
    let deliveryMethodBoxberry = $('#h-cart__totals--json b').html();
    if (deliveryId == 'boxberry_self:11') {
      deliveryInput.parent('label').next('div').removeClass('hidden').html(deliveryMethodBoxberry);
      deliveryInput.parent('label').next('div').find('a').show();
    } else {
      // в случае если boxberry не выбран
      $(".shipping_list_boxberry_self11 > div").html(deliveryMethodBoxberry);
      $(".shipping_list_boxberry_self11 > div > p > a").show();
    }

    $('body').trigger('update_checkout');
  }

  function updateBoxberryText() {
    let deliveryInput = $(".ch-stage input[name='shipping_method[0]']:checked");
    let deliveryId = deliveryInput.val();
    if (deliveryId == 'boxberry_self:11') {
      $(".shipping_list_boxberry_self11 > div").removeClass('hidden');
    } else {
      $(".shipping_list_boxberry_self11 > div").addClass('hidden');
    }
  }

  function updateDeliveryAddressField() {
    let deliveryInput = $(".ch-stage input[name='shipping_method[0]']:checked");
    let deliveryId = deliveryInput.val();
    let deliveryAddressBlock1 = $("input[name='billing_address_1']").closest("div");
    let deliveryAddressBlock2 = $("input[name='billing_address_2']").closest("div");
    // check for pick-up
    if (deliveryId == 'local_pickup:54') {
      $("input[name='billing_address_1']").val('Frederik Hendrikstraat 115');
      $("input[name='billing_street_name']").val('Frederik Hendrikstraat');
      $("input[name='billing_house_number']").val('115');
      deliveryAddressBlock1.hide();
      deliveryAddressBlock2.hide();
    } else {
      if ($("input[name='billing_address_1']").val() == 'Frederik Hendrikstraat 115') {
        $("input[name='billing_address_1'], input[name='billing_street_name'], input[name='billing_house_number']").val('');
      }
      deliveryAddressBlock1.show();
      deliveryAddressBlock2.show();
    }
  }

  function fillInReviewFields() {
    let current_lang = $(".woocommerce-checkout input[name='ch-language']").val();
    // check boxberry
    let deliveryInput = $(".ch-stage input[name='shipping_method[0]']:checked");
    let deliveryId = deliveryInput.val();

    // for POST NL
    /*
    if (deliveryId == 'flat_rate:40') {
      var s = $("input[name='billing_address_1']").val();
      var lastIndex = s.lastIndexOf(" ")

      var s1 = s.substring(0, lastIndex);
      var s2 = s.substring(lastIndex + 1);

      $("input[name='billing_street_name']").val(s1);
      $("input[name='billing_house_number']").val(s2 );
    }
    */

    let inputName = $('input[name="billing_first_name"]').val()+' '+$('input[name="billing_last_name"]').val();
    let inputPhone = $('input[name="billing_phone"]').val();
    let inputEmail = $('input[name="billing_email"]').val();
    // let inputAddress = $('input[name="billing_street_name"]').val() + ' ' + $('input[name="billing_house_number"]').val();
    let inputAddress = $('input[name="billing_address_1"]').val();

    // check for pick-up
    if (deliveryId == 'local_pickup:54') {
      inputAddress = null;
    } else {
      let inputPostcode = $('input[name="billing_postcode"]').val();
      let inputCity = $('input[name="billing_city"]').val();
      // let inputAddress1 = $('input[name="billing_street_name"]').val() + ' ' + $('input[name="billing_house_number"]').val();
      let inputAddress1 = $('input[name="billing_address_1"]').val();
      let inputAddress2 = $('input[name="billing_address_2"]').val();
      inputAddress = inputPostcode + ' '+ inputCity + ', ' + inputAddress1;
      if (inputAddress2) inputAddress += ', '+inputAddress2;
    }

		$('.ch-review-name').text(inputName);
		$('.ch-review-email').text(inputEmail);
		$('.ch-review-phone').text(inputPhone);
    if (inputAddress && !$("form.woocommerce-checkout").hasClass('virtual-checkout')) {
      $('.ch-review-address-title').show();
      $('.ch-review-address').show().text(inputAddress);
    } else {
      $('.ch-review-address-title').hide();
      $('.ch-review-address').hide();
    }
  }

  function uncheckPaymentMethod() {
    $('#payment_method_stripe').prop('checked', false);
    $('.payment_box.payment_method_stripe').hide();
  }

  function updateCashOnDelivery() {
    $('.ch-pay-cash-btn').addClass('hidden');

    // get delivery Id
    let deliveryInput = $(".ch-stage input[name='shipping_method[0]']:checked");
    let deliveryId = deliveryInput.val();

    // for self pickup
    /*
    if (deliveryId == 'local_pickup:2') {
      $('.ch-pay-cash-btn').removeClass('hidden');
    }
    */

    // проверка на сертфикат
    let products_html = $('#order_review .h-cart__products').text();
    let cert_html = 'сертификат';
    if (products_html.includes(cert_html)) {
      $('.ch-pay-cash-btn').addClass('hidden');
    }

  }

  function loadDeliveryMethods() {
    let deliveryMethodsJson = $('#h-cart__totals--json i').text();
    if (deliveryMethodsJson) {
      $('#shipping_method_new').next('.error').remove();
      let deliveryMethods = JSON.parse(deliveryMethodsJson);
      $('#shipping_method_new li').addClass('hidden');
      $('#shipping_method_new label input').attr('checked', false);
      deliveryMethods.forEach(function (method) {
        $('#shipping_method_new .shipping_list_'+method.id).removeClass('hidden');
        $('#shipping_method_new .shipping_list_'+method.id+' label span b').text(method.price);
        if (parseInt(method.selected)) {
          $('#shipping_method_new .shipping_list_'+method.id+' label input').attr('checked', true);
        } else {
          $('#shipping_method_new .shipping_list_'+method.id+':not(.hidden):first').find('input').attr('checked', true);
        }
      });

      $('.ch-delivery-error').addClass('hidden').text('');

    } else {

      let deliveryMethodsError = $('#h-cart__totals--json').text();
      if ($.trim(deliveryMethodsError == 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.')) {
        deliveryMethodsError = 'There are no shipping options available. Please ensure that your address has been entered correctly and that <a href="/delivery-and-payment/">we ship to your country</a>.'
      }
      $('#shipping_method_new li').addClass('hidden');
      $('.ch-stage input[name="shipping_method[0]"]').prop('checked', false);
      $('.ch-delivery-error').removeClass('hidden').html(deliveryMethodsError);
    }
  }

  function deactivateDeliveryNotice() {
    jQuery(".h-cart__totals--delivery").addClass("hidden-i");
  }

  function updateDeliveryMethodDesc() {
    if (jQuery(".ch-stage input[name='shipping_method[0]']:checked").val()) {
      jQuery(".ch-stage__info--deliverydesc span").addClass('hidden');
      let split = jQuery(".ch-stage input[name='shipping_method[0]']:checked").val().split(":");
      jQuery(".ch-stage__info__"+split[0]).removeClass('hidden');
    }
  }

  // показать поле купона
  function showCouponField() {
    jQuery(function($){
      $( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
      $(".h-cart__checkout__error").addClass('hidden');
      $(".h-cart__checkout--couponinfo").addClass('hidden');
      $(".h-cart__checkout--couponadd").removeClass('hidden');
      $(".h-cart__checkout__coupontype").focus();
    });
  }

  // применить купон
  function submitCoupon(endpointString, nonce, mobile = false) {
    jQuery(function($){

      if (mobile) $('.h-mobcoupon__info').html('');

      var get_url = function( endpoint ) {
        var wc_ajax_url = endpointString;
        return wc_ajax_url.toString().replace(
          '%%endpoint%%',
          endpoint
        );
      };

      var text_field = $( '#coupon_code_new' );
      if (mobile) var text_field = $( '.h-mobcoupon__input' );
      var coupon_code = text_field.val();

      var data = {
        security: nonce,
        coupon_code: coupon_code
      };

      $( '.woocommerce-checkout-review-order-table' ).block({
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      });

      if (mobile) {
        $( '.h-mobcoupon' ).block({
          message: null,
          overlayCSS: {
            background: '#fff',
            opacity: 0.6
          }
        });
      }

      // добавляем куки
      let current_shipping = $(".ch-stage input[name='shipping_method[0]']:checked").val();
      Cookies.set( 'hrlsn_coupon_shipping', current_shipping, { path: '/', expires: 1 } );

      $.ajax( {
        type:     'POST',
        url:      get_url( 'apply_coupon' ),
        data:     data,
        dataType: 'html',
        success: function( response ) {
          //console.log(response);
          $('.h-cart__checkout--couponinfo').removeClass('hidden');
          $('.h-cart__checkout--couponinfo').prepend(response);
          if (mobile) $('.h-mobcoupon__info').prepend(response);
          $( document.body ).trigger( 'applied_coupon', [ coupon_code ] );
        },
        complete: function() {
          $('.h-cart__checkout--couponadd').addClass('hidden');
          $('.h-cart__checkout__coupontype').val('');
          $('body').addClass('coupon_process').trigger('update_checkout');
          $('.woocommerce-checkout-review-order-table').unblock();
          if (mobile) $('.h-mobcoupon').unblock();
          /*setTimeout(function() {
            $('body').addClass('coupon_process').trigger('update_checkout');
          }, 2000);*/
        }
      });
    });
  }

  // удалить купон
  function removeCoupon(nonce, mobile = false) {
    jQuery(function($){

      var link = $(".h-cart__checkout__coupon--detele").data('href');
      var coupon_code = $(".h-cart__checkout__coupon--detele").data('coupon');

      var data = {
        security: nonce,
        coupon_code: coupon_code
      };

      $( '.woocommerce-checkout-review-order-table' ).block({
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      });

      if (mobile) {
        $( '.woocommerce-checkout' ).block({
          message: null,
          overlayCSS: {
            background: '#fff',
            opacity: 0.6
          }
        });
      }

      $.ajax( {
        type:     'POST',
        url:      link,
        data:     data,
        dataType: 'html',
        success: function( response ) {
          //console.log(response);
        },
        complete: function() {
          $('body').trigger('update_checkout');
          $( '.woocommerce-checkout-review-order-table' ).unblock();
          if (mobile) $('.woocommerce-checkout').unblock();
        }
      });

    });
  }

  function updateStageHeight() {
    let subMinHeight = 450;
    let supMinHeight = 660;
    let supMinHeight2 = 554;
    let newHeight = $('.ch-stage--active').height();
    let diffHeight = 0;

    if (newHeight > subMinHeight) {
      diffHeight = newHeight - subMinHeight;
    }

    if (!isMobileView()) 
    {
      let newMinHeight = supMinHeight + diffHeight;
      let newMinHeight2 = supMinHeight2 + diffHeight;
      $('.ch-sequence').css('height', false).css('min-height', newMinHeight + 'px');
      $('.checkout-page__right__cart').css('min-height', newMinHeight2 + 'px');
    } 
    else 
    {
      let initialHeight = window.innerHeight - 96;
      let newMinHeight = newHeight + 106 + 96 + 10;
      if (diffHeight > 0) {
        $('.ch-sequence').css('min-height', false).css('height', newMinHeight + 'px');
      } else {
        $('.ch-sequence').css('min-height', false).css('height', initialHeight + 'px');
      }
      $('.checkout-page__right__cart').css('min-height', false);
    }
  }

  function isNewCheckout() {
    if ($('.woocommerce-checkout').hasClass('newcheckout')) return true;
    return false;
  }














  // set vars
  setProductPageVars();

  // on resize
  window.addEventListener('resize', function(event) {
    initSimilarSlider();
    setProductPageVars();
    fixedHeader();
    fixedProductDesc();
    updateStageHeight();
  }, true);

  // fixed desc on product page
  window.onscroll = function() {
    fixedHeader();
    fixedProductDesc();
  };

  function setProductPageVars() {
    window.add1 = 25;
    if (document.getElementsByClassName('text-page')[0]) window.add1 = 0;
    window.add2 = 58;
    window.tickerHeight = 29;

    window.headerBlock = document.getElementsByClassName('h-main')[0];
    // window.stickyTop = window.headerBlock.offsetTop + window.headerBlock.offsetHeight - window.add1;
    // window.tickerHeight = window.headerBlock.offsetTop;

    window.stickyTop = window.tickerHeight + window.headerBlock.offsetHeight - window.add1;
    window.productPage = document.getElementsByClassName('product-page')[0];
    window.productPageCenter = document.getElementsByClassName('product-page__left')[0];

    window.productPageCenterDesc = null;
    window.stickyBottom = null;

    if (window.productPage) {
      window.productPageCenterDesc = document.getElementsByClassName('prod-info')[0];
      window.stickyBottom = window.stickyTop + (window.productPageCenter.offsetHeight - (window.productPageCenterDesc.offsetHeight + window.add2));
    }
  }

  function fixedHeader() {
    if (window.scrollY > window.tickerHeight) 
    {
      window.document.body.classList.add('header-fixed');
    } 
    else 
    {
      window.document.body.classList.remove('header-fixed');
    }
  }

  function fixedProductDesc() {
    if (window.productPage) 
    {
      if (!isMobileView()) 
      {
        if (window.scrollY > window.stickyTop && window.scrollY <= window.stickyBottom) 
        {
          window.productPage.classList.add('fixed');
          window.productPage.classList.remove('bottom');
        } 
        else if (window.scrollY > window.stickyBottom) 
        {
          window.productPage.classList.remove('fixed');
          window.productPage.classList.add('bottom');
        } 
        else 
        {
          window.productPage.classList.remove('fixed');
          window.productPage.classList.remove('bottom');
        }
      } 
      else 
      {
        window.productPage.classList.remove('fixed');
        window.productPage.classList.remove('bottom');
      }
    }
  } 

  function isMobileView() {
    return window.innerWidth <= 767;
  }

  function initSimilarSlider() {
    if ($(".prod-list--similar").length) {
      $(".prod-list--similar").slick({
        responsive: [
          {
            breakpoint: 3000,
            settings: "unslick"
          },
          {
            breakpoint: 767,
            settings: {
              dots: false,
              infinite: false,
              slidesToShow: 2,
              variableWidth: true,
              nextArrow: '<button type="button" class="slick-next"></button>',
              prevArrow: '<button type="button" class="slick-prev"></button>',
            }
          }
        ]
      });
    }
  }

  function openFiltersPopup() {
    $('.h-filters__filters span').addClass('open');
    $('.h-filters__block').removeClass('hidden');
  }

  function closeFiltersPopup() {
    $('.h-filters__filters span').removeClass('open');
    $('.h-filters__block').addClass('hidden');
  }

  function openMobileMenu() {
    $('.h-mobmenu').addClass('active');
    $('body').addClass('fixed');
    $('.h-mobmenu__wrapper').slideDown();
  }

  function closeMobileMenu() {
    $('.h-mobmenu__wrapper').slideUp();
    setTimeout(() => {
      $('.h-mobmenu').removeClass('active');
      $('body').removeClass('fixed search-active');
    }, 300);
  }

  function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
      indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
  } 

  function updateCartDivQty(newQty = null) {
    let oldQty = parseInt($('.h-links__cart').find('i').text());
    if (!newQty) newQty = ++oldQty; 
    // update on page
    $('.h-links__cart i, .h-mobmenu__main__cart i').text(newQty);
  }

  function showAddedToCartPopup() {
    $('.added-to-cart-popup').removeClass('hidden');
    setTimeout(() => {
      $('.added-to-cart-popup').addClass('hidden');
    }, 3000);
  }

  function renameAddToCartBtn(addSpan = false) {
    let text = $('.prod-info__form__submit__added').html();
    $('.single_add_to_cart_button').html(text);

    // adding new variation-in-cart span if first add to cart
    if (addSpan) {
      let activeVariationId = $('[name="variation_id"]').val();
      if (activeVariationId && !$('.prod-info__form__submit__variation[data-id="'+activeVariationId+'"]').length) {
        let newSpan = '<span class="prod-info__form__submit__variation hidden" data-id="'+activeVariationId+'"></span>';
        $('.prod-info__form__submit__added').after(newSpan);
      }
    }
  }

  /**
   * Update Cart functions
   */

  function setPopupCloseCookie(type) {
    let days = 365;
    if (type == 'welcome') days = 10;
    Cookies.set( 'hrlsn_popup_'+ type, '1', { path: '/', expires: days } );
  }

  var get_url = function( endpoint ) {
		return wc_cart_params.wc_ajax_url.toString().replace(
			'%%endpoint%%',
			endpoint
		);
	};

  var get_url_checkout = function( endpoint ) {
    var wc_ajax_url = $('[name="coupon_endpoint"]').val();
    return wc_ajax_url.toString().replace(
      '%%endpoint%%',
      endpoint
    );
  };

  var block = function( $node ) {
    if ( ! is_blocked( $node ) ) {
      $node.addClass( 'processing' ).block( {
        message: null,
        overlayCSS: {
          background: '#fff',
          opacity: 0.6
        }
      } );
    }
  };

  var unblock = function( $node ) {
		$node.removeClass( 'processing' ).unblock();
	};

  var is_blocked = function( $node ) {
		return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
	};

  var update_wc_div = function( html_str, preserve_notices ) {
		var $html       = $.parseHTML( html_str );
		var $new_form   = $( '.woocommerce-cart-form', $html );
		var $new_totals = $( '.cart_totals', $html );

		if ( $( '.woocommerce-cart-form' ).length === 0 ) {
			window.location.reload();
			return;
		}

		if ( ! preserve_notices ) {
			$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
		}

		if ( $new_form.length === 0 ) {
			if ( $( '.woocommerce-checkout' ).length ) {
				window.location.reload();
				return;
			}
			var $cart_html = $( '.cart-empty', $html ).closest( '.woocommerce' );
			$( '.woocommerce-cart-form__contents' ).closest( '.woocommerce' ).replaceWith( $cart_html );
			$( document.body ).trigger( 'wc_cart_emptied' );
		} else {
			if ( $( '.woocommerce-checkout' ).length ) {
				$( document.body ).trigger( 'update_checkout' );
			}
			$( '.woocommerce-cart-form' ).replaceWith( $new_form );
			$( '.woocommerce-cart-form' ).find( ':input[name="update_cart"]' ).prop( 'disabled', true ).attr( 'aria-disabled', true );
			update_cart_totals_div( $new_totals );
		}

		$( document.body ).trigger( 'updated_wc_div' );
	};

  var update_cart_totals_div = function( html_str ) {
		$( '.cart_totals' ).replaceWith( html_str );
		$( document.body ).trigger( 'updated_cart_totals' );
	};

  function couponCheck(coupon, page = 'cart') {
    var $form = $( '.woocommerce-cart-form' );

    if (page == 'checkout') {
      var nonce = $('[name="coupon_nonce"]').val();
      var ajax_url = get_url_checkout( 'apply_coupon' );
    } else {
      var nonce = wc_cart_params.apply_coupon_nonce;
      var ajax_url = get_url( 'apply_coupon' );
    }

    block( $form );

    var data = {
      security: nonce,
      coupon_code: coupon
    };

    console.log(data);

    $.ajax( {
      type:     'POST',
      url:      ajax_url,
      data:     data,
      dataType: 'html',
      success: function( response ) {
        // console.log(response);
        if (response.toLowerCase().indexOf("woocommerce-error") >= 0)  
        {
          let responseText = $(response).text();
          $('.h-coupon__submit__error').text(responseText);
          unblock( $form );
        }
        else 
        {
          $( document.body ).trigger( 'applied_coupon', [ coupon ] );
          if (page == 'checkout') {
            $('body').addClass('coupon_process_new').trigger('update_checkout');
          } else {
            updateCart( false );
          }
        }
      }
    } );
  }

  function updateCart( preserve_notices ) {
    var $form = $( '.woocommerce-cart-form' );

    block( $form );
    block( $( 'div.cart_totals' ) );

    $.ajax( {
      type:     $form.attr( 'method' ),
      url:      $form.attr( 'action' ),
      data:     $form.serialize(),
      dataType: 'html',
      success:  function( response ) {
        update_wc_div( response, preserve_notices );
      },
      complete: function() {
        unblock( $form );
        unblock( $( 'div.cart_totals' ) );
      }
    } );
  }

  // preorder check
  function orderHasPreorderItems() {
    if ($('.h-cart__item__name__preorder').length) {
      return true;
    }

    return false;
  }

  function showPreorderPopup() {
    $('.backorder-notice-checkout').removeClass('hidden');
  }

});


/**
 * Functions in DOM
 */

// обновить статус для надписи по доставке
function activateDeliveryNotice() {
  let current_stage = jQuery(".ch-stage--active").data("stage");
  if (jQuery("#h-cart__totals--json i").length > 0 && current_stage == "city") {
    jQuery(".h-cart__totals--delivery").removeClass("hidden-i");
  }
}

// отобразить выбранный способ доставки
function showDeliveryMethodInOrderReview(id = false) {
  jQuery(function($){
    let deliveryMethodsJson = $('#h-cart__totals--json i').text();
    let IS_JSON = true;
    try {
      let json = $.parseJSON(deliveryMethodsJson);
    } catch (err) {
      IS_JSON = false;
    }

    if (IS_JSON) {

      let deliveryMethods = JSON.parse(deliveryMethodsJson);
      deliveryMethods.forEach(function (method, key) {
        //if (method.id == 'bxb31') method.selected = '1';
        if (method.id.indexOf('shipping_shiptimize') != -1) method.selected = '1';

        if (parseInt(method.selected)) {
          $('input[name="ch-delivery-label"]').val(method.name);
          $('input[name="ch-delivery-price"]').val(method.price);
          // обновить в списке
          let methodBlockId = 'shipping_method_'+key+'_'+method.id;
          let methodElem = document.getElementById(methodBlockId);
          if(typeof methodElem !== 'undefined' && methodElem !== null) {
            methodElem.checked = true;
            methodElem.dispatchEvent(new Event("change"));
          }
        }
      });

      var deliveryLabelRead = $('input[name="ch-delivery-label"]').val();
      var deliveryPriceRead = $('input[name="ch-delivery-price"]').val();
      $(".h-cart__totals--delivery").removeClass("hidden");
      $(".h-cart__totals--delivery .h-cart__totals__name span").text(
        deliveryLabelRead
      );
      $(".h-cart__totals--delivery .h-cart__totals__value").text(deliveryPriceRead);

      $('.ch-delivery-error').addClass('hidden').text('');

    } else {

      let deliveryMethodsError = $('#h-cart__totals--json').text();
      $('#shipping_method_new li').addClass('hidden');
      $('.ch-stage input[name="shipping_method[0]"]').prop('checked', false);
      $('.ch-delivery-error').removeClass('hidden').text(deliveryMethodsError);
    }
  });
}

// обновить totals на последнем шаге
function updateTotalsOnLastStep() {
  jQuery(function($){
    // кнопка
    let sum = $(".h-cart__checkout__sum .woocommerce-Price-amount bdi").html();
    $(".ch-sequence__action__btn i.pay b").html(sum);
    // общая сумма
    let order_cost = $(".h-cart__totals--subtotal span").html();
    $(".ch-review-order-cost").html(order_cost);
    // доставка
    let shipping_name = $(".h-cart__totals--delivery .h-cart__totals__name span").html();
    $(".ch-review-shipping-name").html(shipping_name);
    let shipping_cost = $(".h-cart__totals--delivery .h-cart__totals__value").html();
    $(".ch-review-shipping-cost").html(shipping_cost);
    // купон
    let coupon_applied = $(".h-cart__totals--coupon").html();
    if (coupon_applied) {
      $(".h-mobcoupon, .ch-coupon-block--apply").addClass('hidden');
      $("body").removeClass('edit-order-mobile');
      $(".ch-coupon-block--remove, .ch-review-coupon-name, .ch-review-coupon-cost").removeClass('hidden');
      let coupon_name = $(".h-cart__totals--coupon .h-cart__totals__name span").html();
      $(".ch-review-coupon-name").html(coupon_name);
      let coupon_cost = $(".h-cart__totals--coupon .h-cart__totals__value").html();
      $(".ch-review-coupon-cost").html(coupon_cost);
    } else {
      $(".ch-review-coupon-name, .ch-review-coupon-cost, .ch-coupon-block--remove").addClass('hidden');
      $(".ch-coupon-block--apply").removeClass('hidden');
    }
  });
}