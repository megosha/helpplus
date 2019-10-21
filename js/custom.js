"use strict";

window.addEventListener('load', function() {
//------------------------------------------------------------------------
//						NAVBAR SLIDE SCRIPT
//------------------------------------------------------------------------
$(window).scroll(function () {
    if ($(window).scrollTop() > $("nav").height()) {
        $("nav.navbar").addClass("show-menu");
    } else {
        $("nav.navbar").removeClass("show-menu");
        $("nav.navbar .navMenuCollapse").collapse({
            toggle: false
        });
        $("nav.navbar .navMenuCollapse").collapse("hide");
    }
});

//------------------------------------------------------------------------
//						NAVBAR HIDE ON CLICK (COLLAPSED) SCRIPT
//------------------------------------------------------------------------
//$('.navbar li a').on('click', function() {
//    $('.collapse.in').collapse('hide');
//});

});
window.addEventListener('load', function() {
	$('a.smooth').smoothScroll({speed: 800});
});
window.addEventListener('load', function() {
	$('body').delegate('input[type=text].datepicker-input', 'focusin', function(){
		$(this).datepicker({
			format: 'dd.mm.yyyy',
			weekStart: 1,
			autoclose: true,
			todayHighlight: true
		});
	});
});
