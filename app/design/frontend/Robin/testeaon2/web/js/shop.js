(function($, pc2015) {
  'use strict';
  if (!$ || !pc2015) return;
  var sliderButton = '<a href="#" class="pc2015-designed"></a>';

  function setupSlider(jq) {
    var slider = {
      base: jq,
      headers: jq.find('.pc2015-main-slider-header > li'),
      items: jq.find('.pc2015-main-slider-body > ul > li'),
      slider: jq.find('.pc2015-main-slider-body')
    };
    slider.slider.jcarousel({
      scroll: 1,
      auto: 10,
      wrap: 'circular',
      buttonPrevHTML: sliderButton,
      buttonNextHTML: sliderButton,
      setupCallback: function() {
        slider.slider.find('.jcarousel-prev,.jcarousel-next').bind('click', function() {
          return false;
        });
        updateSliderHeader(slider, 0);
      },
      itemFirstInCallback: {
        onBeforeAnimation: function(jc, li) {
          if (pc2015.isIE7) {
            li = $(li);
            var a = $(li).find('a');
            if (a.length === 0) {
              a = slider.items.eq((jc.first - 1) % slider.headers.length).find('a').clone(false);
              li.append(a);
            }
          }
        },
        onAfterAnimation: function(jc, li) {
          updateSliderHeader(slider, jc.first - 1);
        }
      }
    });
    slider.headers.each(function(i) {
      $('a', this).bind('click', function() {
        slider.slider.data('jcarousel').scroll(i + 1);
        return false;
      });
    });
  }

  function updateSliderHeader(slider, i) {
    var headers = slider.headers;
    headers.removeClass('pc2015-active').eq(i % headers.length).addClass('pc2015-active');
  }
  var targetItems = [];
  var items = [];
  var selectableItems = [];
  var selectAllCheckbox = null;

  function setupItem(jq, noMember) {
    var item = {
      item: jq,
      count: 0,
      bookmarked: false,
      selected: false,
      selectable: jq.hasClass('pc2015-item-selectable'),
      unselectable: jq.hasClass('pc2015-item-unselectable'),
      soldout: jq.find('.pc2015-item-soldout').length > 0,
      name: jq.find('.pc2015-item-name').text(),
      counter: jq.find(),
      quantity: jq.find('.pc2015-cart-quantity'),
      buttons: {
        cart: jq.find('.pc2015-item-cart'),
        yoyaku: jq.find('.pc2015-item-yoyaku'),
        ordermade: jq.find('.pc2015-item-ordermade'),
        search: jq.find('.pc2015-item-search'),
        memo: jq.find('.pc2015-item-memo'),
        select: jq.find('.pc2015-item-select'),
        unselect: jq.find('.pc2015-item-unselect')
      },
      checkbox: jq.find('.pc2015-item-checkbox'),
      cartNotify: jq.find('.pc2015-item-cart-notify')
    };
    items.push(item);
    if (item.selectable) {
      selectableItems.push(item);
    }
    jq.find('a.pc2015-disabled').bind('click', function() {
      return false;
    });
    if (!noMember) {
      item.buttons.cart.bind('click', function() {
        if (item.item.hasClass('pc2015-item-alcohol')) {
          targetItems = [item];
          pc2015.showPopup('alcohol');
        } else {
          addItemToCart(item);
        }
        return false;
      });
      item.buttons.yoyaku.bind('click', function() {
        return false;
      });
      item.buttons.ordermade.bind('click', function() {
        return false;
      });
      item.buttons.search.bind('click', function() {
       if (item.item.hasClass('pc2015-item-search')) {
          targetItems = [item];
          pc2015.showPopup('search');
        } else {
          addItemToCart(item);
        }
        return false;
      });
      item.buttons.memo.bind('click', function() {
        if (!item.memo.hasClass('pc2015-disabled')) {
          addItemToMemo(item);
        }
        return false;
      });
      if (item.buttons.select.length > 0) {
        item.buttons.select.bind('click', function() {
          selectItem(item);
          return false;
        });
        item.buttons.unselect.bind('click', function() {
          unselectItem(item);
          return false;
        });
      }
    }
  }

  function adjustCenterImageIE7(centerImage) {
    centerImage.find('img').each(function() {
      $(this).css({
        left: '50%',
        right: 'auto',
        top: '50%',
        bottom: 'auto',
        marginRight: 0,
        marginBottom: 0,
        marginLeft: Math.round(this.width / -2),
        marginTop: Math.round(this.height / -2)
      });
    });
  }

  function addItemToCart(item) {
    updateItem(item, item.quantity.text() | 0);
    item.quantity.text(1);
    if (!item.cartBusy) {
      item.cartBusy = true;
      item.cartNotify.stop(true, true).fadeIn(200).delay(1000).fadeOut(200, function() {
        item.cartBusy = false;
      });
    }
  }

  function addItemToMemo(item) {
    if (!item.bookmarked) {
      targetItems = [item];
      pc2015.showPopup('memo');
    }
  }

  function updateItem(item, delta) {
    item.counter.text(item.count += delta);
    if (item.count === delta && delta > 0) {
      item.counter.stop(true, true).fadeIn();
    } else if (item.count < 0) {
      item.counter.stop(true, true).fadeOut();
    }
  }

  function selectItem(item) {
    if (item.selectable && !item.unselectable && !item.selected && !item.soldout) {
      item.selected = true;
      if (item.checkbox) item.checkbox.attr("checked", true);
      item.item.addClass('pc2015-item-selected');
      updateSelectAllCheckbox();
    }
  }

  function unselectItem(item) {
    if (item.selectable && !item.unselectable && !item.unselected && !item.soldout) {
      item.selected = false;
      if (item.checkbox) item.checkbox.attr("checked", false);
      item.item.toggleClass('pc2015-item-selected');
      updateSelectAllCheckbox();
    }
  }

  function selectAllItems() {
    for (var l = selectableItems.length, i = 0; i < l; ++i) {
      if (!selectableItems[i].unselectable) {
        selectItem(selectableItems[i]);
      }
    }
  }

  function unselectAllItems() {
    for (var l = selectableItems.length, i = 0; i < l; ++i) {
      if (!selectableItems[i].unselectable) {
        unselectItem(selectableItems[i]);
      }
    }
  }

  function setupSelectAllItems(jq) {
    selectAllCheckbox = jq;
    selectAllCheckbox.bind('click', function() {
      if (this.checked) {
        selectAllItems();
        setSelectAllCheckboxStatus(true);
      } else {
        unselectAllItems();
        setSelectAllCheckboxStatus(false);
      }
    });
    if (getSelectAllCheckboxStatus()) {
      selectAllItems();
    }
  }

  function updateSelectAllCheckbox() {
    if (selectAllCheckbox) {
      for (var l = selectableItems.length, i = 0; i < l; ++i) {
        if (selectableItems[i].unselectable) {
          continue;
        }
        if (!selectableItems[i].selected) {
          setSelectAllCheckboxStatus(false);
          return;
        }
      }
      setSelectAllCheckboxStatus(true);
    }
  }

  function getSelectAllCheckboxStatus() {
    var count = 0;
    if (selectAllCheckbox) {
      selectAllCheckbox.each(function() {
        if (this.checked) {
          ++count;
        }
      });
    }
    return count > 0;
  }

  function setSelectAllCheckboxStatus(status) {
    selectAllCheckbox.each(function() {
      this.checked = status;
    });
  }

  function setupAddSelectedItemsToCart(button, notify) {
    if (button.length > 0) {
      button.bind('click', function() {
        for (var items = [], item, l = selectableItems.length, i = 0; i < l; ++i) {
          if ((item = selectableItems[i]).selected) {
            updateItem(item, item.quantity.text() | 0);
            item.quantity.text(1);
            items.push(item);
          }
        }
        if (items.length > 0) {
          notify.stop(true, true).fadeIn(200).delay(1000).fadeOut(200);
        }
        return false;
      });
    }
  }

  function setupAddSelectedItemsToMemo(button) {
    if (button.length > 0) {
      if (button.hasClass('pc2015-disabled')) {
        button.bind('click', function() {
          return false;
        });
      } else {
        button.bind('click', function() {
          for (var items = [], l = selectableItems.length, i = 0; i < l; ++i) {
            if (selectableItems[i].selected) {
              items.push(selectableItems[i]);
            }
          }
          if (items.length > 0) {
            targetItems = items;
            pc2015.showPopup('memo');
          }
          return false;
        });
      }
    }
    return false;
  }

  function adjustItemHeight(list) {
    var items, heights;
    var name = 0;
    var price = 0;
    var sku = 0;
    for (var l = list.length, i = 0; i < l; ++i) {
      heights = list[i].heights;
      name = Math.max(heights.name, name);
      price = Math.max(heights.price, price);
      sku = Math.max(heights.sku, sku);
    }
    for (i = 0; i < l; ++i) {
      items = list[i].items;
      heights = list[i].heights;
      items.price1.css({
        paddingTop: name - heights.name
      });
      items.price.last().css({
        paddingBottom: price - heights.price
      });
      if (items.quantity.length === 0) {
        items.price.last().css({
          marginBottom: 59
        });
      }
    }
  }

  function adjustSelectableItemHeight(list) {
    var items, heights;
    var name = 0;
    var price = 0;
    var sku = 0;
    for (var l = list.length, i = 0; i < l; ++i) {
      heights = list[i].heights;
      name = Math.max(heights.name, name);
      price = Math.max(heights.price, price);
      sku = Math.max(heights.sku, sku);
    }
    for (i = 0; i < l; ++i) {
      items = list[i].items;
      heights = list[i].heights;
      items.price1.css({
        marginTop: name - heights.name + heights.nameBottom,
        paddingBottom: price - heights.price
      });
      if (items.sku.length > 0) {
        if (items.select.length > 0) {
          items.sku.css({
            paddingBottom: sku - heights.sku + 6
          });
          if (items.quantity.length === 0) {
            items.select.css({
              marginBottom: 58
            });
          }
        } else {
          if (items.quantity.length > 0) {
            items.sku.css({
              paddingBottom: sku - heights.sku + 6 + 25,
              borderBottomWidth: 1
            });
          } else {
            items.sku.css({
              paddingBottom: sku - heights.sku + 6 + 25 + 51,
              borderBottomWidth: 1
            });
            items.sku.css({
              marginBottom: 7
            });
          }
        }
      } else {
        if (items.select.length > 0) {
          items.inner.css({
            paddingBottom: sku - heights.sku
          });
          if (items.quantity.length === 0) {
            items.select.css({
              marginBottom: 58
            });
          }
        } else {
          if (items.quantity.length > 0) {
            items.inner.css({
              paddingBottom: sku - heights.sku + 25,
              borderBottomWidth: 1
            });
          } else {
            items.inner.css({
              paddingBottom: sku - heights.sku + 25 + 51,
              borderBottomWidth: 1
            });
            items.inner.css({
              marginBottom: 7
            });
          }
        }
      }
    }
  }

  function adjustSelectableItemListHeight() {
    var i, l = selectableItems.length;
    var w, cols = 0;
    var list = [];
    var item;
    if (l > 0) {
      w = selectableItems[0].item.parent().width();
      cols = w / 182 | 0;
      for (i = 0; i < l; ++i) {
        item = selectableItems[i].item;
        item.css({
          clear: (i % cols) === 0 ? 'both' : ''
        });
        if ((i % cols) === 0) {
          if (list.length > 0) {
            adjustSelectableItemHeight(list);
          }
          list = [];
        }
        list.push(getItemHeights(item, true));
      }
      if (list.length > 0) {
        adjustSelectableItemHeight(list);
      }
    }
  }

  function getItemHeights(item, forSelectable) {
    var name1 = item.find('.pc2015-item-name');
    var name2 = item.find('.pc2015-item-variation');
    var name3 = item.find('.pc2015-item-catalog-price');
    var price = item.find('.pc2015-item-price');
    var price1 = price.eq(0);
    var price2 = price.eq(1);
    if (price.length === 1) {
      price2 = null;
    }
    var sku = item.find('.pc2015-item-sku');
    var inner = item.find('.pc2015-item-inner');
    var select = item.find('.pc2015-item-select');
    var heights = {
      name: 0,
      nameBottom: 0,
      price: 0,
      sku: 0
    };
    if (forSelectable) {
      sku.css({
        paddingBottom: 6,
        marginBottom: 0,
        borderBottomWidth: 0
      });
      select.css({
        marginBottom: 0
      });
      inner.css({
        paddingBottom: 0,
        marginBottom: 0,
        borderBottomWidth: 0
      });
    } else {
      price1.css({
        paddingTop: 0
      });
      price.last().css({
        paddingBottom: 0,
        marginBottom: 6
      });
    }
    if (name1.length > 0) {
      heights.name += name1.height() + 18 + 8;
      heights.nameBottom = 8;
    }
    if (name2.length > 0) {
      heights.name += name2.height() + 6;
      heights.nameBottom = 6;
    }
    if (name3.length > 0) {
      heights.name += name3.height() + 6;
      heights.nameBottom = 6;
    }
    if (price1.length > 0) {
      heights.price += price1.height();
    }
    if (price2) {
      heights.price += price2.height() + 6;
    }
    if (sku.length > 0) {
      heights.sku += sku.innerHeight();
    }
    return {
      items: {
        price1: price1,
        price: price,
        sku: sku,
        inner: inner,
        select: select,
        quantity: item.find('.pc2015-item-quantity')
      },
      heights: heights
    };
  }

  function setupItemCarousel(jq) {
    var items = jq.find('.pc2015-item');
    var itemCarousel = {
      itemCarousel: jq,
      count: items.length
    };
    var heightsList = [];
    if (jq.hasClass('pc2015-item-list-selectable')) {
      items.each(function(i) {
        heightsList.push(getItemHeights($(this), true));
      });
      adjustSelectableItemHeight(heightsList);
    } else {
      items.each(function(i) {
        heightsList.push(getItemHeights($(this)));
      });
      adjustItemHeight(heightsList);
    }
    itemCarousel.itemCarousel.jcarousel({
      scroll: 1,
      setupCallback: function(jc) {
        jc.buttonNext.bind('click', function() {
          return false;
        });
        jc.buttonPrev.bind('click', function() {
          return false;
        });
      }
    });
    pc2015.$win.bind('resize', $.debounce(500, function() {
      adjustItemCarousel(itemCarousel);
    }));
    adjustItemCarousel(itemCarousel);
  }

  function adjustItemCarousel(itemCarousel) {
    var w0 = itemCarousel.itemCarousel.parent().width();
    var w = 717;
    var max = 4;
    var jc = itemCarousel.itemCarousel.data('jcarousel');
    while (w + 60 + 182 < w0) {
      w += 182;
      ++max;
    }
    if (itemCarousel.itemCarousel.width() !== w) {
      itemCarousel.itemCarousel.width(w);
      jc.scroll(1);
    }
    if (itemCarousel.count <= max) {
      jc.buttonNext.hide();
      jc.buttonPrev.hide();
    } else {
      jc.buttonNext.show();
      jc.buttonPrev.show();
    }
  }

  function setupMainBlock(jq) {
    var block = {
      block: jq,
      header: jq.find('.pc2015-main-block-header'),
      body: jq.find('.pc2015-main-block-body'),
      visible: !jq.hasClass('pc2015-main-block-hide'),
      button: jq.find('a.pc2015-main-block-toggle')
    };
    block.button.bind('click', function() {
      if (block.visible) {
        collapseMainBlock(block);
      } else {
        expandMainBlock(block);
      }
      return false;
    });
    if (block.block.hasClass('pc2015-main-block-closed')) {
      collapseMainBlock(block, true);
    }
  }

  function expandMainBlock(block, noAnimation) {
    block.visible = true;
    block.body.stop(true, true).slideDown(noAnimation ? 0 : 300, function() {
      if (pc2015.isIE7) {
        block.body.find('.pc2015-center-image').each(function() {
          adjustCenterImageIE7($(this));
        });
      }
      block.block.removeClass('pc2015-main-block-hide');
    });
  }

  function collapseMainBlock(block, noAnimation) {
    block.visible = false;
    block.body.stop(true, true).slideUp(noAnimation ? 0 : 300, function() {
      block.block.addClass('pc2015-main-block-hide');
    });
  }
  $(function() {
    var noMember = pc2015.$body.hasClass('pc2015-no-member');
    $('.pc2015-main-slider').each(function() {
      setupSlider($(this));
    });
    if (pc2015.isIE7) {
      $('.pc2015-center-image').each(function() {
        adjustCenterImageIE7($(this));
      });
    }
    $('.pc2015-item,.pc2015-detail').each(function() {
      setupItem($(this), noMember);
    });
    setupSelectAllItems($('.pc2015-pager-select-all input'));
    setupAddSelectedItemsToCart($('.pc2015-main-header-cart'), $('.pc2015-main-header-cart-notify'));
    setupAddSelectedItemsToCart($('.pc2015-memo-header-cart'), $('.pc2015-memo-header-cart-notify'));
    setupAddSelectedItemsToCart($('.pc2015-item-footer-cart'), $('.pc2015-item-footer-cart-notify'));
    setupAddSelectedItemsToMemo($('.pc2015-main-header-memo'));
    setupAddSelectedItemsToMemo($('.pc2015-item-footer-memo'));
    $('.pc2015-item-carousel').each(function() {
      setupItemCarousel($(this));
    });
    adjustSelectableItemListHeight();
    pc2015.$win.bind('resize', $.debounce(500, adjustSelectableItemListHeight));
    $('.pc2015-main-block').each(function() {
      setupMainBlock($(this));
    });
    var popup = pc2015.makePopup('memo', '.pc2015-popup-memo', {
      global: true,
      autohide: false,
      after: function(popup) {
        var ul = popup.popup.find('.pc2015-popup-memo-list').text('');
        for (var l = targetItems.length, i = 0; i < l; ++i) {
          ul.append($('<li>').text(targetItems[i].name));
        }
      }
    });
    popup.popup.find('.pc2015-ok').bind('click', function() {
      if (targetItems.length > 0) {
        targetItems = [];
      }
      pc2015.hideAllPopups();
      return false;
    });
    popup.popup.find('.pc2015-cancel').bind('click', function() {
      targetItems = [];
      pc2015.hideAllPopups();
      return false;
    });
    popup = pc2015.makePopup('alcohol', '.pc2015-popup-alcohol', {
      global: true,
      autohide: false
    });
    popup.popup.find('.pc2015-ok').bind('click', function() {
      if (targetItems) {
        for (var l = targetItems.length, i = 0; i < l; ++i) {
          addItemToCart(targetItems[i]);
        }
      }
      targetItems = [];
      pc2015.hideAllPopups();
      return false;
    });
    popup.popup.find('.pc2015-cancel').bind('click', function() {
      targetItems = [];
      pc2015.hideAllPopups();
      return false;
    });
     popup = pc2015.makePopup('search', '.pc2015-popup-search', {
      global: true,
      autohide: false
    });
    popup.popup.find('.pc2015-ok').bind('click', function() {
      if (targetItems) {
        for (var l = targetItems.length, i = 0; i < l; ++i) {
          addItemToCart(targetItems[i]);
        }
      }
      targetItems = [];
      pc2015.hideAllPopups();
      return false;
    });
    popup.popup.find('.pc2015-cancel').bind('click', function() {
      targetItems = [];
      pc2015.hideAllPopups();
      return false;
    });
  });
  
  //setupClickEvent start //////////////////////////////////////////////////////////////
   function customLinkTrack(click_name){
       try{
           click_name = click_name || "UNDEFINED";
           s.linkTrackVars='eVar38';
           s.eVar38=click_name;
           s.tl(this, 'o', click_name);
       } catch(e){}
   }

   function customLinkTrackClosure(nm){
     var nm2 = nm;
     return function(){
       customLinkTrack(nm2);
       return true;
     }
   }

   
  $(window).load(function(){
    if(document.location.pathname.match(/(\/c\/c)|(\/category\/category\.aspx)/) != null)
    {
      //leftmenu ns_top_leftnavi_0301-0312
      var tags = jQuery(".pc2015-side .pc2015-nav-link,.pc5-nav-tgl-2");
      for (var i = 0; i < tags.length; i++)
      {
        var nm = " ns_top_leftnavi_03" + ("00" + (i+1)).slice(-2) ;
        jQuery(tags[i]).click( 
         customLinkTrackClosure(nm) 
        );
      }//leftmenu END

      //hiddenmenu ns_top_leftnavi_0301-0312
      tags = jQuery(".pc2015-category-menu .pc2015-nav-link");
      for (var i = 0; i < tags.length; i++)
      {
        var nm = " ns_top_leftnavi_03" + ("00" + (i+1)).slice(-2) ;
        jQuery(tags[i]).click( 
         customLinkTrackClosure(nm) 
        );
      }//hiddenmenu END
      
      
      //submenu
      for (var i = 0; i < 99; i++)
      {
        nm = " ns_top_leftnavi_03" + ("00" + (i+1)).slice(-2) ;
        var root = jQuery(".pc2015-menu-root-" + (i+1) );
        if(root.length != 0)
        {
          tags = jQuery("a.pc2015-menu-link",root);
          tags.click( 
           customLinkTrackClosure(nm) 
          );
        }else{
          break;
        }
      }
      
      
      //submenu END
      
      //search ns_top_search_0101
      tags = jQuery("input[name='search']");
      tags.click( customLinkTrackClosure("ns_top_search_0101"));

      //POPWORD ns_top_popular_0201-0210
      tags = jQuery("a[href*='keyword=']");
      for (var i = 0; i < tags.length; i++)
      {
        var nm = " ns_top_popular_02" + ("00" + (i+1)).slice(-2) ;
        jQuery(tags[i]).click( 
         customLinkTrackClosure(nm) 
        );
      }//POPWORD END


      //RECOMMEND ns_top_item_0401-0420 ns_top_cart_0501-0520
      var recblk = jQuery(".pc2015-main-block");
      for (var i = 0; i < recblk.length; i++)
      {
        var atgs = jQuery("a.pc2015-item-inner.pc2015-for-member", jQuery(".pc2015-main-block")[i] );
        for (var j = 0; j < atgs.length; j++)
        {
          var atgnm = "ns_top_item_04" + (("00" + (i+1)) + (j+1)).slice(-2) ;
          jQuery(atgs[j]).click( 
           customLinkTrackClosure(atgnm) 
          );
        }
        
        var btns  = jQuery("a.btn_cart_one_ , .pc2015-for-member.pc2015-designed.pc2015-item-out.pc2015-disabled , .pc2015-for-member.pc2015-designed.pc2015-item-end" , jQuery(".pc2015-main-block")[i] );
        for (var j = 0; j < atgs.length; j++)
        {
          if(jQuery(btns[j]).hasClass("btn_cart_one_")){
            var btnnm = "ns_top_cart_05" + (("00" + (i+1)) + (j+1)).slice(-2) ;
            jQuery(btns[j]).click( 
             customLinkTrackClosure(btnnm) 
            );
          }
        }

      }//POPWORD END

		//HomeOrSpot Popup
		var sp_home = jQuery("#btn_home");
		var sp_home_nm = "ns_top_hmsp_home";
		jQuery(sp_home).click(
			customLinkTrackClosure(sp_home_nm)
		);
		var sp_spot = jQuery("#btn_spot");
		var sp_spot_nm = "ns_top_hmsp_spot";
		jQuery(sp_spot).click(
			customLinkTrackClosure(sp_spot_nm)
		);

    } 
  });
  //setupClickEvent end //////////////////////////////////////////////////////////////
  
})(window.jQuery, window.pc2015);
