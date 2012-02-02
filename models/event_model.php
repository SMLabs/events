<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class event_model extends CI_Model {

	private $tablename = "events";
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	
	function SaveEvent( $data )
	{
		$this->db->set('name', $data['name'] ); 
		$this->db->set('description', $data['description'] ); 
		$this->db->set('sponsors', $data['sponsors'] ); 
		$this->db->set('event_date', Date_SlashFormat_Into24hFormat($data['event_date']) ); 		
		$this->db->set('start_time', TimeAMPM_Into_24hFormatTime($data['start_time']) ); 
		$this->db->set('end_time', TimeAMPM_Into_24hFormatTime($data['end_time']) ); 		
		$this->db->set('facebook_event_url', $data['facebook_event_url'] ); 
		$this->db->set('eventbrite_event_url', $data['eventbrite_event_url'] ); 
		
		$this->db->insert($this->tablename); 
		
		return true;
	}
	
	function UpdateEvent( $data )
	{
		$this->db->set('name', $data['name'] ); 
		$this->db->set('description', $data['description'] ); 
		$this->db->set('sponsors', $data['sponsors'] ); 
		$this->db->set('event_date', Date_SlashFormat_Into24hFormat($data['event_date']) ); 		
		$this->db->set('start_time', TimeAMPM_Into_24hFormatTime($data['start_time']) ); 
		$this->db->set('end_time', TimeAMPM_Into_24hFormatTime($data['end_time']) ); 		
		$this->db->set('facebook_event_url', $data['facebook_event_url'] ); 
		$this->db->set('eventbrite_event_url', $data['eventbrite_event_url'] ); 
		$this->db->set('modified_on', date('Y-m-d') ); 
		
		$this->db->where('id', $data['id']  );
		
		$this->db->update($this->tablename); 
		
		
		return true;	
	}
	
	function DeleteEvent( $event_id )
	{
		$this->db->where('id', $event_id );
		$this->db->delete("events");
		
		return true;
	}

	
	function UpdateEventStatus( $event_id )
	{
		$this->db->where('id',$event_id);
		
		$query=$this->db->get('events');
		  
        $row = $query->result();
		
		$this->db->where('id',$event_id);
		
		if($row[0]->status=='Active')
			$this->db->set('status', "Deactive" );
		else
			$this->db->set('status', "Active" );	 				   
		
		$this->db->update("events");
		
		return true;
	}

	
	function GetEvent_ById( $event_id )
	{
		$this->db->select('*');
		$this->db->from($this->tablename);
		$this->db->where('id', $event_id );
		$query = $this->db->get();
		
		return $query->result();
	}	


	function ManageEvents( )
	{
		$this->db->select('*');
		$this->db->from($this->tablename);
		$this->db->order_by("event_date", "asc"); 
		$query = $this->db->get();
		return  $query->result();
	}	
	

	function FrontendDisplayEvents( )
	{

		$this->db->select('*');
		
		$this->db->from($this->tablename);
		
		$this->db->order_by("event_date", "asc"); 
		
		$this->db->where('status', "Active" );
		
		$query = $this->db->get();
		
		return  $query->result();
	}	
	
	function EventDetailByDate( $date )
	{
		$this->db->select('*');
		
		$this->db->from($this->tablename);
		
		$this->db->order_by("event_date", "asc"); 
		
		$this->db->where('event_date', date("Y-m-d", strtotime($date)) );
		
		$this->db->where('status', "Active" );
		
		$query = $this->db->get();
		
		return  $query->result();
		
	}
	
	
	function EventCalendarData($from=null,$to=null){
		$this->db->select('count(*) as day_count, id, name, event_date, start_time, end_time');
		
		$this->db->from($this->tablename);
		
		$this->db->group_by("event_date");
		
		$this->db->order_by("event_date", "asc"); 
		
		$this->db->where('status', "Active" );
		
		if(isset($from) AND isset($to))
			$this->db->where(array(
				'event_date >'=>date('Y-m-d', strtotime($from)),
				'event_date <'=>date('Y-m-d', strtotime($to))
			));
		
		$query = $this->db->get();
		
		return  $query->result();
	}	
	
	
}