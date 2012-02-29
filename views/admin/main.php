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
	<table>
	    <tr>
	        <th>Name of Event</th>
	        <th>Description</th>
	        <th>Date</th>
	        <th>Start Time</th>
	        <th>End Time</th>
	        <th>&nbsp;&nbsp;</th>
	    </tr>
	<?php 
	if( !empty( $events ) ) {
	    foreach( $events as $keys => $event ) {
	?>
	    <tr class="<?=$event->status?>">
	        <td><?php echo WsStringFormat($event->name,0,20); ?></td>
	        <td align="center"><a class="tip" href="javascript:void(0)" title="<?=$event->description?>"><?php echo WsStringFormat($event->description,0,20);?></a></td>
	        <td align="center"><?php echo Date_24hFormat_Into_SlashFormat($event->event_date) ;?></td>
	        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->start_time) ;?></td>
	        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->end_time) ;?></td>
	        <td class="actions">
				
				<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/edit/'.$event->id),'Edit',array('class' => 'edit btn green')) ?>&nbsp;
				
				<a href="javascript: void(0);" <?php echo '" onclick="javascript:if(confirm(\'Are you sure you want to delete this event.\')){ document.location.href = \''.site_url('admin/'.$this->config->item('module_name').'/delete/'.$event->id).'\';}else{return false;}" ' ?> title="Delete Test" class="btn red delete">Delete</a>&nbsp;
				
				<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/set_status/'.$event->id.'/'.($event->status=='active' ? 'inactive' : 'active')),$status_label[$event->status],array('class' => 'btn '.$status_style[$event->status].' edit')) ?>
				
	        </td>
	    </tr>
	
	<?php 
	    } 
	} else {
	?>
	No record found
	<?php } ?>
	</table>
</section>