var pc2015 = (function($) {
  'use strict';
  if (!$) return;
  var $win, $body;
  var isIE7Or8 = !('addEventListener' in window);
  var isIE7 = !('querySelector' in document);
  var isIE8 = isIE7Or8 && !isIE7;
  var headerFixed = false;
  var headerThreshold = 116;
  var header = null;

  function adjustHeader() {
    if (!header) {
      header = $('.pc2015-global-navigation');
    }
    if (header.length > 0) {
      var scrollTop = $win.scrollTop();
      if (scrollTop > headerThreshold) {
        if (!headerFixed) {
          headerFixed = true;
          header.css({
            height: 50
          });
          $body.addClass('pc2015-scrolled');
        }
      } else {
        if (headerFixed) {
          headerFixed = false;
          header.css({
            height: ''
          });
          $body.removeClass('pc2015-scrolled');
        }
      }
    }
  }
  var $overlay;

  function showOverlay(opacity, global) {
    $overlay.css({
      opacity: isFinite(opacity) ? opacity : 0.2
    }).toggleClass('pc2015-global-overlay', global).show();
  }

  function hideOverlay() {
    $overlay.hide();
  }
  var popups = {};

  function makePopup(name, selector, options) {
    var p = {
      name: name,
      popup: $(selector),
      overlay: 0.2,
      heightOffset: null,
      minHeight: null,
      autohide: !true,
      global: false,
      visible: false
    };
    $.extend(p, options);
    if (p.button) {
      p.button.bind('click', function() {
        showPopup(name);
        return false;
      });
    }
    if (p.autohide) {
      p.popup.bind('mouseleave', function() {
        hidePopup(name);
        hideOverlay();
      });
    }
    if (!$.isFunction(p.after)) {
      p.after = $.noop;
    }
    return (popups[name] = p);
  }

  function setPopupHeight(popup) {
   if(popup.popup.html() == null){
    if(popup.popup.html().match("è²·ã„ç‰©ã‹ã”ã«ã¯å•†å“ãŒå…¥ã£ã¦ãŠã‚Šã¾ã›ã‚“")){return false;}
   }
  
    if (popup.heightOffset !== null) {
      var h = $win.height() - popup.heightOffset;
      if (popup.minHeight !== null && h < popup.minHeight) {
        h = popup.minHeight;
      }
      popup.popup.height(h);
      if (popup.name === 'cart' || popup.name === 'delivery') {
        popup.popup.find('>div').height(h);
      }
    }
  }

  function showPopup(name) {
    var x, popup;
    for (x in popups) {
      if (x === name) {
        popup = popups[x];
      } else {
        hidePopup(x);
      }
    }
    hideMenu(1);
    if (!popup) return;
    if (popup.visible) {
      hideOverlay();
      if (popup.button) {
        popup.button.removeClass('pc2015-active');
      }
      popup.popup.stop(true, true).fadeOut('fast');
    } else {
      if(name != 'memo') {
        showOverlay(popup.overlay, popup.global);
      }
      if (popup.button) {
        popup.button.addClass('pc2015-active');
      }
      popup.popup.stop(true, true);
      setPopupHeight(popup);
      popup.popup.fadeIn('fast');
    }
    popup.visible = !popup.visible;
    popup.after(popup);
  }

  function hidePopup(name) {
    var popup = popups[name];
    if (popup) {
      popup.popup.stop(true, true).hide();
      popup.visible = false;
      if (popup.button) {
        popup.button.removeClass('pc2015-active');
      }
      popup.after(popup);
      return true;
    }
    return false;
  }

  function hideAllPopups() {
    var name;
    var result1 = hideMenu(1);
    var result2 = false;
    for (name in popups) {
      result2 = hidePopup(name) || result2;
    }
    hideOverlay();
    return result1 || result2;
  }

  function adjustPopupHeight() {
    var height = $win.height();
    var popup, name;
    for (name in popups) {
      popup = popups[name];
      if (popup.visible) {
        setPopupHeight(popup);
      }
    }
  }
  var currentMenu = {};
  var fromSide = false;
  var fixedMenuOffset = 0;

  function makeMenu(menuRoot, menu, li, sideOffset) {
    var m = {
      root: menuRoot,
      menu: menu,
      li: li,
      link: li.find('>a.pc2015-menu-link'),
      anchor: li.find('>a.pc2015-menu-anchor'),
      outer: menu.find('>div.pc2015-menu-content'),
      inner: menu.find('>div.pc2015-menu-content>ul'),
      arrow: menu.find('>div.pc2015-arrow-1'),
      up: menu.find('>div.pc2015-up'),
      down: menu.find('>div.pc2015-down'),
      top: null,
      parent: null,
      minOffset: null,
      offset: 0,
      sideOffset: sideOffset || 0
    };
    m.inner.find('>li').each(function() {
      var child = makeChildMenu(menuRoot, m, $(this), 2, sideOffset);
      if (child.menu.length <= 0) {
        $(this).addClass('pc2015-menu-no-children').
        find('>a.pc2015-menu-anchor').addClass('pc2015-disabled');
      }
    });
    m.arrow.bind('click', function() {
      return false;
    });

    m.menu.mouseout(function() {
        var flag = false; //åˆ¤å®šç”¨ãƒ•ãƒ©ã‚°æº–å‚™
        jQuery(":hover").each(function () { //ã‚«ãƒ¼ã‚½ãƒ«ä½ç½®ã®å…¨è¦ç´ ã‚’èµ°æŸ»
            if ($(this).attr("class").indexOf("pc2015-menu") >= 0) {
                flag = true; // èµ°æŸ»ä¸­è¦ç´ ã®ã‚¯ãƒ©ã‚¹åã«ã€Œpc2015-menuã€ãŒã‚ã‚‹ã‹

            }
        });
        if (!flag) {
            //å¤–ã‚ŒãŸæ™‚ã®å‡¦ç†

        	hideMenu(1);
        };
    });

    setupScroll(m);
    return m;
  }

  function makeChildMenu(menuRoot, parent, li, depth, sideOffset) {
    var menu = li.find('>.pc2015-menu-' + depth);
    var m = {
      root: menuRoot,
      menu: menu,
      li: li,
      link: li.find('>a.pc2015-menu-link'),
      anchor: li.find('>a.pc2015-menu-anchor'),
      outer: menu.find('>div.pc2015-menu-content'),
      inner: menu.find('>div.pc2015-menu-content>ul'),
      arrow: menu.find('>div.pc2015-arrow-2'),
      up: menu.find('>div.pc2015-up'),
      down: menu.find('>div.pc2015-down'),
      top: null,
      parent: parent,
      minOffset: null,
      offset: 0,
      sideOffset: sideOffset || 0
    };
    m.menu.appendTo(m.root);
    m.anchor.hover(function() {
      showMenu(m, depth, li, fromSide);
    }).bind('click', function(ev) {
      showMenu(m, depth, li, fromSide);
      ev.stopPropagation();
    });
    m.inner.find('>li').each(function() {
      var child = makeChildMenu(menuRoot, m, $(this), depth + 1, sideOffset);
      if (child.menu.length <= 0) {
        $(this).addClass('pc2015-menu-no-children').
        find('>a.pc2015-menu-anchor').addClass('pc2015-disabled');
      }
    });
    m.arrow.bind('click', function() {
      return false;
    });
    setupScroll(m);

    m.menu.mouseout(function() {
        var flag = false; //åˆ¤å®šç”¨ãƒ•ãƒ©ã‚°æº–å‚™
        jQuery(":hover").each(function () { //ã‚«ãƒ¼ã‚½ãƒ«ä½ç½®ã®å…¨è¦ç´ ã‚’èµ°æŸ»
            if ($(this).attr("class").indexOf("pc2015-menu") >= 0) {
                flag = true; // èµ°æŸ»ä¸­è¦ç´ ã®ã‚¯ãƒ©ã‚¹åã«ã€Œpc2015-menuã€ãŒã‚ã‚‹ã‹

            }
        });
        if (!flag) {
            //å¤–ã‚ŒãŸæ™‚ã®å‡¦ç†

        	hideMenu(1);
        };
    });
    return m;
  }

  function setupMegaMenu(root, sideOffset, nav, group) {
    var li = nav.find('.pc2015-nav-root-' + root);
    if (li.length <= 0) {
      return false;
    }
    var anchor = li.find('>.pc2015-nav-anchor');
    var offset = 0;
    var menuRoot = group.find('.pc2015-menu-root-' + root);
    var menu = makeMenu(menuRoot, menuRoot.find('.pc2015-menu-1'), li, sideOffset);
    anchor.bind('mouseover', function() {
      var side = false;
      if ($(this).parents('.pc2015-side').length > 0) {
        menuRoot.removeClass('pc2015-menu-fixed');
        side = true;
      } else {
        menuRoot.addClass('pc2015-menu-fixed');
      }
      clearScrollTarget();
      showMenu(menu, 1, $(this), side);
      return false;
    });
    return true;
  }

  function showMenu(menu, depth, anchor, side) {
    hideMenu(depth);
    if (menu.menu.length <= 0) return;
    setMenuHeight(menu);
    if (depth !== 1) {
      menu.menu.css({
        top: menu.parent.menu.css('top')
      });
    } else {
      if (side) {
        menu.menu.css({
          top: menu.sideOffset
        });
      } else {
        menu.menu.css({
          top: fixedMenuOffset - 191
        });
      }
    }
    menu.menu.show();
    menu.minOffset = (menu.outer.height() - menu.inner.height());
    menu.up.toggleClass('pc2015-active', menu.offset < 0);
    menu.down.toggleClass('pc2015-active', menu.offset > menu.minOffset);
    adjustMenuArrow(menu, depth, anchor, side, false);
    menu.li.addClass('pc2015-active');
    currentMenu[depth] = [menu, anchor];
    fromSide = side;
  }

  function hideMenu(depth) {
    if (currentMenu[depth]) {
      hideMenu(depth + 1);
      currentMenu[depth][0].menu.hide();
      currentMenu[depth][0].li.removeClass('pc2015-active');
      currentMenu[depth] = null;
      return true;
    }
    return false;
  }

  function setMenuHeight(menu) {
    var winHeight = $win.height();
    var height = 502;
    if (headerFixed) {
      height = winHeight - 95;
    } else {
      height = (winHeight - 120 + $win.scrollTop() - headerThreshold);
    }
    if (height < 142) {
      height = 142;
    } else if (height > 502) {
      height = 502;
    }
    menu.menu.height(height);
    return height;
  }

  function adjustMenuArrow(menu, depth, anchor, side, resize) {
    var arrowTop = 0;
    var arrowOffset = 72;
    var top = 0;
    if (depth !== 1) {
      arrowTop = menu.li.position().top + 43;
    } else {
      if (side) {
        arrowTop = anchor.parent().position().top - 16 - menu.sideOffset;
      } else {
        if (headerFixed) {
          arrowTop = menu.li.position().top + 4;
        } else {
          arrowTop = menu.li.position().top - 26;
        }
      }
    }

    if (arrowTop + arrowOffset > menu.menu.height()) {
      top = (side ? menu.sideOffset : 0) + (arrowTop + arrowOffset - menu.menu.height());
      if (!side && headerFixed) {
        top += fixedMenuOffset - 191;
      }
      arrowTop = menu.menu.height() - arrowOffset;
      menu.menu.css({
        top: top
      });
    }
    menu.arrow.css({
      top: arrowTop
    });
  }

  function adjustMenuHeight() {
    for (var depth in currentMenu) {
      if (currentMenu[depth]) {
        setMenuHeight(currentMenu[depth][0]);
        adjustMenuArrow(currentMenu[depth][0], +depth, currentMenu[depth][1], fromSide, true);
      }
    }
  }

  function adjustNav(nav) {
    nav.find('a.pc2015-nav-link').each(function() {
      $(this).attr({
        style: 'layout-grid-line:' + (a.parent().hasClass('pc2015-nav-osusume') ? 54 : 43) + 'px'
      });
    });
  }
  var scrollWait = 700;
  var scrollTarget = {
    menu: null,
    min: 0,
    start: false,
    delta: 0,
    serial: -1,
    limit: null,
    timer: null
  };

  function setupScroll(menu) {
    function getMin() {
      return menu.outer.height() - menu.inner.height();
    }

    function canScroll(min, delta) {
      return !(min > 0 || (delta > 0 && menu.offset === 0) || (delta < 0 && menu.offset === min));
    }
    menu.up.bind('click', function() {
      var min = getMin();
      var delta = Math.ceil((menu.outer.height() - 30) / 10);
      if (canScroll(min, delta)) {
        setScrollTarget(menu, delta, min, 10, 0);
      }
      return false;
    });
    menu.down.bind('click', function() {
      var min = getMin();
      var delta = -Math.ceil((menu.outer.height() - 30) / 10);
      if (canScroll(min, delta)) {
        setScrollTarget(menu, delta, min, 10, 0);
      }
      return false;
    });
    menu.menu.bind('mouseleave', function() {
      clearScrollTarget();
    });
    menu.menu.bind('mousewheel', function(ev) {
      var min = getMin();
      var delta = ev.deltaY;
      if (canScroll(min, delta)) {
        clearScrollTarget();
        doScroll(menu, delta, min);
      }
      return false;
    });
    menu.outer.bind('mouseover', function(ev) {
      var y = ev.pageY - menu.menu.offset().top;
      var h = menu.menu.height();
      var pos = y / h;
      var delta = 0;
      if (pos < 0) {
        delta = 0;
      } else if (pos < 0.05) {
        delta = 15;
      } else if (pos < 0.2) {
        delta = 7;
      } else if (pos < 0.4) {
        delta = 2;
      } else if (pos > 1) {
        delta = 0;
      } else if (pos > (1 - 0.05)) {
        delta = -15;
      } else if (pos > (1 - 0.2)) {
        delta = -7;
      } else if (pos > (1 - 0.4)) {
        delta = -2;
      }
      if (scrollTarget.menu === menu && scrollTarget.start) {
        if (delta === 0) {
          clearScrollTarget();
        } else {
          scrollTarget.delta = delta;
        }
        return;
      }
      clearScrollTarget();
      if (delta === 0) return;
      var min = getMin();
      if (!canScroll(min)) {
        return;
      }
      setScrollTarget(menu, delta, min, null, scrollWait);
    });
  }

  function setScrollTarget(menu, delta, min, limit, wait) {
    var serial = scrollTarget.serial = new Date().valueOf();
    scrollTarget.menu = menu;
    scrollTarget.min = min;
    scrollTarget.start = false;
    scrollTarget.delta = delta;
    scrollTarget.limit = limit;
    scrollTarget.timer = setTimeout(function() {
      if (scrollTarget.serial === serial) {
        scrollTarget.timer = null;
        scrollTarget.start = true;
        autoScroll();
      }
    }, wait);
  }

  function clearScrollTarget() {
    if (scrollTarget.timer !== null) {
      clearTimeout(scrollTarget.timer);
    }
    scrollTarget.menu = scrollTarget.timer = null;
  }

  function doScroll(menu, delta, min) {
    var offset = menu.offset;
    offset += delta;
    if (offset >= 0) {
      menu.up.removeClass('pc2015-active');
      offset = 0;
    } else {
      menu.up.addClass('pc2015-active');
    }
    if (offset <= min) {
      menu.down.removeClass('pc2015-active');
      offset = min;
    } else {
      menu.down.addClass('pc2015-active');
    }
    menu.up.toggleClass('pc2015-active', offset < 0);
    menu.offset = offset;
    menu.inner.css({
      marginTop: offset
    });
  }

  function autoScroll() {
    if (scrollTarget.menu !== null && scrollTarget.start) {
      var menu = scrollTarget.menu;
      doScroll(menu, scrollTarget.delta, scrollTarget.min);
      if (scrollTarget.limit === null || --scrollTarget.limit >= 0) {
        setTimeout(autoScroll, 20);
      } else {
        clearScrollTarget();
      }
    }
  }

  function setupDeliveryTable() {
    $('.pc2015-timetable-row-1').each(function() {
      var row1 = $(this);
      var row2 = row1.next('.pc2015-timetable-row-2');
      var cell1 = row1.find('.pc2015-timetable-1');
      var cell2 = row1.find('.pc2015-timetable-2');
      var count = row1.find('td').length;
      if (row2.hasClass('pc2015-empty')) {
        return;
      }
      row2.addClass('pc2015-timetable-on-' + count);
      cell1.hover(function() {
        row1.addClass('pc2015-active');
        row2.show();
        row2.addClass('pc2015-time-for-1');
      }, function() {
        row1.removeClass('pc2015-active');
        row2.hide();
        row2.removeClass('pc2015-time-for-1');
      });
      cell2.hover(function() {
        row1.addClass('pc2015-active');
        row2.show();
        row2.addClass('pc2015-time-for-2');
      }, function() {
        row1.removeClass('pc2015-active');
        row2.hide();
        row2.removeClass('pc2015-time-for-2');
      });
    });
  }

  function setupCartItem(jq, noMember) {
    var quantityJq = jq.find('.pc2015-cart-quantity');
    jq.find('.pc2015-cart-inc').bind('click', function() {
      if (!noMember && !$(this).hasClass('pc2015-disabled')) {
        updateCartItem(quantityJq, (quantityJq.text() | 0) + 1);
      }
      return false;
    });
    jq.find('.pc2015-cart-dec').bind('click', function() {
      if (!noMember && !$(this).hasClass('pc2015-disabled')) {
        updateCartItem(quantityJq, (quantityJq.text() | 0) - 1);
      }
      return false;
    });
    jq.find('.pc2015-cart-memo').bind('click', function() {
      return false;
    });
    jq.find('.pc2015-cart-delete').bind('click', function() {
      return false;
    });
  }

  function updateCartItem(jq, quantity) {
    quantity = quantity | 0;
    if (quantity < 1) {
      quantity = 1;
    } else if (quantity > 99) {
      quantity = 99;
    }
    jq.text(quantity);
    return quantity;
  }
  $(function() {
    pc2015.$win = $win = $(window);
    pc2015.$body = $body = $('body');
    var noMember = $body.hasClass('pc2015-no-member');
    $win.bind('scroll', adjustHeader);
    adjustHeader();
    $win.bind('resize', adjustPopupHeight);
    $win.bind('resize', $.debounce(500, adjustMenuHeight));
    $overlay = $('.pc2015-overlay').bind('click', function() {
      hideAllPopups();
      return false;
    });
    if ($('.pc2015-button-category2').length != 0 ) {
        makePopup('category', '.pc2015-category-menu', {
          overlay: 0.8,
          button: $('.pc2015-button-category2'),
          autohide: false,
          after: function(popup) {
            if (popup.visible) {
              fixedMenuOffset = (headerFixed ? $win.scrollTop() + 72 : 191);
              popup.popup.css({
                top: fixedMenuOffset
              });
            }
          }
        });
    }

    makePopup('service', '.pc2015-service-menu', {
      button: $('.pc2015-service-menu-button'),
      after: function(popup) {
        popup.button.parent().toggleClass('pc2015-active', popup.visible);
      }
    });
    makePopup('delivery', '.pc2015-delivery-menu', {
      heightOffset: 240,
      minHeight: 160
    });
    makePopup('spot', '.pc5-spot-menu', {
     heightOffset: 240,
      minHeight: 160
      
    });
    makePopup('prem', '.pc5-spot-prem', {
	 heightOffset: 240,
	  minHeight: 160
	});
    makePopup('cart', '.pc2015-cart-menu', {
      heightOffset: 240,
      minHeight: 160,
      after: function(popup) {
        if (popup.visible) {
          var inner = popup.popup.children();
          var h = inner.height();
          inner.css({
            height: ''
          });
          if (h < inner.height()) {
            inner.css({
              height: h
            });
          }
        }
      }
    });
    makePopup('select', '.pc2015-select-menu-popup', {
      global: true,
      autohide: false,
      after: function(popup) {
        if (popup.visible) {
          setTimeout(function() {
            popup.popup.find('.pc2015-zip-1').focus();
          }, 200);
        }
      }
    });
    $('.pc2015-button-delivery').bind('click', function() {
      showPopup('delivery');
      return false;
    });

    $('.pc2015-button-bookmark').bind('click', function() {
      if ($(this).hasClass('pc2015-disabled')) {
        return false;
      }
    });

    $('.pc2015-button-cart').bind('click', function() {
      showPopup('cart');
      return false;
    });

	function homeorspotFormSubmit(home_or_spot) {
		var param = {
			'home_or_spot' : home_or_spot ,
			'selectedspot' : jQuery('input[name=selectedspot]:checked').val()
		};
		var actionUrl = jQuery('#homeorspotForm').attr('action');
		jQuery.xpost(
			{
				url: actionUrl,
				data: param,
				callback: function() {
					hidePopup('spot');
					hideOverlay();
					jQuery('.tmp_spot_ovl').remove();
					location.href = EC_WWW_ROOT + "/shop/netsuper/returntop.aspx";
				}
			}
		);
	}

	$('.pc5-spot-button-close-img').bind('click', function() {
		jConfirm('ãŠå±Šã‘å…ˆä½æ‰€ã§ã®å—å–ã§ã‚ˆã‚ã—ã„ã§ã—ã‚‡ã†ã‹ï¼Ÿ <br/><br/>', 'ãŠè²·ã„ä¸Šã’å•†å“ã®å—å–å ´æ‰€', 
			function(r) {
				if(r){
					homeorspotFormSubmit('HOME');
				}else{
				  return false;
				}
			});
		return false;
	});

	$('#btn_home').bind('click', function() {

		jConfirm('ãŠå±Šã‘å…ˆä½æ‰€ã§ã®å—å–ã‚’é¸æŠžã•ã‚Œã¾ã—ãŸã€‚<br/>ãŠé–“é•ã„ãªã„ã§ã—ã‚‡ã†ã‹ï¼Ÿ<br/><br/>', 'ãŠè²·ã„ä¸Šã’å•†å“ã®å—å–å ´æ‰€', 
			function(r) {
				if(r){
					homeorspotFormSubmit('HOME');
				 }else{
					return false;
				 }
			});
		return false;   //ã“ã‚ŒãŒãªã„ã¨jConfirmè¡¨ç¤ºã¨åŒæ™‚ã«submitâ†’DBæ›´æ–°ã•ã‚Œã‚‹

	 });

	$('#btn_spot').bind('click', function() {
		var selectedRdo = jQuery('input[name=selectedspot]:checked');
		var selectedVal = selectedRdo.val();
		var selectedSpotname = selectedRdo.parents('tr').children('th.infobox').children('span.spotname').text();
		if (selectedVal == undefined) {
			jAlert('å—å–åº—èˆ—ãŒé¸æŠžã•ã‚Œã¦ãŠã‚Šã¾ã›ã‚“ã®ã§ã€<br/>å—å–åº—èˆ—ã‚’é¸æŠžã—ã¦ãã ã•ã„ã€‚<br/><br/>', 'ãŠè²·ã„ä¸Šã’å•†å“ã®å—å–å ´æ‰€');
			return false;
		} else {
			jConfirm(selectedSpotname + 'ã‚’é¸æŠžã•ã‚Œã¦ãŠã‚Šã¾ã™ã€‚<br/>ãŠé–“é•ã„ãªã„ã§ã—ã‚‡ã†ã‹ï¼Ÿ<br/><br/>', 'ãŠè²·ã„ä¸Šã’å•†å“ã®å—å–å ´æ‰€', 
				function(r) {
					if(r){
						//var reload = (nologinFlg == 0 ? true : false);	//nologinFlgã¯CommonHeaderã‹ã‚‰
						homeorspotFormSubmit('SPOT');
					 }else{
						return false;
					 }
				});
			return false;
		}
		return false;
	});

    $('.pc2015-select-menu .pc2015-close').bind('click', function() {
      hideAllPopups();
      return false;
    });

    var bannerTop = $('.pc2015-side-banner-top');
    var offset = (bannerTop.length > 0 ? bannerTop.height() + 24 : 0) + 10;
    var root = 1;
    var nav = $('.pc2015-category-menu > .pc2015-nav');
    var group = $('.pc2015-menu-for-global');
    for (;;) {
      if (!setupMegaMenu(root++, offset, nav, group)) {
        break;
      }
    }
    if (isIE7) {adjustNav(nav);
    }
    root = 1;
    nav = $('.pc2015-side > .pc2015-nav');
    group = $('.pc2015-menu-for-side');
    for (;;) {
      if (!setupMegaMenu(root++, offset, nav, group)) {
        break;
      }
    }
    if (isIE7) {
      adjustNav(nav);
    }
    $body.bind('click', function() {
        if (currentMenu[1]) {
        hideMenu(1);
        return true;
      }
      
    });
	
	
	
    $(".pc2015-header-title.clearfix , .pc2015-left ,.pc2015-center,.pc2015-right.clearfix , .pc2015-header").bind('click', function(e) {
      for (var name in popups) {
        if (popups[name].visible) {
          hidePopup(name);
          hideOverlay();
          return true;
        }
      }
    });
    $('input[placeholder]').ahPlaceholder({
      placeholderAttr: 'placeholder'
    });
    if (isIE7Or8) {
      $('select.pc2015-select-category').customSelect({
        customClass: 'pc2015-select-category-skin'
      }).css({
        height: 'auto',
        marginTop: 6
      });
    }
    $('.pc2015-item,.pc2015-cart-item').each(function() {
      setupCartItem($(this), noMember);
    });
    setupDeliveryTable();
    $('.pc2015-anchor-link').each(function() {
      var a = $(this);
      var href = a.attr('href');
      var target;
      if (!/^#/.test(href)) {
        return;
      }
      target = $(document.getElementById(href.replace(/^#+/g, '')));
      if (target.length === 0) {
        return;
      }
      a.bind('click', function() {
        setTimeout(function() {
          window.scrollTo(0, target.position().top - 80);
        }, 100);
      });
    });
    if (noMember) {
      $('.pc2015-for-member').not('select').unbind('click').bind('click', function() {
        showPopup('select');
        return false;
      });
      $('select.pc2015-for-member').
      unbind('change').
      unbind('click').
      unbind('mousedown').bind('mousedown keydown', function() {
        showPopup('select');
        return false;
      });
      $('.pc5-for-member').not('select').unbind('click').bind('click', function() {
        showPopup('select');
        return false;
      });
      $('select.pc5-for-member').
      unbind('change').
      unbind('click').
      unbind('mousedown').bind('mousedown keydown', function() {
        showPopup('select');
        return false;
      });
      $('form[name=frmSearch]').unbind('submit').bind('submit', function() {
        showPopup('select');
        return false;
      });
      $('.pc2015-button-cart > span').remove();
    }
    $('.pc2015-select-menu').each(function() {
      var menu = $(this);
      var result = menu.find('.pc2015-select-menu-result');
      menu.find('.pc2015-search').bind('click', function() {
      var id = $(this).attr("id");
      if (id == "shop_search_1") {
          var zip_code = jQuery("#zip1").val() + jQuery("#zip2").val();
      } else if (id == "shop_search_2") {
          var zip_code = jQuery("#zip3").val() + jQuery("#zip4").val();
      } else {
          var zip_code = ""
      }
      var is_zip_match = true;
      var root = EC_WWW_ROOT;
      var url = "/shop/searchshopdelivery.aspx";
      if(zip_code.match(/[^1234567890]/)){
    	is_zip_match = false;
      }
      if (!zip_code.match(/^\w{7}$/)) {
    	is_zip_match = false;
      }
      if(!is_zip_match){
     	return false;
      }        
        result.show();
        return false;
      });
    });
  });
  $( function() {
	    // å¹ãå‡ºã—

	    $('.pc5-nav-sm-3').hover(function(e) {
          if(!$(this).hasClass('pc5-nav-sm3-selected') && $(this).children('.pc5-nav-sm3-anchor').length){
            // é·ç§»æ™‚ã«è¡¨ç¤ºã—ãŸã‚‚ã®ã‚’éžè¡¨ç¤º
            $('.pc5-nav-sm3-selected').children('.pc5-nav-sm3-anchor').stop(true, false).removeClass('pc5-submenu-balloon-active');
            $('.pc5-nav-sm3-selected').children('.sm_bln').stop(true, false).removeAttr('style');

            $(this).children('.pc5-nav-sm3-anchor').stop(true, false).addClass('pc5-submenu-balloon-active');
            $(this).children('.sm_bln').stop(true, false).animate({
              width: 'toggle'
            }, 100);
          }
        }, function (e) {

          if(!$(this).hasClass('pc5-nav-sm3-selected') && $(this).children('.pc5-nav-sm3-anchor').length){
            // è¡¨ç¤ºã—ãŸå¹ãå‡ºã—ã‚’é–‰ã˜ã‚‹

            $('.pc5-nav-sm3-anchor').stop(true, false).removeClass('pc5-submenu-balloon-active');
            $('.sm_bln').stop(true, false).removeAttr('style');

            // é·ç§»æ™‚ã«è¡¨ç¤ºã—ãŸã‚‚ã®ã‚’å†è¡¨ç¤º
            $('.pc5-nav-sm3-selected').children('.pc5-nav-sm3-anchor').stop(true, false).addClass('pc5-submenu-balloon-active');
            $('.pc5-nav-sm3-selected').children('.sm_bln').stop(true, false).css('display', 'block');
          }
	    });

	    // ç¬¬ï¼’éšŽå±¤ãƒ¡ãƒ‹ãƒ¥ãƒ¼å‡¦ç†

	    $('.pc5-nav-sm2-anchor').click(function(e) {

	      // ãƒ¡ãƒ‹ãƒ¥ãƒ¼è¡¨ç¤º/éžè¡¨ç¤º
	      if($(this).parent('.pc5-nav-sm-2').parent('li').children('ul').css('display') == 'none'){
	    	  $(this).parent('.pc5-nav-sm-2').parent('li').addClass('pc5-tgl-active');
	      }else{
	    	  $(this).parent('.pc5-nav-sm-2').parent('li').removeClass('pc5-tgl-active');
	      }
	      $(this).parent('.pc5-nav-sm-2').parent('li').children('ul').slideToggle(400);
	      e.stopPropagation();
	    });

	    // ç¬¬ï¼‘éšŽå±¤ãƒ¡ãƒ‹ãƒ¥ãƒ¼å‡¦ç†

	    $('.pc5-nav-tgl').children('li').children('div').click(function(e) {

	      // ãƒ¡ãƒ‹ãƒ¥ãƒ¼è¡¨ç¤º/éžè¡¨ç¤º
	      if($(this).parent('li').children('ul').css('display') == 'none'){
	    	  $(this).parent('li').children('ul').addClass('pc5-tgl-active');
	      }else{
	    	  $(this).parent('li').children('ul').removeClass('pc5-tgl-active');
	      }
	      $(this).parent('li').children('ul').slideToggle(400);
	      e.stopPropagation();

	    });

  });

  return {
    $win: $win,
    $body: $body,
    isIE7Or8: isIE7Or8,
    isIE7: isIE7,
    isIE8: isIE8,
    makePopup: makePopup,
    showPopup: showPopup,
    hidePopup: hidePopup,
    hideAllPopups: hideAllPopups
    ,setupDeliveryTable: setupDeliveryTable
  };
})(window.jQuery);