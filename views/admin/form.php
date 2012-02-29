<?php 
 // Nothing to see here move along! 
?>

<form action="<?php echo site_url('admin/'.$this->config->item('module_name').'/save/'.(isset($event->id) ? $event->id : null))?>" method="post" name="frmCreate" id="frmCreate" >


	<section class="title"><h4>Event Details</h4></section>
	<section class="item">
		<div class="form_inputs ui-tabs-panel ui-corner-bottom">
			<ul class="one_half">
				<li>
					<label>Title <small>The title of the event.</small></label>
					<div class="input type-text"><input type="text" name="name" id="name"  class="required" value="<?=$event->name?>" /></div>
				</li>
				<!-- this stuff doesn't have front-end integration -->
				<!-- 
				<li>
					<label for="contact">Contact <small>An email address that can be used as a contact.</small></label>
					<div class="input type-text"><input type="text" id="contact" name="contact" value="" /></div>
				</li>
				<li>
					<label for="location">Location <small>The physical address of the event.</small></label>
					<div class="input type-text"><input type="text" id="location" name="location" value="" /></div>
				</li>
				-->
			</ul>
			<ul class="one_half">
				<li>
					<label for="event_date">Date <small>The date this event will occur.</small></label>
					<div class="input type-text"><input type="text" id="event_date" name="event_date" value="<?=DateTime_24hFormat_Into_AMPM_Date_SlashFormat($event->event_date)?>" class="required" /></div>
				</li>
				
				<li>
					<label for="start_time">Start Time <small>The time at which your event begins.</small></label>
					<div class="input type-text"><input type="text" id="start_time" name="start_time" value="<?=Time24hFormat_Into_AMPMTime($event->start_time)?>" /></div>     
				</li>

				<li>
					<label for="end_time">End Time <small>The time at which your event ends and people should start leaving.</small></label>
					<div class="input type-text"><input type="text" id="end_time" name="end_time" value="<?=Time24hFormat_Into_AMPMTime($event->end_time)?>" /></div>
				</li>
			</ul>
		</div>
	</section>
	
	<section class="title"><h4>Event Description</h4></section>
	<section class="item">
		<div class="form_inputs ui-tabs-panel ui-corner-bottom">
			<ul>
				<li>
					<textarea class="wysiwyg-simple" id="description" name="description" cols="50" rows="10"><?=$event->description?></textarea>
				</li>
			</ul>
		</div>
	</section>
	
	<section class="title"><h4>Event Sponsors</h4></section>
	<section class="item">
		<p>Event sponsors and their corresponding website, facebook fanpage or other link.</p>
		<div class="">
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
						<td class="name"><div class="input type-text"><input type="text" name="sponsors[<?=$index?>][name]" value="<?=$sponsor->name?>"/></div></td>
						<td class="url">
							<div class="input type-text"><input type="text" name="sponsors[<?=$index?>][url]" value="<?=$sponsor->url?>" /> <a href="" target="_blank" class="btn green testlink"><span>Test</span></a></div>
						</td>
						<td class="actions">
							<input type="hidden" name="sponsors[<?=$index?>][id]" value="<?=$sponsor->id?>"/>
							<input type="hidden" name="sponsors[<?=$index?>][order]" value="<?=$index?>"/>
							<input type="hidden" name="sponsors[<?=$index?>][delete]" value="0"/>
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
	
	<section class="title"><h4>Event Links</h4></section>
	<section class="item">
		<p>Add links to be associated with your event.</p>
		<div class="">
			<table>
				<thead>
					<tr class="head">
						<th class="name">Link Text</th>
						<th class="name">URL</th>
						<th class="url">Type</th>
						<th>&nbsp;&nbsp;</th>
					</tr>
				</thead>
				
				<tbody class="links">
<?php foreach($links as $index=>$link):?>
					<tr class="link">
						<td class="title">
							<div class="input type-text"><input type="text" name="links[<?=$index?>][text]" value="<?=$link->text?>"/></div>
						</td>
						<td class="url">
							<div class="input type-text"><input type="text" name="links[<?=$index?>][url]" value="<?=$link->url?>"/> <a href="javascript:void(0)" target="_blank" class="btn green test"><span>Test</span></a></div>
						</td>
						<td class="type">
							<div class="input type-select">
								<?php echo form_dropdown('links['.$index.'][type]', array(
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
							<input type="hidden" name="links[<?=$index?>][id]" value="<?=$link->id?>"/>
							<input type="hidden" name="links[<?=$index?>][order]" value="<?=$index?>"/>
							<input type="hidden" name="links[<?=$index?>][delete]" value="0"/>
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
<div class="floating-footer">
	<div class="buttons align-left buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save','save_exit','cancel') )); ?>
	</div>
</div>
</form>