$(document).ready(function(){
	$('nav a[href^="#"]').bind('click.smoothscroll',function (e) {
	    e.preventDefault();
	 
	    var target = this.hash,
	    $target = $(target);
	 	// console.log(target);
	 	// debugger
	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top-75
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});
});
