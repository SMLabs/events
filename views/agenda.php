<h1>
	Calender <strong>Agenda View</strong>
	<div class="cal-options">
		<a class="cal-button" href="<?php echo site_url($this->config->item('module_name') . '/calendar'); ?>"><span>Calendar View</span></a>
	</div>
</h1>

<?=$this->load->view($this->config->item('module_name').'/details', array("events"=>$events),true);?>