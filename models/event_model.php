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
    
	/////////////////////
	//  Event Methods  //
	/////////////////////
	
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
	
	function update_event($data)
	{
		$this->db->set('name', $data['name'])
			->set('description', $data['description'])
			->set('event_date', Date_SlashFormat_Into24hFormat($data['event_date']))
			->set('start_time', TimeAMPM_Into_24hFormatTime($data['start_time']))
			->set('end_time', TimeAMPM_Into_24hFormatTime($data['end_time']))
			->set('modified_on', date('Y-m-d'));
		
		$this->db->where('id', $data['id']);
		
		$this->db->update($this->details);
		
		
		return true;	
	}

	function delete_event($event_id)
	{
		// delete sponsors
		$this->db->where('event_id',$event_id)
			->delete($this->sponsors);
			
		// delete links
		$this->db->where('event_id',$event_id)
			->delete($this->links);
		
		// delete event
		$this->db->where('id', $event_id)
			->delete($this->details);
		
		return true;
	}
	
	function get_event($event_id)
	{
		$this->db->select('*');
		$this->db->from($this->details);
		$this->db->where('id', $event_id);
		
		return $this->db->get();
	}
	
	
	function get_events($from=null,$till=null,$ord="event_date",$dir="ASC",$offset='0',$limit="9999")
	{
		// select my events
		$this->db->select('*')
			->from($this->details)
			->where(array('status'=>'active'))
			->limit($limit,$offset)
			->order_by($ord,$dir);
		
		// set the date range
		($from!==null) ? $this->db->where('event_date >', $from) : null;
		($till!==null) ? $this->db->where('event_date <', $till) : null;
		
		// get my events
		return $this->db->get();
	}
	
	function set_event($id,$field,$value){
		if($this->db->where('id',$id)->set($field,$value)->update($this->details)) return true;
		return false;
	}
	
	
	/////////////////////
	// Sponsor Methods //
	/////////////////////
	
	function insert_sponsor($data,$batch=false)
	{
		
		if(!$batch){
			// single insert
			if($this->db->insert($this->sponsors,$data)) return $this->db->insert_id();
		}else{		
			// batch insert
			if($this->db->insert_batch($this->sponsors,$data)) return true;
		}
		
		return false;
	}
	
	function update_sponsor($data)
	{
		$this->db->set('name', $data['name'])
			->set('url', $data['url'])
			->set('order', $data['order'])
			->set('modified_on', date('Y-m-d'));
		
		$this->db->where('id', $data['id']);
		
		$this->db->update($this->sponsors);
		
		return true;	
	}
	
	function delete_sponsor($id)
	{
		if($this->db->where('id',$id)->delete($this->sponsors)) return true;
		return false;
	}
	
	function get_sponsors($event_id,$order_by='order',$dir='ASC')
	{
		$this->db->select('*')
			->from($this->sponsors)
			->where('event_id', $event_id)
			->order_by($order_by,$dir);
		
		return $this->db->get();
	}
	
	/////////////////////
	//  Links Methods  //
	/////////////////////
	
	function insert_link($data,$batch=false)
	{
		
		if(!$batch){
			// single insert
			if($this->db->insert($this->links,$data)) return $this->db->insert_id();
		}else{
			// batch insert
			if($this->db->insert_batch($this->links,$data)) return $this->db->insert_id();
		}
		
		return false;
	}
	
	function update_link($data)
	{
		$this->db->set('text', $data['text'])
			->set('url', $data['url'])
			->set('type', $data['type'])
			->set('order', $data['order'])
			->set('modified_on', date('Y-m-d'));
		
		$this->db->where('id', $data['id']);
		
		$this->db->update($this->links);
		
		return true;
	}
	
	function delete_link($id)
	{
		if($this->db->where('id',$id)->delete($this->links)) return true;
		return false;
	}
	
	function get_links($event_id,$order_by='order',$dir='ASC')
	{
		$this->db->select('*')
			->from($this->links)
			->where('event_id', $event_id)
			->order_by($order_by,$dir);
		
		return $this->db->get();
	}
	
	///////////////////
	// Other Methods //
	///////////////////
	
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
	
	function UpdateEventStatus( $event_id)
	{
		$this->db->where('id',$event_id);
		
		$query=$this->db->get('events');
		  
        $row = $query->result();
		
		$this->db->where('id',$event_id);
		
		if($row[0]->status=='active')
			$this->db->set('status', "inactive");
		else
			$this->db->set('status', "active");	 				   
		
		$this->db->update($this->details);
		
		return true;
	}

	function ManageEvents()
	{
		$this->db->select('*');
		$this->db->from($this->details);
		$this->db->order_by("event_date", "asc");
		$query = $this->db->get();
		return  $query->result();
	}
	
	
}