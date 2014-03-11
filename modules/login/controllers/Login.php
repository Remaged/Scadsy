<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->module_manager->add_new_modules();
	}

	public function index() {
		parent::init(array(
			'module' => "login",
			'action' => "index",
			'group' => array('admin')
			)
		);
		
		$data['modules'] = $this->module_model->get_modules();
		
		$this->view('form', $data);
	}
	
	public function enable($directory) {
		$this->module_model->enable_module($directory);
		
		redirect('login/index');
	}
	
	public function disable($directory) {
		$this->module_model->disable_module($directory);
		
		redirect('login/index');
	}
}


/* End of file Module.php */
/* Location: ./application/controllers/Module.php */