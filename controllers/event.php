<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event extends Public_Controller
{
	
	public function __construct(){
		parent::__construct();
		$this->config->set_item('module_name', "event" );	
		$this->template->set('section','Events');
	}
	
	/**
	 * Index method
	 *
	 * @access public
	 * @return void
	 */
	public function index(){
		redirect(site_url($this->config->item('module_name') . '/agenda'));
	}
	
	public function agenda(){
		$events = (array)$this->event_model->get_events(date('Y-m-d',now()),null,'event_date','ASC')->result();
		foreach($events as $event){
			$event->sponsors = (array)$this->event_model->get_sponsors($event->id)->result();
			$event->links = (array)$this->event_model->get_links($event->id)->result();
			$data['events'][] = $event;
		};
		$this->template->build( $this->config->item('module_name') . '/agenda', $data);
	}
	
	
	public function calendar( $month = false, $year = false ){
		
		!$month ? $month =date('m',now()) : null;
		!$year ? $year = date('Y',now()) : null;
		
		$data["new_month"] = $month;
		$data["new_year"] = $year;
		
		$from = date('Y-m-d',strtotime($year.'-'.(int)$month.'-00'));
		$to = date('Y-m-d',strtotime($year.'-'.((int)$month+1).'-01'));
				
		$data["eventData"] = $this->event_model->EventCalendarData($from,$to);
		
		foreach( $data["eventData"] as $keys => $event ){
			// use the 2 diget day value as array index to simplify
			$day = date('j',strtotime($event->event_date));
			
			$data['events'][$day]['id'] = $event->id;
			$data['events'][$day]['start'] = date("Y-m-d", strtotime($event->event_date));
			$data['events'][$day]['day_count'] = $event->day_count;
			$data['events'][$day]['Intday'] = date("d", strtotime($event->event_date));
			$data['events'][$day]['event_date'] = date("Y-n-j", strtotime($event->event_date));
			$data['events'][$day]['url'] = base_url().'event/get_agenda/'.$data['events'][$day]['event_date'];
		}
		
		/* days and weeks vars now ... */
		$data['running_day'] = date('w',mktime(0,0,0,(int)$month,1,$year));
		$data['days_in_month'] = date('t',mktime(0,0,0,$month,1,$year));
		$data['days_in_this_week'] = 1;
		$data['day_counter'] = 0;
		$data['dates_array'] = array();
		
		/* build the view */
		$this->template
			//->append_metadata(css('event.css', $this->config->item('module_name')))
			->append_metadata(css('calendar.css', $this->config->item('module_name')))
			->append_metadata(js('calendar.js', $this->config->item('module_name')))
			->build($this->config->item('module_name') . '/calendar', $data);
	}
	
	public function event_calendar_data(){
		$data["eventData"] = $this->event_model->EventCalendarData();
		
		foreach( $data["eventData"] as $keys => $event ){
			$data['calendar'][$keys]['id'] = $event->id;	
			$data['calendar'][$keys]['title'] = "AGENDA";
			$data['calendar'][$keys]['start'] = date("Y-m-d", strtotime($event->event_date));	
			$data['calendar'][$keys]['url'] = "";	
			$data['calendar'][$keys]['total_event_in_a_day'] = $event->total_event_in_a_day;	
			$data['calendar'][$keys]['Intday'] = date("d", strtotime($event->event_date));
			$data['calendar'][$keys]['event_date'] = date("Y-m-d", strtotime($event->event_date));
		}
				
		echo json_encode($data["calendar"]);
		
	}
	
	public function get_agenda($date){
		$events = (array)$this->event_model->get_events(date("Y-m-d", strtotime($date)),date("Y-m-d", strtotime($date)),'event_date','DESC')->result();
		
		foreach($events as $event){
			$event->sponsors = (array)$this->event_model->get_sponsors($event->id)->result();
			$event->links = (array)$this->event_model->get_links($event->id)->result();
			$data['events'][] = $event;
		};
		
		($this->input->is_ajax_request()) ? $this->load->view($this->config->item('module_name') . '/details', $data) : $this->template->build($this->config->item('module_name') . '/details', $data);
	}
	
	public function details($id){
		
		$data['events'] =  $this->event_model->get_event($id);
	
		($this->input->is_ajax_request()) ? $this->load->view($this->config->item('module_name') . '/details', $data) : $this->template->build($this->config->item('module_name') . '/details', $data);
	}
}