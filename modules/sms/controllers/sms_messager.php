<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_messager extends SCADSY_Controller{
	var $data = array();
	public function __construct() {
		parent::__construct();
		parent::init();
		
		$this->load->model('sms_messager_model');
	}
	
	/**
	 * Default view
	 */
	public function index($page = 1, $page_size = 10, $search_name = NULL) {
		if($this->session->flashdata("message") !== FALSE){
			$this->notification_manager->add_notification("succes", $this->session->flashdata("message")); 
		}
		
		$this->data['search_name'] = $search_name;
		$this->data['page_size'] = $page_size;	
		$this->data['smses'] = $this->sms_messager_model->get_smses($page, $page_size, $search_name);		
		$this->view('sms_list', $this->data);
	}
	
	public function detail($id){
		$this->data['sms'] = $this->sms_messager_model->get_detail_info($id);
		$this->view('sms_info', $this->data);
	}
	
	public function new_sms(){
		if($this->input->post('selected')){	
			$message = $this->sms_messager_model->send_sms();
			
			$this->session->set_flashdata("message", $message);
			redirect(site_action_uri("index"));		
		}
		else{
			$this->search(FALSE);	
			$this->view('new_sms',$this->data);		
		}
		
	}
	
	public function search($load_view = TRUE){
		$this->data['users'] = $this->sms_messager_model->search_users();;		
		if($load_view){
			$this->view('search_users',$this->data);
		}						
	}
	
	/**
	 * Receive sent_item information from the mobile API.
	 * This method should be publically available. 
	 * 
	 * Exits a 'True' string to let the API know that the message was handled.
	 */
	public function receive_push_sent_items(){
		$this->sms_messager_model->handle_push_sent_item();
		
		exit('True');	
	}

	/**
	 * Receive a reply message (sent by a user from their mobile phone) from the mobile API
	 * This method should be publically available.
	 * 
	 * Exits a 'True' string to let the API know that the message was handled.
	 */
	public function receive_push_replies(){
		$this->sms_messager_model->handle_push_reply();
		
		exit('True');		
	}

	

}	


/* End of file sms.php */
/* Location: ./modules/sms/controllers/sms.php */