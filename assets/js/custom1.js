$(document).ready(function () {
    // toogle menu 
    // $('#nav-icon2').click(function (e) {
    //     e.stopPropagation();
    //     $('body').toggleClass('open-nav');
    //     $(this).toggleClass('open');
    // });

    // $('body').click(function (e) {
    //     e.stopPropagation();
    // });

    // $(".nav-bar .nav-left li a").each(function () {
    //     $(this).click(function (e) {
    //         $('body').removeClass('open-nav');
    //         $('#nav-icon2').removeClass('open');
    //     });
    // })

    // $('body,html').click(function (e) {
    //     $('body').removeClass('open-nav');
    //     $('#nav-icon2').removeClass('open');
    // });
    
    // sticky Menu
    $(window).scroll(function () {
        var sticky = $('header'),
                scroll = $(window).scrollTop();

        if (scroll >= 70)
            sticky.addClass('fixed');
        else
            sticky.removeClass('fixed');
    });

    $("#myBtn").hide();
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#myBtn').fadeIn();
            } else {
                $('#myBtn').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('#myBtn').click(function () {
            $('body').addClass('open-body');

            $('body,html').animate({
                scrollTop: 0

            }, 5000);
            setTimeout(function () {

                if ($(window).scrollTop() == 0 || $(window).scrollTop() == $(document).height() - $(window).height()) {
                    $('body').removeClass('open-body');
                }
            }, 5000);

            return false;
        });
    });

    $(function () {
        $('#search-menu').removeClass('toggled');

        $('#search-icon').click(function (e) {
            e.stopPropagation();
            $('#search-menu').toggleClass('toggled');
            $("#popup-search").focus();
        });

        $('#search-menu input').click(function (e) {
            e.stopPropagation();
        });

        $('#search-menu, body').click(function () {
            $('#search-menu').removeClass('toggled');
        });
    });
    
    $("#hulk").click(function() {
        var offset = -100; //Offset of 20px
        
        $('html, body').animate({
        scrollTop: $("#brigloo-effect").offset().top + offset
        }, 1000);
    });

    $(function () {
        $(window).scroll(function (e) {
            var scrollTop = $(window).scrollTop();
            var viewportHeight = $(window).height();
            $('.brigloo-effect').each(function () {
                var top = $(this).offset().top;
                var bottom = top + $(".brigloo-effect").offset().top + 5000 + $(this).height();
                if (top <= scrollTop && bottom >= (scrollTop + viewportHeight)) {
                    $(this).addClass('visible');
                } else {
//                    console.log(top, bottom, scrollTop, viewportHeight);
                    $(this).removeClass('visible');
                }
            });
        });
    });
    $(function () {
   
        window.onscroll = function (ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                $('body').addClass('rotate');
            } else {
                $('body').removeClass('rotate');

            }
        };
    });
    var position = $(window).scrollTop();

// should start at 0

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll > position) {
//            console.log('scrollDown');
            $('.brigloo-effect').addClass('Scrolling-Down');
            $('.brigloo-effect').removeClass('Scrolling-Up');
        } else {
//            console.log('scrollUp');
            $('.brigloo-effect').removeClass('Scrolling-Down');
            $('.brigloo-effect').addClass('Scrolling-Up');
        }
        position = scroll;
    });

    jQuery(window).scroll(function () {
        if (jQuery('.brigloo-effect').hasClass('visible'))
        {
            jQuery('body').addClass('add-toggle');
        } else
        {
            jQuery('body').removeClass('add-toggle');
        }

    });

    $(".about-link").click(function() {
        var offset = -300; //Offset of 20px
        
        $('html, body').animate({
        scrollTop: $("#what-brigloo").offset().top + offset
        }, 3000);
    });
    
    //        loader
	    $(window).load(function() {
	        setTimeout(function() {
	            $(".page-loader").fadeOut("slow");
	        }, 2000);
	    });
    
});
