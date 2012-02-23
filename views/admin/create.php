<?php
	$links[] = (object)array(
		'id'=>'0',
		'title'=>'search',
		'url'=>'http://google.com?q=bossninja',
		'type'=>'googleplus'
	);
	$links[] = (object)array(
		'id'=>'0',
		'title'=>'search',
		'url'=>'http://google.com?q=bossninja',
		'type'=>'googleplus'
	);
	$links[] = (object)array(
		'id'=>'0',
		'title'=>'search',
		'url'=>'http://google.com?q=bossninja',
		'type'=>'default'
	);
	$links[] = (object)array(
		'id'=>'0',
		'title'=>'search',
		'url'=>'http://google.com?q=bossninja',
		'type'=>'googleplus'
	);
	$links[] = (object)array(
		'id'=>'0',
		'title'=>'search',
		'url'=>'http://google.com?q=bossninja',
		'type'=>'googleplus'
	);
	$links[] = (object)array(
		'id'=>'0',
		'title'=>'search',
		'url'=>'http://google.com?q=bossninja',
		'type'=>'googleplus'
	);
	
	$sponsors[] = (object)array(
		'id'=>'0',
		'name'=>'Strikehard Productions',
		'url'=>'http://strikehardproductions.com'
	);
?>

<script>
jQuery(document).ready(function() {
	
	jQuery('#event_date').datepicker();

	jQuery('#start_time').timepicker({
		//showSecond: true,
		//timeFormat: 'hh:mm:ss',
		hourGrid: 4,
		minuteGrid: 10,		
		ampm: true
	});
	
	jQuery('#end_time').timepicker({
		//showSecond: true,
		//timeFormat: 'hh:mm:ss',
		hourGrid: 4,
		minuteGrid: 10,		
		ampm: true
	});

	 jQuery("#frmCreate").validate();
});
</script>

<style>
	.form_inputs .input{
		width:66% !important;
	}
		
	div.input input{
		box-sizing:border-box;
	}
	
	#cke_contents_description{
		height:300px !important;
	}
	
	tr.sponsor input{
		width:90% !important;
	}
	
	tr.sponsor .url input{
		width:86% !important;
	}
	
	div.floating-footer{
		position:fixed;
		bottom:0;
		left:0;
		background-color:#FFF;
		border-top:1px solid #EEE;
		padding:10px;
		width:100%;
		z-index:9999;
	}
	
</style>

<form action="<?php echo site_url('admin/'.$this->config->item('module_name').'/save/'); ?>" method="post" name="frmCreate" id="frmCreate" >
	<div class="">
		<section class="title"><h4>Event Details</h4></section>
		<section class="item">
			<div class="form_inputs ui-tabs-panel ui-corner-bottom">
				<frameset>
					<ul>
						<li>
							<label>Name <small>The name of the event you are creating</small></label>
							<div class="input type-text"><input type="text" name="name" id="name"  class="required" /></div>
						</li>
 
						<li>
							<label for="event_date">Date <small>The day the event will occur. You will have to create additional event entries for events that span multiple days.</small></label>
							<div class="input type-text"><input type="text" id="event_date" name="event_date" value="" class="required" /></div>
						</li>

						<li>
							<label for="start_time">Start Time <small>The time at which your event begins and people should start showing up.</small></label>
							<div class="input type-text"><input type="text" id="start_time" name="start_time" value="" class="required" /></div>     
						</li> 

						<li>
							<label for="end_time">End Time <small>The time at which your event ends and people should start leaving.</small></label>
							<div class="input type-text"><input type="text" id="end_time" name="end_time" value="" class="required" /></div>
						</li>
 
						<li>
							<label for="description">Description: <small>The main description that will be used to convey your event's purpose.</small></label>
							<div class="input type-textarea"><textarea class="wysiwyg-simple" id="description" name="description" cols="50" rows="10" class="required"></textarea></div>
						</li>
					</ul>
				</frameset>
			</div>
		</section>
	</div>
	
	<div class="one_full">
		<section class="title"><h4>Event Sponsors</h4></section>
		<section class="item">
			<div class="items align-left">
				<table>
					<thead>
						<tr class="head">
							<th class="name">Name</th>
							<th class="url">URL</th>
							<th>&nbsp;&nbsp;</th>
						</tr>
					</thead>
					<tbody class="sponsors">
<?php foreach($sponsors as $index=>$sponsor):?>
						<tr class="sponsor">
							<td class="name"><div class="input type-text"><input type="text" name="sponsors[<?=$index?>]['name']" value="<?=$sponsor->name?>"/></div></td>
							<td class="url">
								<div class="input type-text"><input type="text" name="sponsors[<?=$index?>]['url']" value="<?=$sponsor->url?>" /> <a href="" target="_blank" class="btn green testlink"><span>Test</span></a></div>
							</td>
							<td class="actions">
								<input type="hidden" value="sponsors[<?=$index?>]['id']" value="<?=$sponsor->id?>"/>
								<input type="hidden" value="sponsors[<?=$index?>]['order']" value="<?=$index?>"/>
								<input type="hidden" value="sponsors[<?=$index?>]['delete']" value="false"/>
								<button class="btn red delete"><span>Delete</span></button>
							</td>
						</tr>
<?php endforeach;?>
					</tbody>
					<tfoot class="sponsors">
						<tr>
							<td class="name">&nbsp;&nbsp;</td>
							<td class="url">&nbsp;&nbsp;</td>
							<td class="actions">
								<button class="btn orange add"><span>Add a Sponsor</span></button>
							</td>
						</tr>						
					</tfoot>
				</table>
			</div>
		</section>
	</div>
	
	<div class="one_full">
		<section class="title"><h4>Event Links</h4></section>
		<section class="item">
			<p>Add links that are associated with your event.</p>
			<div class="items align-left">
				<table>
					<thead>
						<tr class="head">
							<th class="name">Title</th>
							<th class="name">URL</th>
							<th class="url">Type</th>
							<th>&nbsp;&nbsp;</th>
						</tr>
					</thead>
					
					<tbody class="links">
<?php foreach($links as $index=>$link):?>
						<tr class="entry">
							<td class="title">
								<div class="input type-text"><input type="text" name="link[<?=$index?>]['title']" value="<?=$link->title?>"/></div>
							</td>
							<td class="url">
								<div class="input type-text"><input type="text" name="link[<?=$index?>]['url']" value="<?=$link->url?>"/> <a href="javascript:void(0)" target="_blank" class="btn green test"><span>Test</span></a></div>
							</td>
							<td class="type">
								<div class="input type-select">
									<?php echo form_dropdown('link['.$index.'][\'type\']', array(
										'default' => 'Normal Link',
										'facebook' => 'Facebook',
										'eventbrite' => 'Eventbrite',
										'mailchimp' => 'Mail Chimp',
										'googleplus' => 'Google+',
										'twitter' => 'Twitter',
										'pdf' => 'PDF Downlaod',
										'svpply' => 'Svpply',
										'yelp' => 'Yelp',
										'foursquare' => 'Foursquare',
										'gowalla' => 'Gowalla'
									), $link->type);?>
								</div>
								<input type="hidden" value="link[<?=$index?>]['id']" value="<?=$link->id?>"/>
								<input type="hidden" value="link[<?=$index?>]['order']" value="<?=$index?>"/>
								<input type="hidden" value="link[<?=$index?>]['delete']" value="false"/>
							</td>
							
							<td class="actions">
								<button class="btn red delete"><span>Delete</span></button>
							</td>
						</tr>
<?php endforeach;?>
					</tbody>
					<tfoot class="links">
						<tr>
							<td class="title">&nbsp;&nbsp;</td>
							<td class="url">&nbsp;&nbsp;</td>
							<td class="type">&nbsp;&nbsp;</td>
							<td class="actions">
								<button class="btn orange add"><span>Add a Link</span></button>
							</td>
						</tr>						
					</tfoot>
				</table>
			</div>
		</section>
	</div>
<div class="floating-footer">
	<div class="buttons align-left buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','save_exit','cancel') )); ?>
	</div>
</div>
</form>

<script>
(function($){$(document).ready(function(){

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
</script>