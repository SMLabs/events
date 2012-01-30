<script type="text/javascript">
	
	(function($){
		$(window).ready(function(){
			$('.tip').simpletip({
				
			});
		});
	})(jQuery)

</script>

<section class="title"><h4>Events</h4></section>
<section class="item">
	<table>
	    <tr>
	        <th>Name of Event</th>
	        <th>Description</th>
	        <th>Date</th>
	        <th>Start Time</th>
	        <th>End Time</th>
	        <th>Sponsors</th>
	        <th>Facebook event URL</th>
	        <th>Eventbrite event URL</th>
	        <th>Action</th>
	    </tr>
	<?php 
	if( !empty( $eventData ) ) {
	    foreach( $eventData as $keys => $event ) { 
			
			if( $event->status == "Active")
			{
				$status_link_label = "Deactive";
				$status_label = "Active";
			}
			else
			{
				$status_link_label = "Active";	
				$status_label = "Deactive";
			}
				
	?>
	    <tr>
	        <td><?php echo WsStringFormat($event->name,0,20); ?></td>
	        <td align="center"><a class="tip" href="javascript:void(0)" title="<?=$event->description?>"><?php echo WsStringFormat($event->description,0,20);?></a></td>
	        <td align="center"><?php echo Date_24hFormat_Into_SlashFormat($event->event_date) ;?></td>
	        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->start_time) ;?></td>
	        <td align="center"><?php echo Time24hFormat_Into_AMPMTime($event->end_time) ;?></td>
	        <td align="center"><?php echo WsStringFormat($event->sponsors,0,20) ;?></td>
	        <td align="center"><?php echo WsStringFormat($event->facebook_event_url,0,20) ;?></td>
	        <td align="center"><?php echo WsStringFormat($event->eventbrite_event_url,0,20) ;?></td>
	        <td align="center">
	            <?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/edit/'. WsEncrypt( $event->id )),'Edit',array('class' => 'edit btn green')) ?>&nbsp;<a href="javascript: void(0);" <?php echo '" onclick="javascript:if(confirm(\'Are you sure you want to delete this event.\')){ document.location.href = \''.site_url('admin/'.$this->config->item('module_name').'/delete/'. WsEncrypt( $event->id )).'\';}else{return false;}" ' ?> title="Delete Test" class="confirm btn red delete">Delete</a>&nbsp;<?php echo anchor(site_url('admin/'.$this->config->item('module_name').'/update_status/'. WsEncrypt( $event->id )),$status_link_label,array('class' => 'btn orange edit')) ?>
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