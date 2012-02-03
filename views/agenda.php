<h1>
Calender <strong>Agenda View</strong>
<div class="cal-options">
	<a class="cal-button" href="<?php echo site_url($this->config->item('module_name') . '/calendar'); ?>"><span>Calendar View</span></a>
</div>
</h1>
<?php if( !empty( $eventData ) ):?>
<?php 	foreach( $eventData as $keys => $event ):?>
<?=$this->load->view($this->config->item('module_name').'/details', array("events"=>array($event)),true);?>
<?php 	endforeach;?>
<?php endif;?>