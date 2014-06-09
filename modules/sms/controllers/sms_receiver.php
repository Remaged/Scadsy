<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load the MX_Controller class */
require_once APPPATH."third_party/MX/Controller.php";

class Sms_receiver extends MX_Controller{
	
	public function __construct() {
		parent::__construct();
		$this->load->model('sms_messager_model');
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


/* End of file sms_receiver.php */
/* Location: ./modules/sms/controllers/sms_receiver.php */