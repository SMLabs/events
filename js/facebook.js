// initialize global environment
(function($){
	$(window).ready(function(){		
	
		// Load Facebook SDK
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=168926043221899";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		window.fbAsyncInit = function() {
			FB.Canvas.setSize({'height':$(document.body).height()});
		}
				
		// Handle Alerts
		$('.alert').delay(6000).slideUp();
		$('.alert .close').live('click',function(el){
			$(this).parents('.alert').slideUp();
		});
	});

})(jQuery);

// Do things that will sometimes call sizeChangeCallback()
function sizeChangeCallback() {
	FB.Canvas.setSize();
}