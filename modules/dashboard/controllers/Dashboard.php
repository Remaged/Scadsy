<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends SCADSY_Controller{

	public function index() {
		$data = array();
		$data['widgets'] = $this->dashboard_manager->get_widgets();
		
		$this->view("index", $data);
	}
	
	public function exampleWidget() {
		$this->view('widgets/example');
	}
}


/* End of file Dashboard.php */
/* Location: ./modules/module/controllers/Dashboard.php */