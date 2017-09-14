(function($, pc2015) {
    'use strict';
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

    $('.pc2015-main-slider').each(function() {
        setupSlider($(this));
    });

    function updateSliderHeader(slider, i) {
        var headers = slider.headers;
        headers.removeClass('pc2015-active').eq(i % headers.length).addClass('pc2015-active');
    }
})(window.jQuery, window.pc2015);