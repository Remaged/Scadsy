<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends SCADSY_Controller{

	public function __construct() {
		parent::__construct();
		$this->module_manager->add_new_modules();
	}

	public function index() {
		parent::init(array(
			'module' => "module",
			'action' => "index",
			'group' => array('admin')
			)
		);
		
		$data['modules'] = $this->module_model->get_modules();
		
		$this->view('module/list', $data);
	}
	
	public function enable($directory) {
		$this->module_model->enable_module($directory);
		
		redirect('module/index');
	}
	
	public function disable($directory) {
		$this->module_model->disable_module($directory);
		
		redirect('module/index');
	}
	
	/**
	 * Stores all enable/disable data of all modules
	 */
	public function save_modules(){
		$this->module_model->save_module_statusses($this->input->post('status'));
		redirect('module');
	}
}


/* End of file Module.php */
/* Location: ./application/controllers/Module.php */