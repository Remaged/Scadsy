<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Scheme controller. This module allows teachers to monitor their students attendance.
 */
class Scheme extends SCADSY_Controller{

	public function index() {
		parent::init(array(
			'module' => "scheme",
			'action' => "index",
			'group' => array('admin', 'teacher')
			)
		);
			
		$this->view('scheme');
	}

}

/* End of file login.php */
/* Location: ./modules/login/controllers/login.php */