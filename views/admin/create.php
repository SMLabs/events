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

<style type="text/css">
* { font-family: Verdana; font-size: 96%; }
label { 
	width: 14em; 
	cursor:default;
	font-size:12px;
	font-weight:normal;
	float:left;
}

input.error{ border:1px solid #F30; }
label.error { float:right ; color: red; padding-left: .5em; vertical-align: top; background:none; font-size:0px;}
p { clear: both; }
.submit { margin-left: 12em; }
em { font-weight: bold; padding-right: 1em; vertical-align: top; }

select {
	min-width:90px;
	visibility:visible;
	}
input {
	width:200px;
	position:relative;
	top:-12px;	

}

</style>

<form action="<?php echo site_url('admin/'.$this->config->item('module_name').'/save/'); ?>" method="post" name="frmCreate" id="frmCreate" >
	
	<div> <span style="font-size:16px; font-weight:bold;">Add New Event</span><br />
    <div style="padding:20px;">
        <div>
            <label>Name:</label>&nbsp;
            <input type="text" name="name" id="name"  class="required"   />
        </div>
        
        <div>
			<label for="event_date">Date</label>&nbsp;
			<input type="text" id="event_date" name="event_date" value="" class="required" />
       </div>
       
       <div>         
			<label for="start_time">Start Time</label>&nbsp;
			<input type="text" id="start_time" name="start_time" value="" class="required"  />        
       </div> 
       
       <div>         
			<label for="end_time">End Time</label>&nbsp;
			<input type="text" id="end_time" name="end_time" value="" class="required"  />        
        </div> 
        
        <div><label>Sponsors:</label>&nbsp;
            <input type="text" name="sponsors" id="sponsors"  class=""  />
    	</div>
        
		<div>
            <label>URL for Facebook event:</label>&nbsp;
            <input type="text" name="facebook_event_url" id="facebook_event_url"  class=""  />
    	</div>
        
		<div>
            <label>URL for Eventbrite event:</label>&nbsp;
            <input type="text" name="eventbrite_event_url" id="eventbrite_event_url"  class=""  />
    	</div>
        
		<div>
            <label>Description:</label><br /><br />
            <textarea id="description" name="description" cols="50" rows="2" class="required"></textarea>
    	</div>
        

    </div>
    
	<div class="buttons align-left">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
	</div>
   </div> 
</form>