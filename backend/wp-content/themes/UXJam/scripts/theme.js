(function($){
	$(document).ready(function(){
		$hamb = $(".jam-toggle-menu");
		$menu = $(".jam-sidemenu");
		$olay = $(".jam-menu-overlay");
		$btn = $("#top-menu > li > a");
		$hamb.click(function(){
			$menu.toggleClass("show");
			$olay.toggleClass("show");
		});
		$btn.on('click', function(){
			$menu.toggleClass("show");
			$olay.toggleClass("show");
		});
		$olay.on('click', function(){
			$menu.toggleClass("show");
			$olay.toggleClass("show");
		});
	});
})(jQuery);

(function($){
	$img 	= $("#jam-menu-container > div").last();
	$h 		= $("#jam-menu-container > div").first().height();
	width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	$(window).load(function(){
		if (width > 767){
			$img.css({
				"height": 	$h,
				"overflow": 	"hidden"
			});
		} else {
			$img.css({
				"height": 	0,
				"overflow": 	"hidden"
			});
		}
			
	});
	$(window).resize(function(){
		if (width > 767){
			$img.css({
				"height": 	$h,
				"overflow": 	"hidden"
			});
		} else {
			$img.css({
				"height": 	0,
				"overflow": 	"hidden"
			});
		}
	});


})(jQuery);

jQuery(function($) {
	// $('.jam-food-bottom-upsale').find('a[href$=".gif"], a[href$=".jpg"], a[href$=".png"], a[href$=".bmp"]').magnificPopup({type:'image'});
	// $('.jam-menu-page').find('a[href$=".gif"], a[href$=".jpg"], a[href$=".png"], a[href$=".bmp"]').magnificPopup({type:'image'});
	// $('.jam-food-page').find('a[href$=".gif"], a[href$=".jpg"], a[href$=".png"], a[href$=".bmp"]').magnificPopup({type:'image'});
	$('.jam-menu-page .jam-menu-item').click(handleClick);
	// $('.jam-food-page .jam-menu-item').click(handleClick);
	function handleClick(e) {
		e.preventDefault();
		let href = $(this).find('a').attr('href');
		window.location.href = href;
	}
});