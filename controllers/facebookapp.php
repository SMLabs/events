<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Facebookapp extends Public_Controller
{
	
	protected $page_id;
	protected $is_admin;
	protected $event;
	protected $sponsors;
	protected $links;
	
	public function __construct()
	{
		parent::__construct();
		$this->config->set_item('module_name', "event" );
		$this->load->library('facebook',array(
		  'appId'  => '100546976733397',
		  'secret' => '7da6b9ebe25a9edd64109ccfed78eb36',
		  'cookie' => true,
		  'xfbml'  => true
		));
		
		$this->load->model('event_model');
		
		if(!$this->session->userdata('fbpage_id')){
			$this->page_id = $this->facebook->getPageId();
			$this->is_admin = $this->facebook->isAdmin();
		}else{
			$this->page_id = $this->session->userdata('fbpage_id');
			$this->is_admin = $this->session->userdata('fbadmin');
		}
		
		if($this->page_id){		
			$this->session->set_userdata(array(
				'fbpage_id'=>$this->page_id,
				'fbadmin'=> $this->is_admin
			));
			
			$this->event = $this->event_model->get_fbevent($this->page_id)->row();
			
			if(count($this->event) > 0){
				$this->sponsors = (array)$this->event_model->get_sponsors($this->event->id)->result();
				$this->links = (array)$this->event_model->get_links($this->event->id)->result();
				
			}else{
				$this->event = false;
				$this->sponsors = array();
				$this->links = array();
			}
		}
	}
	
	/**
	 * Index method
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{	
		// Redirect Admin's to the edit page
		if(!$this->event){
			if($this->is_admin){
				$this->session->set_flashdata('message','Welcome Admin! Please setup your event by completing the details below.');
				redirect($this->module.'/facebookapp/edit');
			}
			$this->event = (object)array();
		}
		
		$data['event'] = $this->event;
		$data['event']->sponsors = $this->sponsors;
		$data['event']->links = $this->links;
		$data['is_admin'] = $this->is_admin;
		
		$this->template
			->set_layout('fbfront')
			->append_metadata( js('facebook.js', $this->config->item('module_name')) )
			->build($this->module.'/fbdetails', $data);
	}
	
	public function edit(){
		if(!$this->is_admin)redirect($this->module.'/facebookapp/');
		
		$data['event'] = $this->event;
		$data['sponsors'] = $this->sponsors;
		$data['links'] = $this->links;
		
		$this->template
			->set_layout('fbadmin')
			->append_metadata( css('jquery-ui-1.8.18.custom.css', $this->config->item('module_name')) )
			
			->append_metadata( js('jquery-ui-1.8.18.custom.min.js', $this->config->item('module_name')) )
			->append_metadata( js('jquery.validate.js', $this->config->item('module_name')) )
			->append_metadata( js('form.js', $this->config->item('module_name')) )
			
			->build($this->module.'/fbedit', $data);
	}
	
	public function save(){
		$event = array(
			'name'=>$this->input->post('name'),
			'event_date'=>$this->input->post('event_date'),
			'start_time'=>$this->input->post('start_time'),
			'end_time'=>$this->input->post('end_time'),
			'description'=>$this->input->post('description'),
			'contact'=>$this->input->post('contact'),
			'location'=>$this->input->post('location'),
			'fbpage_id'=>$this->page_id,
			'status'=>'inactive',
		);
		
		// insert/update event
		if(!$this->event){
			$event_id = $this->event_model->insert_event($event);
			$event['id'] = $event_id;
		}else{
			$event_id = $this->event->id;
			$event['id'] = $event_id;
			$this->event_model->update_event($event);
		}
		
		///////////////////////////////////
		// Insert New Sponsors and Links //
		///////////////////////////////////
		
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
		
		
		/////////////////////////////////
		// Update and delete Old Stuff //
		/////////////////////////////////
		
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
		redirect(site_url($this->module.'/facebookapp/edit'));
	}
	
}