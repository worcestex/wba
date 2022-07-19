var $ = jQuery;
jQuery(document).ready(function($) {
    jQuery("#toggle-button").click(function(){
		jQuery('body').addClass('menu-open');
		jQuery('body').css({
			"overflow": "hidden",
		});
		jQuery( ".menu-wrap" ).css({
			"height": "100%",
		});
		jQuery('.menu-wrap ul li').each(function (i) {
	       jQuery(this).delay(100 * i).animate({ opacity: 1}, 200);
	  	});
	});
	jQuery(".menu-close-btn").click(function(){
		jQuery('body').removeClass('menu-open');
		jQuery('body').css({
			"overflow": "auto",
		});
		jQuery( ".menu-wrap" ).css({
			"height": "0",
		});
		jQuery('.menu-wrap ul li').each(function (i) {
	       jQuery(this).delay(1 * i).animate({ opacity: 0}, 150);
	  	});
	});
	jQuery('.open-panel-btn').on('click' , function(e){
		e.preventDefault();
		jQuery(this).toggleClass('active');
		jQuery('.dashboard-left-sec').toggleClass('active');
	})
	
    SetHeight();
	SetBannerHeight();

})

function SetBannerHeight() {
	var heightOfFirstDiv = jQuery('.header-wrap').outerHeight();
	jQuery('.main-banner-wrap').css({ 'height': 'calc(100vh - ' + heightOfFirstDiv+ 'px)' });
}
function SetHeight() {
	var heightOfFirstDiv = jQuery('.header-wrap').outerHeight();
	var heightOfSecondDiv = jQuery('footer').outerHeight();
	result = heightOfFirstDiv  + heightOfSecondDiv + 110;
	dashboard_result = heightOfFirstDiv  + heightOfSecondDiv;
	jQuery('.main-wrap-inner').css({ 'min-height': 'calc(100vh - ' + result+ 'px)' });
	jQuery('.dashboard-wrap').css({ 'min-height': 'calc(100vh - ' + dashboard_result+ 'px)' });

	console.log(result);
}

jQuery(window).resize(function(){
    SetHeight();
    SetBannerHeight();
});

$(".offcanvas").on("shown.bs.offcanvas", function () {
	jQuery('body').css({
		"padding-right": "0",
	});
    // const backdrop = $(".offcanvas-backdrop");
    // const parent = backdrop.parent();
    // const cloned = backdrop.clone();
    // backdrop.remove();
    // parent.append(cloned);
})
// .on("hide.bs.offcanvas", function () {
//     $(".offcanvas-backdrop").remove();
// });

$('.watch-list, .wish-list').on('click' , function(e){
	e.preventDefault();
	jQuery(this).toggleClass('active');
})


