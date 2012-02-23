(function($){$(document).ready(function(){
	
	// Date Picker Stuff
	jQuery('#event_date').datepicker();
	jQuery('#start_time').timepicker({
		hourGrid: 4,
		minuteGrid: 10,		
		ampm: true
	});
	jQuery('#end_time').timepicker({
		hourGrid: 4,
		minuteGrid: 10,		
		ampm: true
	});

	 jQuery("#frmCreate").validate();

	// testlink
	$('tbody .testlink').live('click',function(e){
		e.preventDefault();
		$.colorbox({html:'<iframe src="'+$(this).prev().val()+'" style="width:900px;height:450px;"></iframe>'});
	});

	// Sponsors

	// Delete
	$('tbody.sponsors .delete').live('click',function(e){
		e.preventDefault();
		var item = $(this).parents('tr');
		if(!item.hasClass('deleted')){		
			item.addClass('deleted');
			$(this).removeClass('red');
			$(this).addClass('gray');
			$(this).find('span').text('Undelete');
			item.find('div.actions input[name*="delete"]').val('true');
		}else{
			item.removeClass('deleted');
			$(this).removeClass('gray');
			$(this).addClass('red');
			$(this).find('span').text('Delete');
			item.find('input[name*="delete"]').val('false');
		}
	});

	// Add
	$('tfoot.sponsors .add').click(function(e){
		e.preventDefault();
		
		var index = $('tr.sponsor.new').length;
		
		$('tbody.sponsors').append('\
							<tr class="sponsor new">\
								<td class="name"><div class="input type-text"><input type="text" name="newsponsors['+index+'][\'name\']" value=""/></div></td>\
								<td class="url"><div class="input type-text"><input type="text" name="newsponsors['+index+'][\'url\']" value="" /> <a href="javascript:void(0)" target="_blank" class="btn green testlink"><span>Test</span></a></div></td>\
								<td class="actions">\
									<input type="hidden" value="newsponsors['+index+'][\'order\']" value="'+$('tr.sponsor').length+'"/>\
									<input type="hidden" value="newsponsors['+index+'][\'delete\']" value="false"/>\
									<button class="btn red delete"><span>Delete</span></button>\
								</td>\
							</tr>');
	});

	// Links

	// Delete
	$('tbody.links .delete').live('click',function(e){
		e.preventDefault();
		var item = $(this).parents('tr');
		if(!item.hasClass('deleted')){		
			item.addClass('deleted');
			$(this).removeClass('red');
			$(this).addClass('gray');
			$(this).find('span').text('Undelete');
			item.find('div.actions input[name="delete"]').val('true');
		}else{
			item.removeClass('deleted');
			$(this).removeClass('gray');
			$(this).addClass('red');
			$(this).find('span').text('Delete');
			item.find('div.actions input[name="delete"]').val('false');
		}
	});

	// Add
	$('tfoot.links .add').click(function(e){
		e.preventDefault();
		
		var index = $('tr.newlink.new').length;
		
		$('tbody.links').append('\
							<tr class="entry">\
								<td class="title">\
									<div class="input type-text"><input type="text" name="link['+index+'][\'title\']" value=""/></div>\
								</td>\
								<td class="url">\
									<div class="input type-text"><input type="text" name="link['+index+'][\'url\']" value=""/> <a href="javascript:void(0)" target="_blank" class="btn green test"><span>Test</span></a></div>\
								</td>\
								<td class="type">\
									<div class="input type-select">\
										<select name="link['+index+'][\'type\']" class="chzn">\
											<option value="default" selected="selected">Normal Link</option>\
											<option value="facebook">Facebook</option>\
											<option value="eventbrite">Eventbrite</option>\
											<option value="mailchimp">Mail Chimp</option>\
											<option value="googleplus">Google+</option>\
											<option value="twitter">Twitter</option>\
											<option value="pdf">PDF Downlaod</option>\
											<option value="svpply">Svpply</option>\
											<option value="yelp">Yelp</option>\
											<option value="foursquare">Foursquare</option>\
											<option value="gowalla">Gowalla</option>\
										</select>\
									</div>\
									<input type="hidden" value="link['+index+'][\'order\']" value="'+index+'"/>\
									<input type="hidden" value="link['+index+'][\'delete\']" value="false"/>\
								</td>\
								<td class="actions">\
									<button class="btn red delete"><span>Delete</span></button>\
								</td>\
							</tr>');
	});

});})(jQuery);