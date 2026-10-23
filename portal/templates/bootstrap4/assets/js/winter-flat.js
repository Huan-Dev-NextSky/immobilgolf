/* placeholder for IE */
    /*"use strict";*/
  
$(document).ready(function() {    
    var _headerSlider= $("#header-slider");
    
    /* placeholder for IE */
    $.support.placeholder = ('placeholder' in document.createElement('input'));
    //fix for IE
    if (!$.support.placeholder) {
        $("[placeholder]").on('focus', function () {
            if ($(this).val() === $(this).attr("placeholder"))
                $(this).val("");
        }).blur(function () {
            if ($(this).val() === "")
                $(this).val($(this).attr("placeholder"));
        }).blur();

        $("[placeholder]").parents("form").submit(function () {
            $(this).find('[placeholder]').each(function () {
                if ($(this).val() === $(this).attr("placeholder")) {
                    $(this).val("");
                }
            });
        });
    }
    /* end placeholder for IE */
    
    /* Start slider touch */
    _headerSlider.swiperight(function () {
        $(this).carousel('prev');
    });
    _headerSlider.swipeleft(function () {
        $(this).carousel('next');
    });
    /* End slider touch */
    
    _headerSlider.on('mousedown', function () {
        $(document).on('mousemove', function (e) {
            $('#header-slider').css('cursor', 'pointer')
        })
        $(this).unbind('mouseup');
        $(this).on('mouseup', function (e) {
            $('#header-slider').css('cursor', 'auto')
            document.onmousemove = null;
            $(document).unbind('mousemove')
        })
    });
    
    //dropdown select
    $('.selectpicker').selectpicker({
        style: 'selectpicker-primary',
    });
    
    $('.select_styled').selectpicker({
        style: 'selectpicker-primary',
    });
    
    /* Start menu dropdown */
    var _w = $(window);
    $('#main-menu .dropdown').on({
            'mouseover' : function () {
                            if(_w.width()>767)
                                $(this).addClass('active').find('.dropdown-menu').stop(true, true).delay(100).fadeIn('fast');
                        },
            'mouseout' :function () {
                            if(_w.width()>767)
                                $(this).removeClass('active').find('.dropdown-menu').stop(true, true).delay(100).fadeOut('fast');
                        }
    });
    
    $('#main-menu .dropdown-menu').on({
            'mouseover': function () {
                            if(_w.width()>767)
                                    $(this).stop(true, true);
                    },
            'mouseout': function () {
                            if(_w.width()>767)
                                $(this).stop(true, true).delay(100).fadeOut('fast');
                    }
    });
    /* End menu dropdown */

    /* Start no drag and selected */
    // Prevent anchor links and buttons and .nodrag items from being dragged
    $('.carousel-inner .carousel-item img, .no-drag, .carousel-inner *')
            .css('-moz-user-select', 'none')
            .css('-webkit-user-select', 'none')
            .on('selectstart', function (e) {
                e.preventDefault();
                return false;
            })
            .on('draggesture', function (e) {
                e.preventDefault();
                return false;
            })
            .on('draggable', function (e) {
                e.preventDefault();
                return false;
            })
            .on('dragstart', function (e) {
                e.preventDefault();
                return false;
            });
    /* End no drag and selected */

/* Start carusel */
   var owlAgencies = $('.agencies-corousel .owl-carousel');
    if($('body').hasClass('full-width'))
        owlAgencies.owlCarousel({
            responsiveClass: true,
            margin: 30,
            loop: owlAgencies.children().length > 1,
            responsive: {
                0: {
                    items: 1,
                },
                670: {
                    items: 2,
                },
                1200: {
                    items: 3,
                },
                1400: {
                    items: 4,
                },
                2100: {
                    items: 6,
                }
            }
        });
    else 
        owlAgencies.owlCarousel({
            responsiveClass: true,
            margin: 30,
            loop: owlAgencies.children().length > 1,
            responsive: {
                0: {
                    items: 1,
                },
                670: {
                    items: 2,
                },
                1200: {
                    items: 3,
                }
            }});
    // Go to the next item
    $('.agencies-corousel .customNextBtn').on('click', function (e) {
        e.preventDefault();
        owlAgencies.trigger('next.owl.carousel');
    })
    // Go to the previous item
    $('.agencies-corousel .customPrevBtn').on('click', function (e) {
        e.preventDefault();
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owlAgencies.trigger('prev.owl.carousel', [300]);
    })

    var owlAgents = $('#agents-corousel .owl-carousel');
    if($('body').hasClass('full-width'))
        owlAgents.owlCarousel({
            margin: 30,
            responsiveClass: true,
            loop: owlAgents.children().length > 1,
            responsive: {
                0: {
                    items: 1,
                },
                670: {
                    items: 2,
                },
                1200: {
                    items: 3,
                },
                1400: {
                    items: 4,
                },
                2100: {
                    items: 6,
                }
            }
        });
    else
        owlAgents.owlCarousel({
            margin: 30,
            responsiveClass: true,
					 loop: owlAgents.children().length > 1,
            responsive: {
                0: {
                    items: 1,
                },
                670: {
                    items: 2,
                },
                1200: {
                    items: 3,
                }
            }
        });
    // Go to the next item
    $('.agents-corousel .customNextBtn').on('click', function (e) {
        e.preventDefault();
        owlAgents.trigger('next.owl.carousel');
    })
    // Go to the previous item
    $('.agents-corousel .customPrevBtn').on('click', function (e) {
        e.preventDefault();
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owlAgents.trigger('prev.owl.carousel', [300]);
    })

    // agents carousel big
    var owlAgentsBig = $('#agents-corousel-big .owl-carousel');
       if($('body').hasClass('boxed'))
    owlAgentsBig.owlCarousel({
        margin: 30,
        responsiveClass: true,
        loop: owlAgentsBig.children().length > 1,
        responsive: {
            0: {
                items: 1,
            },
                768: {
                    items: 2,
                },
                1200: {
                    items: 3,
                },
                1400: {
                    items: 3,
                }
            }
        });
    else
        owlAgentsBig.owlCarousel({
            margin: 30,
            responsiveClass: true,
            loop: owlAgentsBig.children().length > 1,
            responsive: {
                0: {
                    items: 1,
                },
            670: {
                items: 2,
            },
            1200: {
                items: 3,
            },
            1400: {
                items: 4,
            },
            2100: {
                items: 6,
            }
        }
    });
    // Go to the next item
    $('#agents-corousel-big .customNextBtn').on('click', function (e) {
        e.preventDefault();
        owlAgentsBig.trigger('next.owl.carousel');
    })
    // Go to the previous item
    $('#agents-corousel-big .customPrevBtn').on('click', function (e) {
        e.preventDefault();
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        owlAgentsBig.trigger('prev.owl.carousel', [300]);
    })

    // agents carousel big
    if ($('#property-corousel').length) {
        var owlAgentsBig2 = $('#property-corousel .owl-carousel');
        owlAgentsBig2.owlCarousel({
            margin: 30,
            responsiveClass: true,
            loop: owlAgentsBig2.children().length > 1,
            responsive: {
                0: {
                    items: 1,
                },
                670: {
                    items: 2,
                },
                1000: {
                    items: 3,
                },
                1200: {
                    items: 4,
                }
            }
        });
        // Go to the next item
        $('#property-corousel .customNextBtn').on('click', function (e) {
            e.preventDefault();
            owlAgentsBig2.trigger('next.owl.carousel');
        })
        // Go to the previous item
        $('#property-corousel .customPrevBtn').on('click', function (e) {
            e.preventDefault();
            // With optional speed parameter
            // Parameters has to be in square bracket '[]'
            owlAgentsBig2.trigger('prev.owl.carousel', [300]);
        })
    }
/* End carusel */

    /* Start btn-scroll-up */
    var _bs =$('#btn-scroll-up');
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 500) {
            _bs.css('display', 'block');
        } else {
            _bs.css('display', 'none');
        }
    });

    _bs.on('click', function () {
        $('html,body').animate({scrollTop: 0}, 'slow');
        return false;
    });
    /* End btn-scroll-up */

/* Start Top bar fixed */
    var _t = $('.top-box');
    if ($(this).scrollTop() > 250) {
        _t.addClass('top-bar-fixed');
    }
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 300) {
            _t.addClass('top-bar-fixed');
        } else if($(this).scrollTop() < 200) {
            _t.removeClass('top-bar-fixed');
        }
    });

    //sticky
    // Custom 
    var stickyToggle = function (sticky, stickyWrapper, scrollElement) {
        var stickyHeight = sticky.outerHeight();
        var stickyTop = stickyWrapper.offset().top;
        if (scrollElement.scrollTop() >= stickyTop) {
            stickyWrapper.height(stickyHeight);
            sticky.addClass("is-sticky");
        } else {
            sticky.removeClass("is-sticky");
            stickyWrapper.height('auto');
        }
    };

    // Find all data-toggle="sticky-onscroll" elements
    $('[data-toggle="sticky-onscroll"]').each(function () {
        var sticky = $(this);
        var stickyWrapper = $('<div>').addClass('sticky-wrapper'); // insert hidden element to maintain actual top offset on page
        sticky.before(stickyWrapper);
        sticky.addClass('sticky');

        // Scroll & resize events
        $(window).on('scroll.sticky-onscroll resize.sticky-onscroll', function () {
            stickyToggle(sticky, stickyWrapper, $(this));

            if ($(window).scrollTop() === 0) {
                sticky.removeClass("is-sticky");
                stickyWrapper.height('auto');
            }
        });

        // On page load
        stickyToggle(sticky, stickyWrapper, $(window));
    });
    /* End Top bar fixed */


    /* Start Image gallery 
    *    use css/blueimp-gallery.min.css
    *    use js/blueimp-gallery.min.js
    *    use config assets/js/realsite.js
    *    Site https://github.com/blueimp/Gallery/blob/master/README.md#setup
    *   
    *
    */      
    $(document).on('click', '.images-gallery a.preview:not(.skip)', function (e) {
        e.preventDefault();
        var myLinks = new Array();
        var current = $(this).attr('href');
        var curIndex = 0;

        $('.images-gallery a.preview:not(.skip)').each(function (i) {
            var img_href = $(this).attr('href');
            myLinks[i] = img_href;
            if(current == img_href)
                curIndex = i;
        });

        options = {index: curIndex}

        blueimp.Gallery(myLinks,options);

        return false;
    });   
    
/* End Image gallery */
/*
$("#route_from_button").click(function () { 
     window.open("https://maps.google.hr/maps?saddr="+$("#route_from").val()+"&daddr={estate_data_address}@{estate_data_gps}&hl={lang_code}",'_blank');
     return false;
 });*/

/* start image cover ( use class object-fit-container  as div.object-fit-container > img) */
    /*"use strict";*/
    if (  !Modernizr.prefixed('objectFit') ) {
      $('.object-fit-container, .img-cover-box, .image-box, .img-circle-cover, #property-slider .carousel-item').each(function () {
        var $container = $(this);
        $(this).addClass('object-fit-container');
            imgUrl = $container.find('img').prop('src');
        if (imgUrl) {
          $container
            .css('background-image', 'url("'+imgUrl+'")')
            .addClass('compat-object-fit');
        }  
      });
    }
    
    /*"use strict";*/
    if (true) {
        $('.news-thumbnail, .image-cover-div, .header-slider .carousel-item').each(function () {
            var $container = $(this);
            $(this).addClass('object-fit-container');
            imgUrl = $container.find('img').prop('src');
            if (imgUrl) {
                $container.addClass('compat-object-fit')
                    .prepend('<div class="object-fit-imagediv"></div>').find('.object-fit-imagediv')
                    .css('background-image', 'url("'+imgUrl+'")');
            }  
        });
    }
/* end image cover */

/* start big slider */
    if($('.slider-full-height').length){
        var height =  $(window).height() || FALSE;
        if(height)
            $('.header-slider .carousel.slider-tall .carousel-inner .carousel-item').height(height);
        
        $(window).resize(function(){
            var height =  $(window).height() || FALSE;
            if(height)
                $('.header-slider .carousel.slider-tall .carousel-inner .carousel-item').height(height);
        })
    }
/* end big slider */

/* start property slider */
    $('.property-slider-thumbnail .images-gallery li').on('touchstart click', function(){
        var i = $(this).attr('data-index').trim() || false;
        if(i){
            $('.property-slider').carousel(parseInt(i))
            $('.property-slider-thumbnail .images-gallery li').removeClass('active');
            $(this).addClass('active');
        }
    })
    
   $('.property-slider').on('slid.bs.carousel', function () {
        var i =  $('div.active', this).index() || false;
        $('.property-slider-thumbnail .images-gallery li').removeClass('active');
        if(i)
            $('.property-slider-thumbnail .images-gallery li[data-index="'+parseInt(i)+'"]').addClass('active');
  })
/* end property slider */
  
    $('#search-additional').on('click', function () {
        if ($('#form-addittional').length) {
            var _fa = $('#form-addittional');
            var _ai = $('#search-additional i');
            var form = $(this).closest('.search-form ');
            form.addClass('open-form');
            var _searchbtn =$('#search-btn').parent();
            if (_fa.is(':visible')) {
                _ai.removeClass('fa-minus-circle').addClass('fa-plus-circle');
                 form.removeClass('open-form');
            } else {
                _ai.removeClass('fa-plus-circle').addClass('fa-minus-circle');
                form.addClass('open-form');
            }
            _fa.slideToggle();
        }
    })
        
    $('#search-right-side .form-addittional select').selectpicker({
        style: 'selectpicker-primary',
    });
  
})



function support_history_api()
{
    return !!(window.history && history.pushState);
}

function custom_number_format(val)
{
    return val.toFixed(2);
}

function format_number_message(x) {
    if(isNaN(x))return "";

    n= x.toString().split('.');
    return n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(n.length>1?"."+n[1]:"");
}