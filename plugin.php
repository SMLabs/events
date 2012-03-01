<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Events Plugin
 *
 * Create links and whatnot.
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Event extends Plugin
{
	/**
	 * Get a list of events
	 *
	 * @param timestamp $from : The date to start from
	 * @param timestamp $to : The date to go till
	 * @param int $limit : number to limit results to
	 * @return string
	 */
	public function get(){
		($this->attribute('from')) ? $this->db->where('events.event_date >', date('Y-m-d',(is_numeric($this->attribute('from')))?$this->attribute('from'):strtotime($this->attribute('from')))) : null;
		($this->attribute('to')) ? $this->db->where('events.event_date <', $this->attribute('to')) : null;
		($this->attribute('limit')) ? $this->db->limit($this->attribute('limit')): null;
		$result = $this->db->where('status','Active')
			->order_by('event_date')
			->order_by('start_time')
			->get('events')
			->result_array();
		
		foreach($result as $row){
			$data[]=array(
				'id'=>$row['id'],
				'name'=>$row['name'],
				'timestamp'=>strtotime($row['event_date']),
				'date'=>$row['event_date'],
				'description'=>$row['description'],
				'starttime'=>$row['start_time'],
				'endtime'=>$row['end_time']
			);
		}
		
		return $data;
	}
}

/* End of file plugin.php */