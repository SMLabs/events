<?php
class Admin extends Admin_Controller {

	private $user_id = "";
	
	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'events';
	
	/**
	 * Constructor method
	 *
	 * @return void
	 */
	function __construct(){
	
		// Call the parent's constructor method
		parent::__construct();
		
		// load the module's config file
		$this->load->config('config');
		
		// load Language file
		$this->lang->load('event');
		
		// Get the user ID, if it exists
		$user = $this->ion_auth->get_user();
		
		if(!empty($user)){
			$this->user_id = $user->id;	
			$this->config->set_item('user_id', $this->user_id );
		}
	}
	
	
	function index(){
		
		if($this->user_id != ""  ) {
			$data["eventData"] = $this->event_model->ManageEvents();
			
			$this->template
				->append_metadata( css('event.css', $this->config->item('module_name')))
				->build('admin/main', $data);
		}else {
			$this->template->build('admin/access_failed');
		}
	}
	
	function create_event(){
		if( $this->user_id != "" ) {
			
			$this->template			
				->append_metadata( css('event.css', $this->config->item('module_name')) )
				->append_metadata( css('jquery-ui-1.8.17.custom/ui-darkness/jquery-ui-1.8.17.custom.css', $this->config->item('module_name')) )
				->append_metadata( css('jquery-ui-1.8.17.custom/jquery-ui-timepicker-addon.css', $this->config->item('module_name')) )
				->append_metadata( js('jquery-ui-1.8.17.custom/jquery-ui-1.8.17.custom.min.js', $this->config->item('module_name')) )
				->append_metadata( js('jquery-ui-1.8.17.custom/jquery-ui-timepicker-addon.js', $this->config->item('module_name')) )
				->append_metadata( js('jquery-ui-1.8.17.custom/jquery-ui-timepicker-addon.js', $this->config->item('module_name')) )
				
				->append_metadata( js('jquery.simpletip-1.3.1.js', $this->config->item('module_name')) )
				
				->build('admin/create');
		
		}else{ 
			$this->template->build('admin/access_failed'); 
		}
	}
	
	function save_event(){
		if( $this->user_id != "" ) {		
			$test_id = $this->event_model->SaveEvent( $_REQUEST ); 
		
			redirect(site_url('admin/' . $this->config->item('module_name')));	
		}else {
			$this->template->build('admin/access_failed');
		}
	}
	
	
	function edit_event( $encrypted_event_id ){
		if( $this->user_id != "" ) {		
		
			$event_id = WsDecrypt( $encrypted_event_id );
					
			$data["event"] = $this->event_model->GetEvent_ById( $event_id ); 
			$data["event"] = $data["event"][0];
			
			$this->template
				->append_metadata( css('event.css', $this->config->item('module_name')) )
				->append_metadata( css('jquery-ui-1.8.17.custom/ui-darkness/jquery-ui-1.8.17.custom.css', $this->config->item('module_name')) )
				->append_metadata( css('jquery-ui-1.8.17.custom/jquery-ui-timepicker-addon.css', $this->config->item('module_name')) )
				->append_metadata( js('jquery-ui-1.8.17.custom/jquery-ui-1.8.17.custom.min.js', $this->config->item('module_name')) )
				->append_metadata( js('jquery-ui-1.8.17.custom/jquery-ui-timepicker-addon.js', $this->config->item('module_name')) )
				->append_metadata( js('jquery.validate.js', $this->config->item('dch_event_module_name')) )
				->build('admin/edit', $data);
		}else {
			$this->template->build('admin/access_failed');
		}
	}
	
	function update_event(){
		if( $this->user_id != "" ) {		
			$action = $this->event_model->UpdateEvent( $_REQUEST ); 
		
			redirect(site_url('admin/' . $this->config->item('module_name')));	
		}else {
			$this->template->build('admin/access_failed');
		}
	}
	
	function delete_event( $encrypted_event_id ){
		if( $this->user_id != "" ) {		
			
			$event_id = WsDecrypt( $encrypted_event_id );			
			
			$this->event_model->DeleteEvent( $event_id ); 
			
			redirect(site_url('admin/' . $this->config->item('module_name')));	
			
			
		}else {
			$this->template->build('admin/access_failed');
		}
	}
	
	function update_event_status( $encrypted_event_id ){
		if($this->user_id!="")
		{
			$event_id = WsDecrypt( $encrypted_event_id );
			
			$this->event_model->UpdateEventStatus( $event_id ); 
			
			redirect(site_url('admin/' . $this->config->item('module_name')));	
					
		}
	}
}