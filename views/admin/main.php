<?php

	$status_label = array(
		'inactive'=>'Activate',
		'active'=>'Deactivate'
	);
	
	$status_style = array(
		'inactive'=>'gray',
		'active'=>'orange'
	);
	
?>

<section class="title"><h4>Events</h4></section>
<section class="item">

	<div class="tabs ui-tabs ui-widget ui-widget-content ui-corner-all">

		<ul class="tab-menu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#events-upcoming"><span>Upcoming Events</span></a></li>
			<li class="ui-state-default ui-corner-top"><a href="#events-past"><span>Past Events</span></a></li>
			<li class="ui-state-default ui-corner-top"><a href="#events-facebook"><span>Upcoming Third Party Events</span></a></li>
			<li class="ui-state-default ui-corner-top"><a href="#events-facebook-past"><span>Past Third Party Events</span></a></li>
		</ul>
		
		<!-- Present tab -->
		<div class="form_inputs ui-tabs-panel ui-widget-content ui-corner-bottom" id="events-upcoming">		
			<fieldset>
<?php if( !empty( $events ) ):?>
				<table>
				    <tr>
				        <th>#ID</th>
				        <th>FB</th>
				        <th>Name</th>
				        <th>Date</th>
				        <th>Start Time</th>
				        <th>End Time</th>
				        <th>&nbsp;&nbsp;</th>
				    </tr>
<? foreach( $events as $keys => $event ):?>
				    <tr class="<?=$event->status?>">
				        <td class="col_id" align="center"><?=$event->id ?></td>
				        <td class="col_id" align="center"><?= ($event->fbpage_id!=null)? image('fb_icon.png',$this->module): null?></td>
				        <td align="center"><a href='<?=site_url($this->module.'/details/'.$event->id)?>' target="_blank"><?=$event->name?></a></td>
				        <td align="center"><?php echo Date_24hFormat_Into_SlashFormat($event->event_date) ;?></td>
				        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->start_time) ;?></td>
				        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->end_time) ;?></td>
				        <td class="actions">
							
							<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/edit/'.$event->id),'Edit',array('class' => 'edit btn green')) ?>&nbsp;
							
							<a href="javascript: void(0);" <?php echo '" onclick="javascript:if(confirm(\'Are you sure you want to delete this event.\')){ document.location.href = \''.site_url('admin/'.$this->config->item('module_name').'/delete/'.$event->id).'\';}else{return false;}" ' ?> title="Delete Test" class="btn red delete">Delete</a>&nbsp;
							
							<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/set_status/'.$event->id.'/'.($event->status=='active' ? 'inactive' : 'active')),$status_label[$event->status],array('class' => 'btn '.$status_style[$event->status].' edit')) ?>
							
				        </td>
				    </tr>
<?php endforeach;?> 
			</table>
<?php else:?>
			<h2>No upcoming events.</h2>
<?php endif;?>
				</table>
			</fieldset>
		</div>

		<!-- Past tab -->
		<div class="form_inputs ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="events-past">
			<fieldset>

<?php if( !empty( $pastevents ) ):?>
			<table>
			    <tr>
			        <th>#ID</th>
			        <th>FB</th>
			        <th>Name</th>
			        <th>Date</th>
			        <th>Start Time</th>
			        <th>End Time</th>
			        <th>&nbsp;&nbsp;</th>
			    </tr>
<? foreach( $pastevents as $keys => $event ):?>
			    <tr class="<?=$event->status?>">
			        <td class="col_id" align="center"><?=$event->id ?></td>
			        <td class="col_id" align="center"><?= ($event->fbpage_id!=null)? image('fb_icon.png',$this->module): null?></td>
			        <td align="center"><a href='<?=site_url($this->module.'/details/'.$event->id)?>' target="_blank"><?=$event->name?></a></td>
			        <td align="center"><?php echo Date_24hFormat_Into_SlashFormat($event->event_date) ;?></td>
			        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->start_time) ;?></td>
			        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->end_time) ;?></td>
			        <td class="actions">
						
						<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/edit/'.$event->id),'Edit',array('class' => 'edit btn green')) ?>&nbsp;
						
						<a href="javascript: void(0);" <?php echo '" onclick="javascript:if(confirm(\'Are you sure you want to delete this event.\')){ document.location.href = \''.site_url('admin/'.$this->config->item('module_name').'/delete/'.$event->id).'\';}else{return false;}" ' ?> title="Delete Test" class="btn red delete">Delete</a>&nbsp;
						
						<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/set_status/'.$event->id.'/'.($event->status=='active' ? 'inactive' : 'active')),$status_label[$event->status],array('class' => 'btn '.$status_style[$event->status].' edit')) ?>
						
			        </td>
			    </tr>
<?php endforeach;?> 
			</table>
<?php else:?>
			<h2>No past events.</h2>
<?php endif;?>
			</fieldset>
		</div>

		<!-- Facebook tab -->
		<div class="form_inputs ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="events-facebook">
			<fieldset>
<?php if( !empty( $fbevents ) ):?>
			<table>
			    <tr>
			        <th>#ID</th>
			        <th>FB</th>
			        <th>Name</th>
			        <th>Date</th>
			        <th>Start Time</th>
			        <th>End Time</th>
			        <th>&nbsp;&nbsp;</th>
			    </tr>
<? foreach( $fbevents as $keys => $event ):?>
			    <tr class="<?=$event->status?>">
			        <td class="col_id" align="center"><?=$event->id ?></td>
			        <td class="col_id" align="center"><?= ($event->fbpage_id!=null)? image('fb_icon.png',$this->module): null?></td>
			        <td align="center"><a href='<?=site_url($this->module.'/details/'.$event->id)?>' target="_blank"><?=$event->name?></a></td>
			        <td align="center"><?php echo Date_24hFormat_Into_SlashFormat($event->event_date) ;?></td>
			        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->start_time) ;?></td>
			        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->end_time) ;?></td>
			        <td class="actions">
						
						<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/edit/'.$event->id),'Edit',array('class' => 'edit btn green')) ?>&nbsp;
						
						<a href="javascript: void(0);" <?php echo '" onclick="javascript:if(confirm(\'Are you sure you want to delete this event.\')){ document.location.href = \''.site_url('admin/'.$this->config->item('module_name').'/delete/'.$event->id).'\';}else{return false;}" ' ?> title="Delete Test" class="btn red delete">Delete</a>&nbsp;
						
						<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/set_status/'.$event->id.'/'.($event->status=='active' ? 'inactive' : 'active')),$status_label[$event->status],array('class' => 'btn '.$status_style[$event->status].' edit')) ?>
						
			        </td>
			    </tr>
<?php endforeach;?> 
			</table>
<?php else:?>
			<h2>No upcoming third party events.</h2>
<?php endif;?>
			</fieldset>
		</div>

		<!-- Past Facebook tab -->
		<div class="form_inputs ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="events-facebook-past">
			<fieldset>
<?php if( !empty( $fbpastevents ) ):?>
			<table>
			    <tr>
			        <th>#ID</th>
			        <th>FB</th>
			        <th>Name</th>
			        <th>Date</th>
			        <th>Start Time</th>
			        <th>End Time</th>
			        <th>&nbsp;&nbsp;</th>
			    </tr>
<? foreach( $fbpastevents as $keys => $event ):?>
			    <tr class="<?=$event->status?>">
			        <td class="col_id" align="center"><?=$event->id ?></td>
			        <td class="col_id" align="center"><?= ($event->fbpage_id!=null)? image('fb_icon.png',$this->module): null?></td>
			        <td align="center"><a href='<?=site_url($this->module.'/details/'.$event->id)?>' target="_blank"><?=$event->name?></a></td>
			        <td align="center"><?php echo Date_24hFormat_Into_SlashFormat($event->event_date) ;?></td>
			        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->start_time) ;?></td>
			        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->end_time) ;?></td>
			        <td class="actions">
						
						<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/edit/'.$event->id),'Edit',array('class' => 'edit btn green')) ?>&nbsp;
						
						<a href="javascript: void(0);" <?php echo '" onclick="javascript:if(confirm(\'Are you sure you want to delete this event.\')){ document.location.href = \''.site_url('admin/'.$this->config->item('module_name').'/delete/'.$event->id).'\';}else{return false;}" ' ?> title="Delete Test" class="btn red delete">Delete</a>&nbsp;
						
						<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/set_status/'.$event->id.'/'.($event->status=='active' ? 'inactive' : 'active')),$status_label[$event->status],array('class' => 'btn '.$status_style[$event->status].' edit')) ?>
						
			        </td>
			    </tr>
<?php endforeach;?> 
			</table>
<?php else:?>
			<h2>No past third party events.</h2>
<?php endif;?>
			</fieldset>
		</div>

	</div>
</section>