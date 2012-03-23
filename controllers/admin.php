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
		
		// global clientside includes
		$this->template->append_metadata(css('admin.css', $this->module));
		
		// no soup for you!
		( $this->user_id != "" ) ? $this->template->build('admin/access_failed') : null;
	}
	
	
	function index(){
		$data["events"] = $this->event_model->get_events(date('Y-m-d',strtotime('today')),null,'event_date','DESC',null)->result();
		
		$data["pastevents"] = $this->event_model->get_events(null,date('Y-m-d',strtotime('today')),'event_date','DESC',null)->result();
		
		$data["fbevents"] = $this->event_model->get_fbevents(date('Y-m-d',strtotime('today')),null,'status','DESC',null)->result();
		
		$data["fbpastevents"] = $this->event_model->get_fbevents(null,date('Y-m-d',strtotime('today')),'status','DESC',null)->result();
		
		$this->template
			->append_metadata(css('event.css', $this->module))
			->build('admin/main', $data);
	}
	
	function create(){
		
		$data['sponsors'] = array();
		$data['links'] = array();
		$this->template
			->append_metadata( css('event.css', $this->module) )
			->append_metadata( css('jquery-ui-1.8.18.custom.css', $this->module) )
			
			->append_metadata( js('jquery-ui-1.8.18.custom.min.js', $this->module) )
			->append_metadata( js('jquery.validate.js', $this->module) )
			->append_metadata( js('form.js', $this->module) )
			->append_metadata( js('facebook.js', $this->module) )
			
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			
			->build('admin/form',$data);
	}
	
	function save($event_id=null){
		
		$event = array(
			'name'=>$this->input->post('name'),
			'event_date'=>$this->input->post('event_date'),
			'start_time'=>$this->input->post('start_time'),
			'end_time'=>$this->input->post('end_time'),
			'description'=>$this->input->post('description'),
			'contact'=>$this->input->post('contact'),
			'location'=>$this->input->post('location')
		);
				
		// insert/update event
		if($event_id==null){
			$event_id = $this->event_model->insert_event($event);
		}else{
			$event['id'] = $event_id;
			$this->event_model->update_event($event);
		}
		
		//////////////////////
		// Insert New Stuff //
		//////////////////////
		
		
		if($newsponsors = $this->input->post('newsponsors')){
			$inserts = array();
			foreach($newsponsors as $index=>$sponsor){
				if(!$sponsor['delete'] && $sponsor['name']!=''){
					$sponsor['event_id'] = $event_id;
					unset($sponsor['delete']);
					$inserts[] = $sponsor;
				}
			}
			if(count($inserts)>0)$this->event_model->insert_sponsor($inserts,true);
		}
		
		
		if($newlinks = $this->input->post('newlinks')){
			$inserts = array();
			foreach($newlinks as $index=>$link){
				if(!$link['delete'] && $link['text']!='' && $link['url']!=''){
					$link['event_id'] = $event_id;
					unset($link['delete']);
					$inserts[] = $link;
				}
			}
			if(count($inserts)>0)$this->event_model->insert_link($inserts,true);
		}
		
		
		//////////////////////
		// Update Old Stuff //
		//////////////////////
		
		if($sponsors = $this->input->post('sponsors')){
			foreach($sponsors as $index=>$sponsor){
				if($sponsor['delete']){
					$this->event_model->delete_sponsor($sponsor['id']);
					continue;
				}
				($sponsor['name']!='') ? $this->event_model->update_sponsor($sponsor) : null;
			}
		}
		
		if($links = $this->input->post('links')){
			foreach($links as $index=>$link){
				if($link['delete']){
					$this->event_model->delete_link($link['id']);
					continue;
				}
				($link['text']!='' || $link['url']!='') ? $this->event_model->update_link($link) : null;
			}
		}
		
		// send user to edit page
		redirect(site_url('admin/' . $this->module).'/edit/'.$event_id);
	}
	
	
	function edit($event_id){
			
		$data["event"] = $this->event_model->get_event($event_id)->row();
		$data['sponsors'] = (array)$this->event_model->get_sponsors($event_id)->result();
		$data['links'] = (array)$this->event_model->get_links($event_id)->result();
		
		$this->template
			->append_metadata( css('event.css', $this->module) )
			->append_metadata( css('jquery-ui-1.8.18.custom.css', $this->module) )
			
			->append_metadata( js('jquery-ui-1.8.18.custom.min.js', $this->module) )
			->append_metadata( js('jquery.validate.js', $this->module) )
			->append_metadata( js('form.js', $this->module) )
			
			->append_metadata( $this->load->view('fragments/wysiwyg', $this->data, TRUE) )
			
			->build('admin/form',$data);
	}
	
	function update(){
		
		$event = array(
			'id'=>$this->input->post('event_id'),
			'name'=>$this->input->post('name'),
			'event_date'=>$this->input->post('event_date'),
			'start_time'=>$this->input->post('start_time'),
			'end_time'=>$this->input->post('end_time'),
			'description'=>$this->input->post('description'),
			'contact'=>'',
			'location'=>''
		);
		
		// Updates
		$sponsors = $this->input->post('sponsors');
		$links = $this->input->post('links');
		
		// New Inserts
		$newsponsors = $this->input->post('newsponsors');
		$newlinks = $this->input->post('newlinks');
		
		// update event
		$event_id = $this->event_model->update_event($event);
		
		// insert sponsors
		$inserts = array();
		foreach($newsponsors as $index=>$sponsor){
			if($sponsor['delete']=='true')continue;
			$sponsor['event_id'] = $event_id;
			unset($sponsor['delete']);
			$inserts[] = $sponsor;
		}
		$this->event_model->insert_sponsor($inserts,true);
		
		// insert links
		$inserts = array();
		foreach($newlinks as $index=>$link){
			if($link['delete']=='true')continue;
			$link['event_id'] = $event_id;
			unset($link['delete']);
			$inserts[] = $link;
		}
		$this->event_model->insert_link($inserts,true);
		
		// send user to edit page
		redirect(site_url('admin/' . $this->module).'/edit/'.$event_id);
	}
	
	function delete( $event_id ){
		$this->event_model->delete_event( $event_id );
		redirect(site_url('admin/' . $this->module));
	}
	
	function set_status($id=null,$status='active'){
		if($id!=null){			
			$this->event_model->set_event($id,'status',$status);
			redirect($_SERVER['HTTP_REFERER']);
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
}