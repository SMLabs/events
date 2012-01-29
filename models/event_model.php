<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class event_model extends CI_Model {


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
		
		$this->db->insert('dch_events'); 
		
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
		
		$this->db->update('dch_events'); 
		
		
		return true;	
	}
	
	function DeleteEvent( $event_id )
	{
		$this->db->where('id', $event_id );
		$this->db->delete("dch_events");
		
		return true;
	}

	
	function UpdateEventStatus( $event_id )
	{
		$this->db->where('id',$event_id);
		
		$query=$this->db->get('dch_events');
		  
        $row = $query->result();
		
		$this->db->where('id',$event_id);
		
		if($row[0]->status=='Active')
			$this->db->set('status', "Deactive" );
		else
			$this->db->set('status', "Active" );	 				   
		
		$this->db->update("dch_events");
		
		return true;
	}

	
	function GetEventScheduler( $event_id )
	{
		$this->db->select('*');
		$this->db->from('dch_event_scheduler');
		$this->db->where('event_id', $event_id );
		$this->db->order_by("event_date", "asc"); 
		$query = $this->db->get();
		
		return $query->result();
			
	}
	
	function GetEventDaysTime( $event_id, $event_date )
	{
		$this->db->select('*');
		$this->db->from('dch_event_scheduler');
		$this->db->where('event_id', $event_id );
		$this->db->where('event_date', $event_date );
		$query = $this->db->get();
		
		return $query->result();
		
	}
	
	
	function GetEvent_ById( $event_id )
	{
		$this->db->select('*');
		$this->db->from('dch_events');
		$this->db->where('id', $event_id );
		$query = $this->db->get();
		
		return $query->result();
	}	


	function ManageEvents( )
	{
		$this->db->select('*');
		$this->db->from('dch_events');
		$this->db->order_by("event_date", "asc"); 
		$query = $this->db->get();
		return  $query->result();
	}	
	

	function FrontendDisplayEvents( )
	{

		$this->db->select('*');
		
		$this->db->from('dch_events');
		
		$this->db->order_by("event_date", "asc"); 
		
		$this->db->where('status', "Active" );
		
		$query = $this->db->get();
		
		return  $query->result();
	}	
	
	function EventCalendarData( )
	{
		$this->db->select('count(*) as total_event_in_a_day, id, name, event_date, start_time, end_time');
		
		$this->db->from('dch_events');
		
		$this->db->group_by("event_date"); 
		
		$this->db->order_by("event_date", "asc"); 
		
		$this->db->where('status', "Active" );
		
		$query = $this->db->get();
		
		return  $query->result();
	}	
	
	
}