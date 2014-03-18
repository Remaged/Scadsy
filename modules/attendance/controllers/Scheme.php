<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Scheme controller. This module allows teachers to monitor their students attendance.
 */
class Scheme extends SCADSY_Controller{

	public function index() {
		parent::init(array(
			'module' => "attendance",
			'action' => "index",
			'controller' => "scheme",
			'group' => array('admin', 'teacher')
			)
		);
			
		$this->view('scheme');
	}

	public function something() {
		parent::init(array(
			'module' => "attendance",
			'action' => "index",
			'controller' => "scheme",
			'group' => array('admin', 'teacher')
			)
		);
		
		$this->view('something');
	}
}

/* End of file login.php */
/* Location: ./modules/login/controllers/login.php */