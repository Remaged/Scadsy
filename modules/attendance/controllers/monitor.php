<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends SCADSY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index(){
		$this->view('overview');
	}	
}


/* End of file monitor.php */
/* Location: ./modules/attendance/controllers/monitor.php */