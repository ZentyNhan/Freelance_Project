(function ($) {
    "use strict";
    /**
     * https://tried.vn/
     */

    if ($(document).scrollTop() > 450) {
        $('body').addClass('scrolling');
    }
    $(window).scroll(function() {
        if ($(document).scrollTop() > 450) {
            $('body').addClass('scrolling');
        } else {
            $('body').removeClass('scrolling');
        }
    });

    $(document).on('click', '#scroll-top', function(e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 600);
    });

    $(document).on('click', '.search-action-block .searchform-action', function(e) {
        var wrapper = $(this).closest('.search-action-block');
        if (wrapper.hasClass('opened')) {
            wrapper.removeClass('opened');
        } else {
            wrapper.addClass('opened');
        }
    });

    $(document).on('click', '.site-navigation-toggle, .site-cart-toggle', function(e) {
        var wrapper = $(this).closest('.site-navigation');
        var role = ($(this).attr('role') && $(this).attr('role') != '')?$(this).attr('role'):"menu";
        if (wrapper.hasClass('opened')) {
            wrapper.removeClass('opened');
            wrapper.attr('role', '');
        } else {
            wrapper.addClass('opened');
            wrapper.attr('role', role);
        }
    });

    $(document).on('click', '.cart-toggle', function(e) {
        var wrapper = $(this).parent();
        if (wrapper.find('.cart-wrapper').hasClass('opened')) {
            wrapper.find('.cart-wrapper').removeClass('opened');
        } else {
            wrapper.find('.cart-wrapper').addClass('opened');
        }
    });

    if ($('.section-home-slider').length > 0) {
        $('.section-home-slider').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_slider = new Swiper(".widget-home-slider", {
                grabCursor: true,
                loop: true,
                autoplay: false,
                speed: 750,
                // effect: "creative",
                // creativeEffect: {
                //     prev: {
                //         shadow: true,
                //         translate: ["-20%", 0, -1],
                //     },
                //     next: {
                //         translate: ["100%", -1, 0],
                //     },
                // },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                // pagination: {
                //     el: ".swiper-pagination",
                //     clickable: true
                // }
            });
        });
    }
    
    if ($('.section-home-partner').length > 0) {
        $('.section-home-partner').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_partner = new Swiper(".widget-home-partner", {
                slidesPerView: 5,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 3000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 5,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    
    if ($('.section-home-testimonial').length > 0) {
        $('.section-home-testimonial').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_testimonial = new Swiper(".widget-home-testimonial", {
                slidesPerView: 2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 3000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    }
                }
            });
        });
    }
    
    if ($('.widget-single-relate').length > 0) {
        $('.widget-single-relate').each(function() {
            let control = $(this).attr('data-control');
            const widget_single_relate = new Swiper(".widget-single-relate", {
                slidesPerView: 3,
                spaceBetween: 20,
                // navigation: {
                //     nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                //     prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                // },
                loop: true,
                autoplay: {
                    delay: 3000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                }
            });
        });
    }
    
    if ($('.section-swiper').length > 0) {
        $('.section-swiper').each(function() {
            let control = $(this).attr('data-control'),
                setLoop = false,
                setSlidesPerView = 1,
                setSpaceBetween = 10,
                setNav = {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                setAutoplay = {
                    delay: 5000,
                },
                setPagination = {
                    el: '.swiper-pagination[key="'+control+'"]',
                    clickable: true
                },
                setEffect = false;
            if ($(this).attr('data-loop') == 'true' || $(this).attr('data-loop') == 1) {
                setLoop = true;
            }
            if ($(this).attr('data-nav') == 'false' || $(this).attr('data-nav') == 0) {
                setNav = false;
            }
            if ($(this).attr('data-pagination') == 'false' || $(this).attr('data-pagination') == 0) {
                setPagination = false;
            }
            if ($(this).attr('data-effect')) {
                setEffect = $(this).attr('data-effect');
            }
            new Swiper('.section-swiper[data-control="'+control+'"] .swiper', {
                slidesPerView: setSlidesPerView,
                spaceBetween: setSpaceBetween,
                loop: setLoop,
                autoplay: setAutoplay,
                navigation: setNav,
                pagination: setPagination,
                effect: setEffect,
                fadeEffect: {
                    crossFade: true
                }
            });
        });
    }

    if ($('.section-home-review').length > 0) {
        $('.section-home-review').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_review = new Swiper(".widget-home-review", {
                slidesPerView: 2,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                // navigation: {
                //     nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                //     prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                // },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    767: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }

    // var widget_home_review_thumb = new Swiper(".widget-home-review-thumb", {
    //     centeredSlides: true,
    //     centeredSlidesBounds: true,
    //     slidesPerView: 3,
    //     watchOverflow: true,
    //     watchSlidesVisibility: true,
    //     watchSlidesProgress: true,
    //     direction: 'vertical',
    //     autoplay: {
    //         delay: 5000,
    //     },
    // });

    // var widget_home_review = new Swiper(".widget-home-review", {
    //     watchOverflow: true,
    //     watchSlidesVisibility: true,
    //     watchSlidesProgress: true,
    //     preventInteractionOnTransition: true,
    //     effect: "fade",
    //     fadeEffect: {
    //         crossFade: true
    //     },
    //     autoplay: {
    //         delay: 5000,
    //     },
    //     navigation: {
    //         nextEl: '.swiper-button.swiper-button-next',
    //         prevEl: '.swiper-button.swiper-button-prev',
    //     },
    //     thumbs: {
    //         swiper: widget_home_review_thumb
    //     }
    // });
    // widget_home_review_thumb.on('slideChangeTransitionStart', function() {
    //     widget_home_review_thumb.slideTo(widget_home_review.activeIndex);
    // });
      
    // widget_home_review_thumb.on('transitionStart', function(){
    //     widget_home_review.slideTo(widget_home_review_thumb.activeIndex);
    // });
    
    if ($('.section-home-member').length > 0) {
        $('.section-home-member').each(function() {
            let control = $(this).attr('data-control');
            const swiper_home_member = new Swiper('.widget-home-member', {
                slidesPerView: 4,
                spaceBetween: 20,
                loop: false,
                autoplay: {
                    delay: 5000,
                },
                // navigation: {
                //     nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                //     prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                // },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    960: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    $( document ).on( 'change', 'select.slct-provinces', function(e) {
		e.preventDefault();
        var wrapper = $(this).closest('.slct-position'),
            province_service = $('option:selected', this).attr('data-service'),
            province_id = $(this).val();
        if ( province_id ) {
            $.ajax({
                type : "get", 
                url : tried_script.ajax_url, 
                data : {
                    action: 'render_districts',
                    province: province_service
                },
                beforeSend: function() {
                    wrapper.find('.slct-provinces').attr('disabled', 'disabled');
                    wrapper.find('.slct-districts').attr('disabled', 'disabled');
                },
                success: function(res) {
                    if ( res.code == 200 ) {
                        wrapper.find('.slct-districts').html('<option value="">Chọn huyện</option>');
                        res.response.forEach(function(item) {
                            wrapper.find('.slct-districts').append(`<option value="${item.district_service_order}-${item.district_service_key}" data-type="${item.type}" data-service="${item.district_service_key}">${item.name}</option>`);
                        });
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                complete: function() {
                    wrapper.find('.slct-provinces').removeAttr('disabled');
                    wrapper.find('.slct-districts').removeAttr('disabled');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
	} );

    // quick search regex
    // var buttonFilter;
    // // init Isotope
    // var $grid = $('#tabs-contain .gallery').isotope({
    //     itemSelector: '.item',
    //     layoutMode: 'fitRows',
    //     filter: function() {
    //         var $this = $(this);
    //         var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
    //         return buttonResult;
    //     }
    // });

    // $('ul#tabs-filtering').on( 'click', 'li a', function() {
    //     buttonFilter = $( this ).attr('data-filter');
    //     $('ul#tabs-filtering li a.active').removeClass('active');
    //     $(this).addClass('active');
    //     $grid.isotope();
    // });

    jQuery( document.body ).on( 'updated_cart_totals removed_from_cart', function( event, fragments, cart_hash, $button ) {
         $('.cart-block .cart-wrapper').html(fragments['div.widget_shopping_cart_content']);
    });
})(jQuery);
