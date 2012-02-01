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
	
	
	public function calendar( $month = "", $year="" ) {
			
		$data["new_month"] = $month;
		$data["new_year"] = $year;
		
		$data["eventData"] = $this->event_model->EventCalendarData();
		
		foreach( $data["eventData"] as $keys => $event )
		{
			$data['events'][$keys]['id'] = $event->id;	
			$data['events'][$keys]['title'] = "AGENDA";
			$data['events'][$keys]['start'] = date("Y-m-d", strtotime($event->event_date));	
			$data['events'][$keys]['url'] = "";	
			$data['events'][$keys]['total_event_in_a_day'] = $event->total_event_in_a_day;	
			$data['events'][$keys]['Intday'] = date("d", strtotime($event->event_date));
			$data['events'][$keys]['event_date'] = date("Y-n-j", strtotime($event->event_date));			
		}
		
		$this->template
			->append_metadata( css('event.css', $this->config->item('module_name')) )
			->append_metadata( js('jquery-ui-1.8.17.custom/jquery-1.7.1.min.js', $this->config->item('module_name')) )
			->append_metadata( js('calendar.js', $this->config->item('module_name')) )
			->build($this->config->item('module_name') . '/calendar', $data);		
	}
	
	
	public function event_calendar_data()
	{
		$data["eventData"] = $this->event_model->EventCalendarData();
		
		foreach( $data["eventData"] as $keys => $event )
		{
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
	
	function detail_by_event_date()
	{
		
		extract($_POST);
		$content= '';
		
		$eventData = $this->event_model->EventDetailByDate( $event_date );
			
		if( !empty( $eventData ) ) {
			foreach( $eventData as $keys => $event ) { 	
	$content.='<div class="postings">
					<div class="a_date">
						<div class="a_date_text">
							<div class="day">'. date('l',strtotime($event->event_date)).'</div>
							<div class="month">'.date('F d,Y',strtotime($event->event_date)).'</div>
							<div class="time">'.Time24hFormat_Into_AMPMTime($event->start_time).' - '. Time24hFormat_Into_AMPMTime($event->end_time).'</div>
						</div>
					</div>
						
					<article class="a_detail">
						<header><h2 class="posting_hdr">'.$event->name.' </h2></header>
						<p>
							'.$event->description .' 
							<div class="a_detail_text01">Sponsors</div>
							<div class="a_detail_text02">'.$event->sponsors.'</div>
							<div class="a_detail_text01">View Event on:</div>
							<div class="a_detail_btn">
								<a href="'.CheckHTTP_InURL($event->eventbrite_event_url).'"><div class="orange_btn">Eventbrite</div></a>
								<a href="'.CheckHTTP_InURL($event->facebook_event_url).'"><div class="facebook_btn">facebook</div></a>
							</div>
						</p>
					</article>
            	</div>';
			} 
		}
		
		echo $content; 
		exit();
	}
}