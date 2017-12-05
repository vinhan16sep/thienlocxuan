$(document).ready(function () {
	'use strict';
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
	
	$('.collapse').on('show.bs.collapse', function () {
		$('.collapse').collapse('hide');
	});
	
	$(window).scroll(function () {
      //if you hard code, then use console
      //.log to determine when you want the 
      //nav bar to stick.  
    if ($(window).scrollTop() > 100) {
      $('.header').addClass('fix-top');
    }
    if ($(window).scrollTop() < 100) {
      $('.header').removeClass('fix-top');
    }
    });
});