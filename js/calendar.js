
(function($){
	$(document).ready(function() {
		$('.cal-event-link').click(function(e){
			e.preventDefault();			
			
			var el = $(this);
			
			if(!el.parents().filter('.cal-day').hasClass('cal-active-day')){
			
				$.ajax({
					type : "GET",
					url  : el.attr('href'),
					success :function(html){
					
						// close the last open agenda
						var last = $('.cal-active-day');
						$('.cal-open-agenda').removeClass('cal-open-agenda').slideUp();
						
						// hide arrow
						last.find('.cal-event-arrow span').slideUp(function(){
							last.removeClass('cal-active-day');
							last.find('.cal-event-link span').html('SHOW<strong>AGENDA</strong>');
						});
						
						// set clicked day to active
						el.parents().filter('.cal-day').addClass('cal-active-day');
						el.find('span').html('HIDE<strong>AGENDA</strong>');
						
						var container = el.parents().filter('tr').next().find('.cal-agenda-container');
						container.find('.cal-agenda-wrapper').html(html);
						container.addClass('cal-open-agenda').slideDown(function(){
							// scroll to the element the open agenda
							$(document.body).animate({'scrollTop': el.offset().top});
						});
						
						// show arrow
						el.next().find('span').slideDown();
					}
				});
			}else{
				
				// close the last open agenda
				var last = $('.cal-active-day');
				$('.cal-open-agenda').removeClass('cal-open-agenda').slideUp();
				
				// hide arrow
				last.find('.cal-event-arrow span').slideUp(function(){
					last.find('.cal-event-link span').html('SHOW<strong>AGENDA</strong>');
					last.removeClass('cal-active-day');
				});
			}
			
			
		});
	});
})(jQuery);