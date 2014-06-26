<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updates extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
	}	

	public function index() {	
		$data = array();
		$data['updates'] = (new Update())
								->where('has_update = 1')
								->get();
		
		$this->view("index", $data);
	}
	
	public function install() {
		if($this->input->post('update') !== FALSE) {	
			if(UpdateCallbacks::install_update($this->input->post('update')) === TRUE) {
				$this->load->view("succes");	
			} else {
				$this->load->view("failure");
			}
		}
	}
	
	public function widget() {
		$updates = (new Update())->where('has_update = 1')->get();
		$data = array();
		$data['updates'] = $updates;
		parent::widget('widgets/overview', $data);
	}
}

/* End of file Update.php */
/* Location: ./modules/update/controllers/Update.php */