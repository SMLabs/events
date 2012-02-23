<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class event_model extends CI_Model {

	private $details = 'events';
	private $sponsors = 'events_sponsors';
	private $links = 'events_links';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	function insert_event($data)
	{
		// prep dates and times
		$data['event_date']		= Date_SlashFormat_Into24hFormat($data['event_date']);
		$data['start_time']		= TimeAMPM_Into_24hFormatTime($data['start_time']);
		$data['end_time']		= TimeAMPM_Into_24hFormatTime($data['end_time']);
		
		// insert
		if($this->db->insert($this->details,$data)) return $this->db->insert_id();
		
		// bad news
		return false;
	}
	
	function insert_event_sponsor($data,$batch=false)
	{
		
		if(!$batch){
			// single insert
			if($this->db->insert($this->sponsors,$data)) return $this->db->insert_id();
		}else{
			// batch insert
			if($this->db->insert_batch($this->sponsors,$data)) return $this->db->insert_id();
		}
		
		return false;
	}
	
	function insert_event_links($data,$batch=false)
	{
		
		if(!$batch){
			// single insert
			if($this->db->insert($this->sponsors,$data)) return $this->db->insert_id();
		}else{
			// batch insert
			if($this->db->insert_batch($this->sponsors,$data)) return $this->db->insert_id();
		}
		
		return false;
	}
	
	function UpdateEvent( $data)
	{
		$this->db->set('name', $data['name']);
		$this->db->set('description', $data['description']);
		$this->db->set('sponsors', $data['sponsors']);
		$this->db->set('event_date', Date_SlashFormat_Into24hFormat($data['event_date']));
		$this->db->set('start_time', TimeAMPM_Into_24hFormatTime($data['start_time']));
		$this->db->set('end_time', TimeAMPM_Into_24hFormatTime($data['end_time']));
		$this->db->set('facebook_event_url', $data['facebook_event_url']);
		$this->db->set('eventbrite_event_url', $data['eventbrite_event_url']);
		$this->db->set('modified_on', date('Y-m-d'));
		
		$this->db->where('id', $data['id']);
		
		$this->db->update($this->details);
		
		
		return true;	
	}
	
	function DeleteEvent( $event_id)
	{
		$this->db->where('id', $event_id);
		$this->db->delete("events");
		
		return true;
	}

	
	function UpdateEventStatus( $event_id)
	{
		$this->db->where('id',$event_id);
		
		$query=$this->db->get('events');
		  
        $row = $query->result();
		
		$this->db->where('id',$event_id);
		
		if($row[0]->status=='Active')
			$this->db->set('status', "Deactive");
		else
			$this->db->set('status', "Active");	 				   
		
		$this->db->update("events");
		
		return true;
	}

	
	function get_event($id)
	{
		$this->db->select('*');
		$this->db->from($this->details);
		$this->db->where('id', $id);
		return $this->db->get();
	}
	
	
	function get_events($from=false,$till=false,$ord="event_date",$dir="ASC",$offset='0',$limit="50")
	{
		// select my events
		$this->db->select('*, count(id) as total')
			->from($this->details)
			->limit($limit,$offset)
			->order_by($ord,$dir);
		
		// set the date range
		($from!==false) ? $this->db->where('event_date >', $id) : null;
		($till!==false) ? $this->db->where('event_date <', $till) : null;
		
		// get my events
		return $this->db->get();
	}
	

	function ManageEvents()
	{
		$this->db->select('*');
		$this->db->from($this->details);
		$this->db->order_by("event_date", "asc");
		$query = $this->db->get();
		return  $query->result();
	}	
	

	function FrontendDisplayEvents()
	{

		$this->db->select('*');
		
		$this->db->from($this->details);
		
		$this->db->order_by("event_date", "asc");
		
		$this->db->where('status', "Active");
		
		$query = $this->db->get();
		
		return  $query->result();
	}	
	
	function EventDetailByDate( $date)
	{
		$this->db->select('*');
		
		$this->db->from($this->details);
		
		$this->db->order_by("event_date", "asc");
		
		$this->db->where('event_date', date("Y-m-d", strtotime($date)));
		
		$this->db->where('status', "Active");
		
		$query = $this->db->get();
		
		return  $query->result();
		
	}
	
	
	function EventCalendarData($from=null,$to=null){
		$this->db->select('count(*) as day_count, id, name, event_date, start_time, end_time');
		
		$this->db->from($this->details);
		
		$this->db->group_by("event_date");
		
		$this->db->order_by("event_date", "asc");
		
		$this->db->where('status', "Active");
		
		if(isset($from) AND isset($to))
			$this->db->where(array(
				'event_date >'=>date('Y-m-d', strtotime($from)),
				'event_date <'=>date('Y-m-d', strtotime($to))
			));
		
		$query = $this->db->get();
		
		return  $query->result();
	}	
	
	
}