<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Attendance controller. This module allows teachers to monitor their students attendance.
 */
class Attendance extends SCADSY_Controller{

	public function index() {
		parent::init(array(
				'module' => "attendance",
				'action' => "index",
				'controller' =>'attendance',
				'group' => array('admin', 'teacher')
				)
			);
		
		$this->view('overview');
	}

}


/* End of file login.php */
/* Location: ./modules/login/controllers/login.php */