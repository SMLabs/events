<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->config->set_item('module_name', "event" );
	}
	
	/**
	 * Index method
	 *
	 * @access public
	 * @return void
	 */
	public function index(){
	/*	$data["eventData"] = $this->event_model->FrontendDisplayEvents();
		//print_r($data["eventData"]); exit;
		$this->template->build( $this->config->item('module_name') . '/agenda', $data);*/
		redirect(site_url($this->config->item('module_name') . '/agenda'));
	}
	
	public function agenda(){
		$data["eventData"] = $this->event_model->FrontendDisplayEvents();
		$this->template->build( $this->config->item('module_name') . '/agenda', $data);
	}
	
	
	public function calendar(){
			
		$this->template
			->append_metadata( css('event.css', $this->config->item('module_name')) )
			->append_metadata( css('fullcalendar/cupertino/theme.css', $this->config->item('module_name')) )
			->append_metadata( css('fullcalendar/fullcalendar.css', $this->config->item('module_name')) )			
			//->append_metadata( css('fullcalendar/fullcalendar.print.css', $this->config->item('module_name')) )						
			
			->append_metadata( js('jquery-ui-1.8.17.custom/jquery-1.7.1.min.js', $this->config->item('module_name')) )
			->append_metadata( js('jquery-ui-1.8.17.custom/jquery-ui-1.8.17.custom.min.js', $this->config->item('module_name')) )
			->append_metadata( js('fullcalendar/fullcalendar.js', $this->config->item('module_name')) )			
			
			->build($this->config->item('module_name') . '/calendar');
	}
	
	public function event_calendar_data()
	{
		$data["eventData"] = $this->event_model->EventCalendarData();
		///print_r($data["eventData"]); exit;
		foreach( $data["eventData"] as $keys => $event )
		{
			$data['calendar'][$keys]['id'] = $event->id;	
			$data['calendar'][$keys]['title'] = "AGENDA";
			$data['calendar'][$keys]['start'] = date("Y-m-d", strtotime($event->event_date));	
			$data['calendar'][$keys]['url'] = "";	
			$data['calendar'][$keys]['total_event_in_a_day'] = $event->total_event_in_a_day;	
			$data['calendar'][$keys]['Intday'] = date("d", strtotime($event->event_date));		
		}
		
		echo json_encode($data["calendar"]);
		
	}

}